<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 05-06-2019
 * Time : 15:09
 */

if (!isset($isAllowRequest)) {
    die();
}

$title = lang("page_admin_user");

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";

if ($user->power < Perm::SUPPORT) {
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
                   onclick="searchUser(this)" value="<?= lang('search') ?>">

            <div class="col-md-7"></div>

            <button type="button" onclick="openModal('modal-register')"
                    class="btn btn-primary"><?= lang("add_user") ?></button>

        </div>


        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col"><?= message('user_name') ?></th>
                <th scope="col"><?= message('user_surname') ?></th>
                <th scope="col"><?= message('user_email') ?></th>
                <th scope="col"><?= message('user_gsm') ?></th>
                <th scope="col"><?= message('register_date') ?></th>
                <th scope="col"><?= message('actions') ?></th>
            </tr>
            </thead>
            <tbody id="table_user">

            </tbody>
        </table>

        <input type="button" class="form-control" onclick="loadMoreUser(this, true)"
               value="<?= message('load_more') ?>">
    </div>
</div>

<!-- The Modal -->
<div class="modal" id="modal-register">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("register_user") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-register')">&times;
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="messagePanel">
                <form id="modal-register-form">
                    <input type="hidden" name="call_category" value="user">
                    <input type="hidden" name="call_request" value="register">
                    <!-- alert-danger, alert-success, alert-primary -->
                    <div class="alert" id="modal-register-result" style="display: none">
                    </div>

                    <div class="form-group">
                        <label for="user_name"><?= lang("name") ?></label>
                        <input type="text" class="form-control" name="user_name" id="user_name" minlength="3"
                               maxlength="32"
                               placeholder="Muhammed" required>
                    </div>
                    <div class="form-group">
                        <label for="user_surname"><?= lang("surname") ?></label>
                        <input type="text" class="form-control" name="user_surname" id="user_surname"
                               placeholder="Kalender"
                               minlength="3" maxlength="32" required>
                    </div>
                    <div class="form-group">
                        <label for="user_email"><?= lang("email") ?></label>
                        <input type="email" class="form-control" name="user_email" id="user_email"
                               placeholder="example@mail.com"
                               minlength="3" maxlength="64" required>
                    </div>
                    <div class="form-group">
                        <label for="user_password"><?= lang("password") ?></label>
                        <input type="password" id="password" class="form-control" name="user_password"
                               placeholder="<?= lang("password") ?>" minlength="6" maxlength="32" required>
                    </div>
                    <div class="form-group">
                        <label for="registerPasswordRepeat"><?= lang("password_repeat") ?></label>
                        <input type="password" id="password_repeat" class="form-control"
                               name="registerPasswordRepeat" placeholder="<?= lang("password_repeat") ?>"
                               minlength="6" maxlength="32" required>
                    </div>
                    <button type="button" class="btn btn-primary"
                            onclick="register()"><?= lang("register") ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function register(button) {
        if (button != null) {
            button.disabled = true;
        }

        if (itemValue("password") != itemValue("password_repeat")) {
            Message.modalError("modal-register-result", "<?=lang('password_match')?>");

            if (button != null) {
                button.disabled = false;
            }

            return;
        }

        $.post("api.php", {
            "call_category": "user",
            "call_request": "register",
            "user_type": 0,
            "user_name": itemValue("user_name"),
            "user_surname": itemValue("user_surname"),
            "user_email": itemValue("user_email"),
            "user_password": itemValue("password"),
            "registerPasswordRepeat": itemValue("password_repeat"),
        }, function (data, status) {
            if (status == "success") {
                data = JSON.parse(data);

                if (data[0]) {
                    closeModal("register");
                    location.reload();
                } else {
                    Message.modalError("modal-register-result", data[1]);
                }
            } else {
                console.log(data);
                //todo
            }

            if (button != null) {
                button.disabled = false;
            }
        });
    }

    var page = 0, count = 10;
    var keyword = "";
    var active = ""; //todo

    function searchUser(button) {
        if (keyword == item('lmjaSearch').value) {
            return;
        }

        keyword = item('lmjaSearch').value;
        page = 0;

        loadMoreUser(button, false)
    }

    function loadMoreUser(button) {
        loadMoreUser(button, true)
    }

    function loadMoreUser(button, append) {
        if (button != null) {
            button.disabled = true;
        }

        $.post("api.php",
            {
                "call_category": "user",
                "call_request": "select",
                "keyword": keyword,
                "page": page,
                "count": count,
                "user_type": 0
            }, function (data, status) {
                if (status == "success") {
                    var result = JSON.parse(data);

                    if (result[0]) {
                        page++;
                        result = result[1];
                        var html = "";

                        console.log(result);
                        for (var i = 0; i < result.length; i++) {
                            html += "<tr><td><b>" + result[i]["member_id"] + "</b></td>";
                            html += "<td>" + result[i]["member_name"] + "</td>";
                            html += "<td>" + result[i]["member_surname"] + "</td>";
                            html += "<td>" + result[i]["member_email"] + "</td></td>";

                            if(result[i]["member_gsm"] == null){
                                result[i]["member_gsm"] = "-";
                            }

                            html += "<td>" + result[i]["member_gsm"] + "</td></td>";
                            html += "<td>" + result[i]["member_insert"] + "</td></td>";
                            html += "<td>" + lmjaItemActions(result[i]["member_id"]) + "</td></tr>";
                        }

                        if (append) {
                            $("#table_user").append(html);
                        } else {
                            $("#table_user").html(html);
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

    function lmjaItemActions(id) {
        return " <a href=\"index.php?page=profile&user=" + id + "\" target=\"_blank\"><button class=\"btn\" title=\"<?=message('view_user_profile')?>\"><i class=\"fa fa-user\"></i></button></a>";
    }

    $(document).ready(function () {
        loadMoreUser(null, true);
    });

</script>