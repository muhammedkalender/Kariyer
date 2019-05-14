<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 13-05-2019
 * Time : 19:19
 */

if(!isset($isAllowRequest)){
    die();
}

$title = lang("page_company_job");

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";

?>

<script>


    function lmjaItemActions(id) {
        return " <a href=\"company.php?page=job_edit&job_id="+id+"\"><button class=\"btn\" title=\"<?=message('view_job_adv')?>\"><i class=\"fa fa-search\"></i></button>\n" +
            "                    <button class=\"btn\" onclick=\"closeJobAdv(" + id + ")\" title=\"<?=message('close_job_apply')?>\"><i class=\"fa fa-lock\"></i></button>\n" +
            "                    <button class=\"btn\" onclick=\"viewJobAdv(" + id + ")\" title=\"<?=message('view_job_applys')?>\"><i class=\"fa fa-check\"></i></button>\n" +
            "                    <button class=\"btn\" onclick=\"deleteJobAdv(" + id + ")\" title=\"<?=message('delete_job')?>\"><i class=\"fa fa-trash\"></i></button>";
    }

    var lmjaPage = 0;
    var lmjaCount = 25;

    function loadMoreJobAdmin() {
//todo
    }

</script>

<div class="container">
    <div class="col-md-1"></div>

    <div class="col-md-10">

        <div class="input-group ">
            <input type="text" class="form-control col-md-3" id="lmjaSearch"
                   placeholder="<?= lang('insert_keyword') ?>">
            <input type="button" class="form-control bg-success col-md-1" value="<?= lang('search') ?>">

            <div class="col-md-7"></div>

            <a href="company.php?page=job_edit"><button type="button" class="btn btn-primary"><?= message('add_job') ?></button></a>
        </div>


        <table class="table table-striped" >
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col"><?=message('title')?></th>
                <th scope="col"><?=message('apply_count')?></th>
                <th scope="col"><?=message('view_count')?></th>
                <th scope="col"><?=message('actions')?></th>
            </tr>
            </thead>
            <tbody id="table_job">
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>
                    a
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
            </tbody>
        </table>

        <input type="button" class="form-control" onclick="loadMoreJobAdmin()" value="<?= message('load_more') ?>">
    </div>

    <div class="modal" id="modal-add-job">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title"><?= lang("add_job") ?></h4>
                    <button type="button" class="close text-white" data-dismiss="modal"
                            onclick="closeModal('modal-add-job')">&times;
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="modal-add-job-form" onsubmit="return false">
                        <input type="hidden" name="call_category" value="job">
                        <input type="hidden" name="call_request" value="insert">
                        <!-- alert-danger, alert-success, alert-primary -->
                        <div class="alert" id="modal-add-job-result" style="display: none">
                        </div>

                        <div class="form-group">
                            <label for="user_email"><?= lang("email") ?></label>
                            <input type="email" class="form-control" name="user_email" placeholder="example@mail.com"
                                   minlength="3" maxlength="64" required>
                        </div>
                        <div class="form-group">
                            <label for="user_password"><?= lang("password") ?></label>
                            <input type="password" class="form-control" name="user_password"
                                   placeholder="<?= lang("password") ?>" minlength="6" maxlength="32" required>
                        </div>
                        <button type="submit" class="btn btn-primary"
                                onclick="postForm('login', '/', 5000)"><?= lang("login") ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
