<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 13-05-2019
 * Time : 19:19
 */

if (!isset($isAllowRequest)) {
    die();
}

//todo
$isAdminView = false;

$title = lang("page_company_job");

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";

?>

<div class="container">
    <div class="col-md-1"></div>

    <div class="col-md-10">

        <div class="input-group ">
            <input type="text" class="form-control col-md-3" id="lmjaSearch"
                   placeholder="<?= lang('insert_keyword') ?>">
            <input type="button" class="form-control bg-success col-md-1 text-white"
                   onclick="searchJobForAdmin(this)" value="<?= lang('search') ?>">

            <div class="col-md-7"></div>

            <a href="company.php?page=job_edit">
                <button type="button" class="btn btn-primary"><?= message('add_job') ?></button>
            </a>
        </div>


        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col"><?= message('title') ?></th>
                <th scope="col"><?= message('company') ?></th>
                <th scope="col"><?= message('job_close_date') ?></th>
                <th scope="col"><?= message('apply_count') ?></th>
                <th scope="col"><?= message('view_count') ?></th>
                <th scope="col"><?= message('actions') ?></th>
            </tr>
            </thead>
            <tbody id="table_job">

            </tbody>
        </table>

        <input type="button" class="form-control" onclick="loadMoreJob(this)" value="<?= message('load_more') ?>">
    </div>

    <div class="modal" id="modal-close-job">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title"><?= lang("close_job") ?></h4>
                    <button type="button" class="close text-white" data-dismiss="modal"
                            onclick="closeModal('modal-close-job')">&times;
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert" id="modal-close-job-result" style="display: none">
                    </div>

                    <input id="modalCloseJobId" value="0" type="hidden">

                    <div class="form-group">
                        <label for="user_email"><?= lang("are_you_sure") ?></label>
                    </div>



                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"
                            onclick="closeApply(); closeModal('modal-close-job')"><?=message("confirm")?></button>
                    <button type="submit" class="btn btn-danger"
                            onclick="closeModal('modal-close-job')"><?=message("cancel")?></button>
                </div>
            </div>
        </div>
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
                            onclick="deleteJob(this); closeModal('modal-delete-job')"><?=message("confirm")?></button>
                    <button type="submit" class="btn btn-danger"
                            onclick="closeModal('modal-delete-job')"><?=message("cancel")?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteJob(button) {
        if (button != null) {
            button.disabled = true;
        }

        id = item("modalDeleteJobId").value;

        $.post("api.php", {
            "call_category": "job",
            "call_request": "delete",
            "job_id": id
        }, function (data, status) {
            if (status == "success") {
                var result = JSON.parse(data);

                if (result[0]) {
                    Message.success(result[1]);
                } else {
                    Message.error(result[1]);
                }
            }

            if (button != null) {
                button.disabled = false;
            }
        });
    }

    function closeApply(button) {
        if (button != null) {
            button.disabled = true;
        }

        id = item("modalCloseJobId").value;

        $.post("api.php", {
            "call_category": "job",
            "call_request": "close_apply",
            "job_id": id
        }, function (data, status) {
            if (status == "success") {
                var result = JSON.parse(data);

                if (result[0]) {
                    Message.success(result[1]);
                } else {
                    Message.error(result[1]);
                }
            }

            if (button != null) {
                button.disabled = false;
            }
        });
    }

    var page = 0, count = 10;
    var keyword = "";
    var active = ""; //todo

    function searchJobForAdmin(button) {
        if (keyword == item('lmjaSearch').value) {
            return;
        }

        keyword = item('lmjaSearch').value;
        page = 0;

        loadMoreJob(button, false)
    }

    function loadMoreJob(button) {
        loadMoreJob(button, true)
    }

    function loadMoreJob(button, append) {
        if (button != null) {
            button.disabled = true;
        }

        $.post("api.php",
            {
                "call_category": "job",
                "call_request": "select",
                "keyword": keyword,
                "page": page,
                "count": count,
                "user": <?=$isAdminView ? '' : $user->memberId?>,
                "active": active
            }, function (data, status) {
                if (status == "success") {

                    var result = JSON.parse(data);

                    if (result[0]) {
                        page++;
                        result = result[1][1];
                        var html = "";

                        for (var i = 0; i < result.length; i++) {
                            if(result[i]["job_adv_close"] == null){
                                result[i]["job_adv_close"] = "-";
                            }

                            html += "<tr><td><b>" + result[i]["job_adv_id"] + "</b></td>";
                            html += "<td>" + result[i]["job_adv_title"] + "</td>";
                            html += "<td>" + result[i]["company_name"] + "</td>";
                            html += "<td>" + result[i]["job_adv_close"] +"</td>";
                            html += "<td>" + result[i]["job_adv_app"] + "</td>";
                            html += "<td>" + result[i]["job_adv_view"] + "</td>";
                            html += "<td>" + lmjaItemActions(result[i]["job_adv_id"]) + "</td></tr>";
                        }

                        if (append) {
                            $("#table_job").append(html);
                        } else {
                            $("#table_job").html(html);
                        }
                    }else{
                        Message.error(result[1],"");
                    }
                }

                if (button != null) {
                    button.disabled = false;
                }
            });
    }

    function lmjaItemActions(id) {
        return " <a href=\"company.php?page=job_edit&job_id=" + id + "\" target=\"_blank\"><button class=\"btn\" title=\"<?=message('view_job_adv')?>\"><i class=\"fa fa-search\"></i></button></a><button class=\"btn\" onclick=\"item('modalCloseJobId').value = " + id + "; openModal('modal-close-job')\" title=\"<?=message('close_job_apply')?>\"><i class=\"fa fa-lock\"></i></button><button class=\"btn\" onclick=\"viewJobAdv(" + id + ")\" title=\"<?=message('view_job_applys')?>\"><i class=\"fa fa-check\"></i></button><button class=\"btn\" onclick=\"item('modalDeleteJobId').value = " + id + "; openModal('modal-delete-job')\" title=\"<?=message('delete_job')?>\"><i class=\"fa fa-trash\"></i></button>";
    }

    $(document).ready(function () {
        loadMoreJob(null)
    });

</script>
