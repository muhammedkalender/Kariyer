<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 19-04-2019
 * Time : 18:54
 */

//https://stackoverflow.com/a/18542272
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "include/functions.php";

//Cache::categoryJSON();
//Cache::locationJSON();

$isAllowRequest = 1;

if (isset($_GET["page"])) {
    $page = $_GET["page"];

    if ($page == "is-ilanlari") {
        include_once "./page/find_job.php";
    }else if($page == "profile"){
        include_once  "./page/user_profile.php";
    }else if($page == "firma"){
        include_once  "./page/company_profile.php";
    }else if($page == "ilani-gor"){
        include_once  "./page/job_page.php";
    } //else if ($page == "firma-paneli") {
       // include_once "./page/company.php";
   // }
} else {
    include_once "./page/main.php";
}

include_once "./page/footer.php";
