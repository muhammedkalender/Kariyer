<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 13-05-2019
 * Time : 19:19
 */

$title = lang("page_company_job");

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";

?>

<div class="container">
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
                        <input type="hidden" name="call_category" value="user">
                        <input type="hidden" name="call_request" value="login">
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
