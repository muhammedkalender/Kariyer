<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 17-04-2019
 * Time : 19:31
 */


$lang = [
    "wrong_login" => "Kullanıcı Adı veya Şifre Hatalı",
    "check_null" => "[%PARAM1%], Boş olamaz",
    "check_type" => "[%PARAM1%], Uygun biçimde değil",
    "check_long" => "[%PARAM1%], [%PARAM2%] Karakterden uzun olamaz.",
    "check_short" => "[%PARAM1%], [%PARAM2%] Karakterden kısa olamaz.",
    "valid_null" => "Parametreler uygun değil",
    "already_email" => "Bu eposta adresi zaten kayıtlı",

    "success_register" => "Başarıyla kayıt olundu",
    "failed_register" => "Kayıt olunurken bir sorunla karşılaşıldı",

    "var_user_type" => "Kullanıcı Tipi",
    "var_user_email" => "Eposta Adresi",
    "var_user_name" => "İsim",
    "var_user_surname" => "Soyisim",
    "var_user_password" => "Şifre",

    "lang_tr" => "Türkçe",
    "lang_en" => "İngilizce",
    "lang_ru" => "Rusça",
    "lang_fr" => "Fransızca",
    "lang_de" => "Almanca",
    "lang_es" => "İspanyolca"
];

function lang($name, $firstParam = "", $secondParam = "")
{
    global $lang;

    if (isset($lang[$name]) == false) {
        return $name;
    }

    $result = $lang[$name];

    if ($firstParam != "") {
        $result = str_replace("[%PARAM1%]", $firstParam, $result);
    }

    if ($secondParam != "") {
        $result = str_replace("[%PARAM2%]", $secondParam, $result);
    }

    return $result;
}

function write($name, $firstParam, $secondParam)
{
    echo lang($name, $firstParam, $secondParam);
}

function message($name, $firstParam = "", $secondParam = "")
{
    return lang($name, $firstParam != "" ? lang($firstParam) : "", $secondParam != "" ? lang($secondParam) : "");
}