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


include "include/functions.php";

$_POST["call_category"] = "user";
//$_POST["call_request"] = "login";

$_POST["user_type"] = 1; //todo 0 olamıyormu ?
$_POST["user_email"] = "asd@gmail.com";
$_POST["user_name"] = "cem";
$_POST["user_surname"] = "uzan";
$_POST["user_password"] = "123456";

include "api.php";


//var_dump($user->login("asda","asda"));