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

        <input type="button" class="form-control" onclick="loadMoreUser(this, true)" value="<?= message('load_more') ?>">
    </div>
</div>
<script>
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
                "user_type":0
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