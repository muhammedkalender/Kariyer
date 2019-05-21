<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 16-05-2019
 * Time : 17:28
 */

if (!isset($isAllowRequest)) {
    die();
}


//todo
$isAdminView = false;

$title = lang("page_company_job_apply");

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";


if (!isset($_GET["job_id"]) || intval($_GET["job_id"]) < 1) {
    message("404_", "job_apply");
    die;
}

$jobId = intval($_GET["job_id"]);

if($user->type != 1 && $user->power < Perm::SUPPORT){
    echo lang("perm_error");
    die();
}
?>

<div class="container">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="input-group ">
            <input type="text" class="form-control col-md-3" id="lmjaSearch"
                   placeholder="<?= lang('insert_keyword') ?>">
            <input type="button" class="form-control bg-success col-md-1 text-white"
                   onclick="searchJobForAdmin(this)" value="<?= lang('search') ?>">
        </div>


        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col"><?= message('user_name') ?></th>
                <th scope="col"><?= message('user_surname') ?></th>
                <th scope="col"><?= message('mark') ?></th>
                <th scope="col"><?= message('date') ?></th>
                <th scope="col"><?= message('actions') ?></th>
            </tr>
            </thead>
            <tbody id="table_job">

            </tbody>
        </table>

        <input type="button" class="form-control" onclick="loadMoreJob(this, true)" value="<?= message('load_more') ?>">
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
                            onclick="closeApply(); closeModal('modal-close-job')"><?= message("confirm") ?></button>
                    <button type="submit" class="btn btn-danger"
                            onclick="closeModal('modal-close-job')"><?= message("cancel") ?></button>
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
                <h4 class="modal-title"><?= lang("mark_apply") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-mark')">&times;
                </button>
            </div>

            <div class="modal-body">
                <input id="delete-edu-id" value="0" type="hidden">

                <div class="form-group">
                    <label><?= lang("are_you_sure_mark") ?></label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="markApply(); closeModal('modal-mark')"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-mark')"><?= message("cancel") ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    var jobId = 0;

    function markJob(id) {
        jobId = id;

        openModal("modal-mark");
    }

    function markApply() {
        $.post("api.php", {
            "call_category": "job",
            "call_request": "mark_apply",
            "apply_id": jobId
        }, function (data, result) {
            if (result == "success") {
                data = JSON.parse(data);

                closeModal("modal-mark");
console.log(data);
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
                "call_request": "select_job_apply",
                "keyword": keyword,
                "page": page,
                "count": count,
                "user": <?=$isAdminView ? '' : $user->memberId?>,
                "job_id": <?=$jobId?>
            }, function (data, status) {
                if (status == "success") {

                    var result = JSON.parse(data);

                    if (result[0]) {
                        page++;
                        result = result[1][1];
                        var html = "";

                        for (var i = 0; i < result.length; i++) {
                            if (result[i]["job_adv_close"] == null) {
                                result[i]["job_adv_close"] = "-";
                            }

                            html += "<tr><td><b>" + result[i]["job_apply_id"] + "</b></td>";
                            html += "<td>" + result[i]["member_name"] + "</td>";
                            html += "<td>" + result[i]["member_surname"] + "</td>";
                            html += "<td>" + (result[i]["job_apply_review"] > 0 ? "<?=lang('mark_review_1')?>" : "<?=lang('mark_review_0')?>") + "</td>";
                            html += "<td>" + result[i]["job_apply_insert"] + "</td>";
                            html += "<td>" + lmjaItemActions(result[i]["job_apply_id"], result[i]["member_id"], result[i]["job_apply_review"]) + "</td></tr>";
                        }

                        if (append) {
                            $("#table_job").append(html);
                        } else {
                            $("#table_job").html(html);
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

    function lmjaItemActions(id, user_id) {
        return " <a href=\"index.php?page=profile&user=" + user_id + "\" target=\"_blank\"><button class=\"btn\" title=\"<?=message('view_user_profile')?>\"><i class=\"fa fa-user\"></i></button></a><button class=\"btn\" onclick=\"markJob(" + id + ")\" title=\"<?=message('mark_job_apply')?>\"><i class=\"fa fa-check\"></i></button>";
    }

    $(document).ready(function () {
        loadMoreJob(null, true);
    });

</script>
