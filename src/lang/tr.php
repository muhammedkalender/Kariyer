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
    "perm_error" => "Bu işlemi yapmak için yetkiniz yok",
    "wrong_login" => "Kullanıcı Adı veya Şifre Hatalı",
    "check_null" => "[%PARAM1%], Boş olamaz",
    "check_type" => "[%PARAM1%], Uygun biçimde değil",
    "check_long" => "[%PARAM1%], [%PARAM2%] Karakterden uzun olamaz.",
    "check_short" => "[%PARAM1%], [%PARAM2%] Karakterden kısa olamaz.",
    "valid_null" => "Parametreler uygun değil",
    "already_email" => "Bu eposta adresi zaten kayıtlı",
"experience" => "Deneyim",
    "success_register" => "Başarıyla kayıt olundu",
    "failed_register" => "Kayıt olunurken bir sorunla karşılaşıldı",
    "check_over" => "[%PARAM1%], [%PARAM2%] Den fazla olamaz",
    "var_user_type" => "Kullanıcı Tipi",
    "var_user_email" => "Eposta Adresi",
    "var_user_name" => "İsim",
    "var_user_surname" => "Soyisim",
    "var_user_password" => "Şifre",
    "var_skill_name" => "Yetenek Adı",
    "var_skill_level" => "Yetenek Düzeyi",
    "var_skill_order" => "Yetenek Sırası",
    "var_skill_id" => "Yetenek",

    "var_licence_name" => "Lisans Adı",
    "var_licence_code" => "Lisans Kodu",
    "var_licence_date" => "Lisans Tarihi",
    "var_member_id" => "Kullanıcı",
    "var_count" => "Adet",
    "var_page" => "Sayfa",
    "skill" => "Yetenek",
    "404_" => "[%PARAM1%] Bulunamadı",
    "licence" => "Lisans",
    "success_insert" => "[%PARAM1%] Başarıyla Eklendi",
    "failed_insert" => "[%PARAM1%] Eklenirken Bir Sorunla Karşılaşıldı",
    "success_update" => "[%PARAM1%] Başarıyla Güncellendi",
    "failed_update" => "[%PARAM1%] Güncellenirken Bir Sorunla Karşılaşıldı",
    "success_delete" => "[%PARAM1%] Başarıyla Silindi",
    "success_failed" => "[%PARAM1%] Silinirken Sorunla Karşılaşıldı",
"var_experience_member" => "Kullanıcı",
    "certificate" => "Sertifika",
    "var_licence_id" => "Lisans Id",
    "var_certificate_member" => "Kullanıcı",
    "var_certificate_name" => "Sertifika Adı",
    "var_certificate_company" => "Sertifikayı Veren Kurum",
    "var_certificate_url" => "Sertifika Bağlantısı",
    "var_certificate_description" => "Sertifika Açıklaması",
    "var_certificate_date" => "Sertifika Tarihi",
    "var_certificate_order" => "Sertifika Sırası",
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