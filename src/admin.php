<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 20-05-2019
 * Time : 04:21
 */

//https://stackoverflow.com/a/18542272
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "include/functions.php";

$isAllowRequest = 1;

if (isset($_GET["page"])) {
    $page = $_GET["page"];

    if ($page == "job") {
        include_once "./page/company_job.php";
    } else if ($page == "job_edit") {
        include_once "./page/company_job_edit.php";
    } else if ($page == "job_apply") {
        include_once "./page/company_job_apply.php";
    } else if ($page == "user_management") {
        include_once "./page/user_management_user.php";
    } else {
        include_once "./page/admin_main.php";
    }
} else {
    include_once "./page/admin_main.php";
}

include_once "./page/footer.php";
