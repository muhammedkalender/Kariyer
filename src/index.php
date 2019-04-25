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

if (isset($_GET["page"])) {
    $page = $_GET["page"];

    if ($page == "is-ilanlari" || $page = "is-ara") {
        include_once "./page/find_job.php";
    }
} else {
    include_once "./page/main.php";
}

include_once "./page/footer.php";
