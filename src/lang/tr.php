<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 17-04-2019
 * Time : 19:31
 * Current Track : Infinity Ink - Infinity
 * Best Place : Oh you now we are the infinity
 */


$lang = [
    "wrong_login" => "Kullanıcı Adı veya Şifre Hatalı"

];

function lang($name, $firstParam, $secondParam)
{
    global $lang;

    if (isset($lang[$name]) == false) {
        return $name;
    }

    $result = $lang[$name];

    if($firstParam != "") {
        $result = str_replace("[%PARAM1%]", $firstParam, $result);
    }

    if($secondParam != "") {
        $result = str_replace("[%PARAM2%]", $secondParam, $result);
    }

    return $result;
}

function write($name, $firstParam, $secondParam){
    echo lang($name, $firstParam, $secondParam);
}