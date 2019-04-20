<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 19-04-2019
 * Time : 19:5
 */

if (isset($_POST["call_category"]) == false || isset($_POST["call_request"]) == false) {
    //todo
    goto nothing;
}

$callCategory = $_POST["call_category"];
$callRequest = $_POST["call_request"];

include_once "./include/functions.php";

if ($callCategory == "user") {
    if ($callRequest == "register") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("user_type", "", 1, 2, ValidObject::Integer),
            new ValidObject("user_email", "", 3, 64, ValidObject::Email),
            new ValidObject("user_name", "", 3, 64, ValidObject::CleanText),
            new ValidObject("user_surname", "", 0, 64, ValidObject::CleanText),
            new ValidObject("user_password", "", 6, 32, ValidObject::CleanText)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->register($_POST["user_type"], $_POST["user_email"], $_POST["user_name"], $_POST["user_surname"], $_POST["user_password"]);
    } else if ($callRequest == "login") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("user_email", "", 3, 64, ValidObject::Email),
            new ValidObject("user_password", "", 6, 32, ValidObject::CleanText)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->login($_POST["user_email"], $_POST["user_password"]);
        goto output;
    }
}

output:
echo json_encode($callResult, JSON_FORCE_OBJECT);

nothing:
