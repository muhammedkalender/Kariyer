<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 06-06-2019
 * Time : 22:15
 */

if (!isset($isAllowRequest)) {
    die();
}

$title = lang("page_notification");

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";

?>
<div class="container">
    <div class="col-md-1"></div>
    <!--
    <div class="col-md-10">
        <div class="input-group ">
            <input type="text" class="form-control col-md-3" id="lmjaSearch"
                   placeholder="<?= lang('insert_keyword') ?>">
            <input type="button" class="form-control bg-success col-md-1 text-white"
                   onclick="searchNotification(this)" value="<?= lang('search') ?>">
        </div>

-->
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col"><?= message('message') ?></th>
                <th scope="col"><?= message('date') ?></th>
                <th scope="col"><?= message('actions') ?></th>
            </tr>
            </thead>
            <tbody id="table_notification">

            </tbody>
        </table>

        <input type="button" class="form-control" onclick="loadMoreNotification(this, true)"
               value="<?= message('load_more') ?>">
    </div>

    <div class="modal" id="modal-delete-job">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title"><?= lang("delete_job") ?></h4>
                    <button type="button" class="close text-white" data-dismiss="modal"
                            onclick="closeModal('modal-delete-job')">&times;
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert" id="modal-delete-job-result" style="display: none">
                    </div>

                    <input id="modalDeleteJobId" value="0" type="hidden">

                    <div class="form-group">
                        <label><?= lang("are_you_sure") ?></label>
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"
                            onclick="deleteJob(this); closeModal('modal-delete-job')"><?= message("confirm") ?></button>
                    <button type="submit" class="btn btn-danger"
                            onclick="closeModal('modal-delete-job')"><?= message("cancel") ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-mark">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("mark_notification") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-mark')">&times;
                </button>
            </div>

            <div class="modal-body">
                <input id="mark-id" value="0" type="hidden">

                <div class="form-group">
                    <label><?= lang("are_you_sure_mark_notification") ?></label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="markNotification(); closeModal('modal-mark')"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-mark')"><?= message("cancel") ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-full-message">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("view_full_mesfsage") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-full-message')">
                </button>
            </div>

            <div class="modal-body">
                <input id="delete-edu-id" value="0" type="hidden">

                <div class="form-group" id="full-message">

                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-full-message')"><?= message("close") ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    var notificationId = 0;
    var notificationMark = 0;

    function markNotification() {
        $.post("api.php", {
            "call_category": "notification",
            "call_request": "mark",
            "notification_id": notificationId,
            "mark" : notificationMark
        }, function (data, result) {
            if (result == "success") {
                data = JSON.parse(data);

                closeModal("modal-mark");

                if (data[0]) {
                    Message.success(data[1], "");
                } else {
                    Message.error(data[1], "");
                }
            } else {
                //todo
            }
        })
    }

    var page = 0, count = 10;
    var keyword = "";
    var active = ""; //todo

    function searchNotification(button) {
        if (keyword == item('lmjaSearch').value) {
            return;
        }

        keyword = item('lmjaSearch').value;
        page = 0;

        loadMoreNotification(button, false)
    }

    function loadMoreNotification(button) {
        loadMoreNotification(button, true)
    }

    function loadMoreNotification(button, append) {
        if (button != null) {
            button.disabled = true;
        }

        $.post("api.php",
            {
                "call_category": "notification",
                "call_request": "select",
                "keyword": keyword,
                "page": page,
                "count": count,
                "user": <?=$user->memberId?>
            }, function (data, status) {
                if (status == "success") {
                    var result = JSON.parse(data);

                    if (result[0]) {
                        page++;
                        result = result[1];
                        var html = "";

                        for (var i = 0; i < result.length; i++) {
                            html += "<tr><td><b>" + result[i]["notification_id"] + "</b></td>";

                            if(result[i]["notification_read"] == 0){
                                html += "<td class='font-weight-bold' id='message"+result[i]["notification_id"]+"'>";
                            }else{
                                html += "<td id='message"+result[i]["notification_id"]+"'>";
                            }

                            html += decodeEntities(result[i]["notification_message"])+"</td>";
                            html += "<td>" + result[i]["notification_insert"] + "</td>";
                            html += "<td>" + lmjaItemActions(result[i]["notification_id"], result[i]["notification_from"], result[i]["notification_read"]) + "</td></tr>";
                        }

                        if (append) {
                            $("#table_notification").append(html);
                        } else {
                            $("#table_notification").html(html);
                        }
                    } else {
                        Message.error(result[1], "");
                    }
                }

                if (button != null) {
                    button.disabled = false;
                }
            });
    }

    function lmjaItemActions(id, sender_id, read) {
        var button = "";

        if(read == 0){
            button = "<button class=\"btn\" onclick=\"showMark(" + id + ", 1)\" title=\"<?=message('mark_read')?>\"><i class=\"fa fa-envelope-open\"></i></button>";
        }else{
            button = "<button class=\"btn\" onclick=\"showMark(" + id + ", 0)\" title=\"<?=message('mark_unread')?>\"><i class=\"fa fa-envelope\"></i></button>";
        }

        return "<button class=\"btn\" onclick=\"showMessage(" + id + ")\" title=\"<?=message('view_full')?>\"><i class=\"fa fa-eye\"></i></button><a href=\"index.php?page=profile&user=" + sender_id + "\" target=\"_blank\"><button class=\"btn\" title=\"<?=message('view_user_profile')?>\"><i class=\"fa fa-user\"></i></button></a>"+button;
    }

    function showMark(id, mark) {
        notificationId = id;
        notificationMark = mark;

        openModal("modal-mark");
    }

    function showMessage(id){
        item("full-message").innerHTML = item("message"+id).innerHTML;
        openModal("modal-full-message");
    }

    $(document).ready(function () {
        loadMoreNotification(null, true);
    });

</script>