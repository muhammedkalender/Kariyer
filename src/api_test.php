<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 20-04-2019
 * Time : 23:59
 */



$_POST["member_id"] = 4;
$_POST["count"] = 0;
$_POST["page"] = 0;
include "include/functions.php";

//$_POST["call_category"] = "user";
//$_POST["call_request"] = "login";



$_POST["user_type"] = 1; //todo 0 olamıyormu ?
$_POST["user_email"] = "asd@gmail.com";
$_POST["user_name"] = "cem";
$_POST["user_surname"] = "uzan";
$_POST["user_password"] = "123456";


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

//$_POST["call_category"] = "user_certificate";
//$_POST["call_request"] = "insert";
//$_POST["call_request"] = "select";
//$_POST["call_request"] = "update";
//$_POST["call_request"] = "delete";
//$_POST["certificate_id"] = 2;
//
//$_POST["certificate_member"] = 0;
//$_POST["certificate_name"] = "C# - 101";
//$_POST["certificate_company"] = "Microsoft Açık Akademi";
//$_POST["certificate_url"] = "";
//$_POST["certificate_description"] = "";
//$_POST["certificate_date"] = "1990-11-19";
//$_POST["certificate_order"] = "";


//$_POST["call_category"] = "user_experience";
//$_POST["call_request"] = "insert";
//$_POST["call_request"] = "select";
//$_POST["call_request"] = "update";
//$_POST["call_request"] = "delete";

$_POST["experience_id"] = 1;
$_POST["experience_member"] = 0;
$_POST["experience_name"] = "Seni1111or Financier";
$_POST["experience_company"] = "Berserker Co.";
$_POST["experience_description"] = "";
$_POST["experience_start"] = "2019-01-12";
$_POST["experience_end"] = "2020-12-19";
$_POST["experience_order"] = "";

//$_POST["call_category"] = "user_education";
//$_POST["call_request"] = "insert";
//$_POST["call_request"] = "select";
//$_POST["call_request"] = "update";
//$_POST["call_request"] = "delete";

$_POST["education_id"] = 1;
$_POST["education_member"] = 0;
$_POST["education_name"] = "Boğaziçi";
$_POST["education_department"] = "İşletme";
$_POST["education_type"] = "10";
$_POST["education_start"] = "2015-05-06";
$_POST["education_end"] = "";
$_POST["education_order"] = "0";
$_POST["education_note"] = "4.00";

//
//$_POST["call_category"] = "user_reference";
//$_POST["call_request"] = "insert";
//$_POST["call_request"] = "select";
//$_POST["call_request"] = "update";
//$_POST["call_request"] = "delete";


$_POST["reference_id"] = 1;
$_POST["reference_member"] = 0;
$_POST["reference_name"] = "Andrew Jackson";
$_POST["reference_company"] = "US Presidente";
$_POST["reference_email"] = "andrew@gov.com";
$_POST["reference_gsm"] = "+1 155 552 363 33";
$_POST["reference_title"] = "Hero";
$_POST["reference_description"]="";
$_POST["reference_order"] = "0";

//$_POST["call_category"] = "user_language";
//$_POST["call_request"] = "insert";
//$_POST["call_request"] = "select";
//$_POST["call_request"] = "update";
//$_POST["call_request"] = "delete";

$_POST["language_id"] = 1;
$_POST["language_member"] = 0;
$_POST["language_code"] = "tr";
$_POST["language_description"] = "";
$_POST["language_order"] = 0;
$_POST["language_level"] = 3;

include "api.php";

//echo $user->isLogged?"tr":"fl";
//var_dump($user->login("asda","asda"));