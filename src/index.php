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

$_POST["member_id"] = 4;
$_POST["count"] = 0;
$_POST["page"] = 0;
include "include/functions.php";

////$_POST["call_category"] = "user";
////$_POST["call_request"] = "login";
//
//
//
//$_POST["user_type"] = 1; //todo 0 olamıyormu ?
//$_POST["user_email"] = "asd@gmail.com";
//$_POST["user_name"] = "cem";
//$_POST["user_surname"] = "uzan";
//$_POST["user_password"] = "123456";


//$_POST["call_category"] = "user_skill";
//$_POST["call_request"] = "update";
////$_POST["call_request"] = "select";
////$_POST["call_request"] = "delete";
//
//

//$_POST["skill_name"] = "C11#";
//$_POST["skill_level"] = 45;
//$_POST["skill_order"] = "0";
//$_POST["skill_member"] = 0;
//$_POST["skill_id"] = 1;

//$_POST["call_category"] = "user_licence";
////$_POST["call_request"] = "insert";
////$_POST["call_request"] = "select";
////$_POST["call_request"] = "update";
////$_POST["call_request"] = "delete";
//$_POST["licence_id"] = 1;
//$_POST["licence_name"] = "Sinek Otomobil Ehliyeti";
//$_POST["licence_code"] = "B1";
//$_POST["licence_date"] = "";
//$_POST["licence_order"] = "";
//$_POST["licence_member"] = "";

include "api.php";

//echo $user->isLogged?"tr":"fl";
//var_dump($user->login("asda","asda"));