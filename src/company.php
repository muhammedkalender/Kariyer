<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 13-05-2019
 * Time : 19:15
 */

//https://stackoverflow.com/a/18542272
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "include/functions.php";

if (isset($_GET["page"])) {
    $page = $_GET["page"];

    if ($page == "is-ilanlari") {
        include_once "./page/company_main.php";
    } //else if ($page == "firma-paneli") {
    // include_once "./page/company.php";
    // }
} else {
    include_once "./page/main.php";
}

include_once "./page/footer.php";
