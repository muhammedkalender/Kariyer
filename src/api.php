<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 19-04-2019
 * Time : 19:5
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/include/functions.php";

if (isset($_POST["call_category"]) == false || isset($_POST["call_request"]) == false) {
    //todo
    goto nothing;
}

$callCategory = $_POST["call_category"];
$callRequest = $_POST["call_request"];

if ($callCategory == "user") {
    //region User
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
        goto output;
    }else if($callRequest == "forgot_password"){
        $inputs = Valid::check([
            new ValidObject("user_email", "email", 6, 32, ValidObject::Email)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->forgotPassword($_POST["user_email"]);
        goto output;
    } else if($callRequest == "change_password"){
        $inputs = Valid::check([
            new ValidObject("password", "password", 6, 32, ValidObject::CleanText),
            new ValidObject("current_password", "current_password", 6, 32, ValidObject::CleanText)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->changePassword($_POST["current_password"], $_POST["password"]);
        goto output;
    }else if ($callRequest == "login") {
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
    } else if ($callRequest == "logout") {
        //[OK]
        $callResult = $user->logout();
        goto output;
    } else if ($callRequest == "upload_profile_image") {
        //[OK]
        if (!isset($_FILES['file']) || count($_FILES["file"]) < 1) {
            $callResult = [false, lang("must_image_select")];
            goto output;
        }

        if ($_FILES['file']["size"] > (1024 * 1024 * 2)) {
            $callResult = [false, lang("allow_image_size")];
            goto output;
        }

        $imageFileType = pathinfo($_FILES['file']["name"], PATHINFO_EXTENSION);

        if (!($imageFileType == "jpg" || $imageFileType == "jpeg")) {
            $callResult = [false, lang("allow_image_ext")];
            goto output;
        }

        $img = getimagesize($_FILES['file']["tmp_name"]);

        if ($img[0] != $img[1]) {
            $callResult = [false, lang("must_image_square")];
            goto output;
        }

        if ($img[0] < 128 || $img[0] > 512 || $img[1] < 128 || $img[1] > 512) {
            $callResult = [false, lang("must_image_size")];
            goto output;
        }

        $location = md5($_FILES['file']['name'] . $user->memberId . time()) . ".jpeg";

        if (move_uploaded_file($_FILES['file']['tmp_name'], "./images/profile/" . $location)) {
            if (DB::execute("UPDATE member SET member_picture = '$location' WHERE member_id = $user->memberId")[0]) {
                $callResult = [true, lang("success_upload_image"), $location];
                goto output;
            } else {
                $callResult = [false, lang("failure_upload_image_sql")];
                goto output;
            }
        } else {
            $callResult = [true, lang("failure_upload_image")];
            goto output;
        }
    } else if ($callRequest == "update_user_info") {
        $inputs = Valid::check([
            new ValidObject("user_id", "user_id", 1, 64, ValidObject::Integer),
            new ValidObject("user_email", "user_email", 3, 64, ValidObject::Email),
            new ValidObject("user_name", "user_name", 3, 32, ValidObject::CleanText),
            new ValidObject("user_surname", "user_surname", 3, 32, ValidObject::CleanText),
            new ValidObject("user_gsm", "user_gsm", 0, 32, ValidObject::CleanText),
            new ValidObject("user_bd", "user_bd", 8, 32, ValidObject::Date),
            new ValidObject("user_website", "user_website", 0, 32, ValidObject::URL),
            new ValidObject("user_gender", "user_gender", 1, 2, ValidObject::Integer),
            new ValidObject("user_smoke", "user_smoke", 1, 2, ValidObject::Integer),
            new ValidObject("user_military", "user_military", 1, 2, ValidObject::Integer),
            new ValidObject("user_military_date", "user_military_date", 0, 16, ValidObject::Date),
            new ValidObject("user_address", "user_address", 0, 64, ValidObject::CleanText),
            new ValidObject("user_special", "user_special", 1, 2, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->updateUserInfo($_POST["user_id"], $_POST["user_email"], $_POST["user_name"], $_POST["user_surname"], $_POST["user_gsm"], $_POST["user_bd"], $_POST["user_website"], $_POST["user_gender"], $_POST["user_smoke"], $_POST["user_military"], $_POST["user_military_date"], $_POST["user_address"], $_POST["user_special"]);
        goto output;
    } else if ($callRequest == "update_company_info") {
        $inputs = Valid::check([
            new ValidObject("user_id", "user_id", 1, 64, ValidObject::Integer),
            new ValidObject("user_email", "user_email", 3, 64, ValidObject::Email),
            new ValidObject("company_name", "user_name", 3, 32, ValidObject::CleanText),
            new ValidObject("user_gsm", "user_gsm", 0, 32, ValidObject::CleanText),
            new ValidObject("user_fax", "user_fax", 0, 32, ValidObject::CleanText),
            new ValidObject("company_bd", "company_bd", 8, 32, ValidObject::Date),
            new ValidObject("user_website", "user_website", 0, 32, ValidObject::URL),
            new ValidObject("user_address", "user_address", 0, 64, ValidObject::CleanText)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->updateCompanyInfo($_POST["user_id"], $_POST["user_email"], $_POST["company_name"],  $_POST["user_gsm"], $_POST["user_fax"],$_POST["company_bd"], $_POST["user_website"], $_POST["user_address"]);
        goto output;
    }else if ($callRequest == "update_desc") {
        $inputs = Valid::check([
            new ValidObject("user_id", "user_id", 1, 64, ValidObject::Integer),
            new ValidObject("user_desc", "user_desc", 0, 512, ValidObject::Html)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->updateUserDesc($_POST["user_id"], $_POST["user_desc"]);
        goto output;
    } else {
        goto nothing;
    }

    //endregion
} else if ($callCategory == "cv") {
    //region CV
    if ($callRequest == "upload_file") {
        if (!isset($_FILES['file']) || count($_FILES["file"]) < 1) {
            $callResult = [false, lang("must_file_select")];
            goto output;
        }

        if ($_FILES['file']["size"] > (1024 * 1024 * 2)) {
            $callResult = [false, lang("allow_file_size")];
            goto output;
        }

        $fileType = pathinfo($_FILES['file']["name"], PATHINFO_EXTENSION);

        if (!($fileType == "pdf")) {
            $callResult = [false, lang("allow_file_ext")];
            goto output;
        }

        $location = md5($_FILES['file']['name'] . $user->memberId . time()) . ".pdf";

        if (move_uploaded_file($_FILES['file']['tmp_name'], "./cvs/" . $location)) {
            $callResult = [true, lang("success_upload_cv"), $location];
            goto output;
        } else {
            $callResult = [true, lang("failure_upload_cv")];
            goto output;
        }
    } else if($callRequest == "insert"){
        if($_POST["cv_file"] == ""){
            unset($_POST["cv_file"]);
        }

        $inputs = Valid::check([
            new ValidObject("cv_name", "cv_name", 1, 32, ValidObject::CleanText),
            new ValidObject("cv_desc", "cv_desc", 0, 256, ValidObject::CleanText),
            new ValidObject("cv_file", "cv_file", 1, 512, ValidObject::CleanText)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->addCV($_POST["cv_name"], $_POST["cv_file"], $_POST["cv_desc"]);
        goto output;
    } else if($callRequest == "get"){
        $inputs = Valid::check([
            new ValidObject("cv_id", "cv_id", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->getCV($_POST["cv_id"]);
        goto output;
    }else if($callRequest == "update"){
        if($_POST["cv_file"] == ""){
            unset($_POST["cv_file"]);
        }

        $inputs = Valid::check([
            new ValidObject("cv_id", "cv_id", 1, 32, ValidObject::Integer),
            new ValidObject("cv_name", "cv_name", 1, 32, ValidObject::CleanText),
            new ValidObject("cv_desc", "cv_desc", 0, 256, ValidObject::CleanText),
            new ValidObject("cv_file", "cv_file", 1, 512, ValidObject::CleanText)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->setCv($_POST["cv_id"],$_POST["cv_name"], $_POST["cv_desc"],$_POST["cv_file"]);
        goto output;
    }else if($callRequest == "delete"){
        $inputs = Valid::check([
            new ValidObject("cv_id", "cv_id", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->delCV($_POST["cv_id"]);
        goto output;
    }else {
        goto nothing;
    }

    //endregion
} else if ($callCategory == "user_skill") {
    //region Skill
    if ($callRequest == "insert") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("skill_name", "", 1, 32, ValidObject::CleanText),
            new ValidObject("skill_level", "", 1, 2, ValidObject::Integer),
            new ValidObject("skill_order", "", 1, 3, ValidObject::Integer),
            new ValidObject("skill_member", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->addSkill($_POST["skill_name"], $_POST["skill_level"], $_POST["skill_order"], $_POST["skill_member"]);
        goto output;
    } else if ($callRequest == "update") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("skill_name", "", 1, 32, ValidObject::CleanText),
            new ValidObject("skill_level", "", 1, 2, ValidObject::Integer, 5, ValidObject::POST, false, ""),
            new ValidObject("skill_order", "", 1, 3, ValidObject::Integer),
            new ValidObject("skill_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->setSkill($_POST["skill_id"], $_POST["skill_name"], $_POST["skill_level"], $_POST["skill_order"]);
        goto output;
    } else if ($callRequest == "select") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("member_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("count", "", 1, 3, ValidObject::Integer),
            new ValidObject("page", "", 1, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->selectSkill($_POST["member_id"], $_POST["count"], $_POST["page"]);
        goto output;
    } else if ($callRequest == "get") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("skill_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->getSkill($_POST["skill_id"]);
        goto output;
    } else if ($callRequest == "delete") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("skill_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->delSkill($_POST["skill_id"]);
        goto output;
    } else {
        goto nothing;
    }

    //endregion
} else if ($callCategory == "user_licence") {
    //region Licence
    if ($callRequest == "insert") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("licence_name", "", 1, 32, ValidObject::CleanText),
            new ValidObject("licence_code", "", 1, 2, ValidObject::Integer),
            new ValidObject("licence_date", "", 0, 3, ValidObject::Integer),
            new ValidObject("licence_order", "", 0, 32, ValidObject::Integer),
            new ValidObject("licence_member", "", 0, 8, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->addLicence($_POST["licence_name"], $_POST["licence_date"], $_POST["licence_code"], $_POST["licence_order"], $_POST["licence_member"]);
        goto output;
    } else if ($callRequest == "select") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("member_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("count", "", 1, 3, ValidObject::Integer),
            new ValidObject("page", "", 1, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->getLicence($_POST["member_id"], $_POST["count"], $_POST["page"]);
        goto output;
    } else if ($callRequest == "update") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("licence_name", "", 1, 32, ValidObject::CleanText),
            new ValidObject("licence_code", "", 1, 2, ValidObject::Integer),
            new ValidObject("licence_date", "", 0, 3, ValidObject::Integer),
            new ValidObject("licence_order", "", 0, 32, ValidObject::Integer),
            new ValidObject("licence_id", "", 1, 8, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->setLicence($_POST["licence_id"], $_POST["licence_name"], $_POST["licence_code"], $_POST["licence_date"], $_POST["licence_order"]);
        goto output;
    } else if ($callRequest == "delete") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("licence_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->delLicence($_POST["licence_id"]);
        goto output;
    } else {
        goto nothing;
    }

    //endregion
} else if ($callCategory == "user_certificate") {
    //region Certificate
    if ($callRequest == "select") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("member_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("count", "", 1, 3, ValidObject::Integer),
            new ValidObject("page", "", 1, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->selectCertificate($_POST["member_id"], $_POST["count"], $_POST["page"]);
        goto output;
    } else if ($callRequest == "get") {
        $inputs = Valid::check([
            new ValidObject("certificate_id", "certificate_id", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->getCertificate($_POST["certificate_id"]);
        goto output;
    } else if ($callRequest == "update") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("certificate_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("certificate_name", "", 1, 64, ValidObject::CleanText),
            new ValidObject("certificate_company", "", 0, 64, ValidObject::CleanText),
            new ValidObject("certificate_url", "", 0, 1024, ValidObject::URL),
            new ValidObject("certificate_description", "", 0, 1024, ValidObject::CleanText),
            new ValidObject("certificate_date", "", 0, 10, ValidObject::Date),
            new ValidObject("certificate_order", "", 0, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->setCertificate($_POST["certificate_id"], $_POST["certificate_name"], $_POST["certificate_company"], $_POST["certificate_url"], $_POST["certificate_description"], $_POST["certificate_date"], $_POST["certificate_order"]);
        goto output;
    } else if ($callRequest == "insert") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("certificate_member", "", 1, 32, ValidObject::Integer),
            new ValidObject("certificate_name", "", 1, 64, ValidObject::CleanText),
            new ValidObject("certificate_company", "", 1, 64, ValidObject::CleanText),
            new ValidObject("certificate_url", "", 0, 1024, ValidObject::URL),
            new ValidObject("certificate_description", "", 0, 1024, ValidObject::CleanText),
            new ValidObject("certificate_date", "", 0, 10, ValidObject::Date),
            new ValidObject("certificate_order", "", 0, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->addCertificate($_POST["certificate_name"], $_POST["certificate_company"], $_POST["certificate_url"], $_POST["certificate_description"], $_POST["certificate_date"], $_POST["certificate_order"], $_POST["certificate_member"]);
        goto output;
    } else if ($callRequest == "delete") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("certificate_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->delCertificate($_POST["certificate_id"]);
        goto output;
    } else {
        goto nothing;
    }
    //endregion
} else if ($callCategory == "user_experience") {
    //region Experience
    if ($callRequest == "select") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("member_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("count", "", 1, 3, ValidObject::Integer),
            new ValidObject("page", "", 1, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->selectExperience($_POST["member_id"], $_POST["count"], $_POST["page"]);
        goto output;
    } else if ($callRequest == "get") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("experience_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->getExperience($_POST["experience_id"]);
        goto output;
    } else if ($callRequest == "insert") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("experience_member", "experience_member", 1, 32, ValidObject::Integer),
            new ValidObject("experience_name", "experience_name", 1, 32, ValidObject::CleanText),
            new ValidObject("experience_company", "experience_company", 1, 64, ValidObject::CleanText),
            new ValidObject("experience_description", "experience_description", 0, 1024, ValidObject::CleanText),
            new ValidObject("experience_start", "experience_start", 1, 32, ValidObject::Date),
            new ValidObject("experience_end", "experience_end", 0, 32, ValidObject::Date),
            new ValidObject("experience_order", "experience_order", 0, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->addExperience($_POST["experience_name"], $_POST["experience_company"], $_POST["experience_description"], $_POST["experience_start"], $_POST["experience_end"], $_POST["experience_order"], $_POST["experience_member"]);
        goto output;
    } else if ($callRequest == "update") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("experience_id", "experience_id", 1, 32, ValidObject::Integer),
            new ValidObject("experience_name", "experience_name", 1, 32, ValidObject::CleanText),
            new ValidObject("experience_company", "experience_company", 1, 64, ValidObject::CleanText),
            new ValidObject("experience_description", "experience_description", 0, 1024, ValidObject::CleanText),
            new ValidObject("experience_start", "experience_start", 1, 32, ValidObject::Date),
            new ValidObject("experience_end", "experience_end", 0, 32, ValidObject::Date),
            new ValidObject("experience_order", "experience_order", 0, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->setExperience($_POST["experience_id"], $_POST["experience_name"], $_POST["experience_company"], $_POST["experience_description"], $_POST["experience_start"], $_POST["experience_end"], $_POST["experience_order"]);
        goto output;
    } else if ($callRequest == "delete") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("experience_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->delExperience($_POST["experience_id"]);
        goto output;
    } else {
        goto nothing;
    }
    //endregion
} else if ($callCategory == "user_education") {
    //region Education
    if ($callRequest == "select") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("member_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("count", "", 1, 3, ValidObject::Integer),
            new ValidObject("page", "", 1, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->selectEducation($_POST["member_id"], $_POST["count"], $_POST["page"]);
        goto output;
    } else if ($callRequest == "get") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("education_id", "education", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->getEducation($_POST["education_id"]);
        goto output;
    } else if ($callRequest == "insert") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("education_member", "education_member", 1, 32, ValidObject::Integer),
            new ValidObject("education_name", "education_name", 1, 32, ValidObject::CleanText),
            new ValidObject("education_department", "education_department", 1, 64, ValidObject::CleanText),
            new ValidObject("education_type", "education_type", 1, 16, ValidObject::Integer),
            new ValidObject("education_start", "education_start", 1, 32, ValidObject::Date),
            new ValidObject("education_end", "education_end", 0, 32, ValidObject::Date),
            new ValidObject("education_order", "education_order", 0, 3, ValidObject::Integer),
            new ValidObject("education_note", "education_note", 0, 4, ValidObject::Float)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->addEducation($_POST["education_name"], $_POST["education_department"], $_POST["education_type"], $_POST["education_start"], $_POST["education_end"], $_POST["education_note"], $_POST["education_order"], $_POST["education_member"]);
        goto output;
    } else if ($callRequest == "update") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("education_id", "education_id", 1, 32, ValidObject::Integer),
            new ValidObject("education_name", "education_name", 1, 32, ValidObject::CleanText),
            new ValidObject("education_department", "education_department", 1, 64, ValidObject::CleanText),
            new ValidObject("education_type", "education_type", 1, 16, ValidObject::Integer),
            new ValidObject("education_start", "education_start", 1, 32, ValidObject::Date),
            new ValidObject("education_end", "education_end", 0, 32, ValidObject::Date),
            new ValidObject("education_order", "education_order", 0, 3, ValidObject::Integer),
            new ValidObject("education_note", "education_note", 0, 4, ValidObject::Float)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->setEducation($_POST["education_id"], $_POST["education_name"], $_POST["education_department"], $_POST["education_type"], $_POST["education_start"], $_POST["education_end"], $_POST["education_note"], $_POST["education_order"]);
        goto output;
    } else if ($callRequest == "delete") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("education_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->delEducation($_POST["education_id"]);
        goto output;
    } else {
        goto nothing;
    }
    //endregion
} else if ($callCategory == "user_reference") {
    //region Reference
    if ($callRequest == "select") {
        $inputs = Valid::check([
            new ValidObject("member_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("count", "", 1, 3, ValidObject::Integer),
            new ValidObject("page", "", 1, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->selectReference($_POST["member_id"], $_POST["count"], $_POST["page"]);
        goto output;
    } else if ($callRequest == "get") {
        $inputs = Valid::check([
            new ValidObject("reference_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->getReference($_POST["reference_id"]);
        goto output;
    } else if ($callRequest == "insert") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("reference_member", "reference_member", 1, 32, ValidObject::Integer),
            new ValidObject("reference_name", "reference_name", 1, 64, ValidObject::CleanText),
            new ValidObject("reference_company", "reference_company", 1, 64, ValidObject::CleanText),
            new ValidObject("reference_title", "reference_title", 1, 64, ValidObject::CleanText),
            new ValidObject("reference_email", "reference_email", 0, 32, ValidObject::Email),
            new ValidObject("reference_gsm", "reference_gsm", 0, 32, ValidObject::Phone),
            // new ValidObject("reference_description", "", 0, 256, ValidObject::CleanText),
            new ValidObject("reference_order", "reference_order", 0, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }
        //$_POST["reference_description"]
        $callResult = $user->addReference($_POST["reference_name"], $_POST["reference_company"], $_POST["reference_title"], $_POST["reference_email"], $_POST["reference_gsm"], "", $_POST["reference_order"], $_POST["reference_member"]);
        goto output;
    } else if ($callRequest == "update") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("reference_id", "reference", 1, 32, ValidObject::Integer),
            new ValidObject("reference_name", "reference_name", 1, 64, ValidObject::CleanText),
            new ValidObject("reference_company", "reference_company", 1, 64, ValidObject::CleanText),
            new ValidObject("reference_title", "reference_title", 1, 64, ValidObject::CleanText),
            new ValidObject("reference_email", "reference_email", 0, 32, ValidObject::Email),
            new ValidObject("reference_gsm", "reference_gsm", 0, 32, ValidObject::Phone),
            // new ValidObject("reference_description", "", 0, 256, ValidObject::CleanText),
            new ValidObject("reference_order", "reference_order", 0, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }
        //$_POST["reference_description"]
        $callResult = $user->setReference($_POST["reference_id"], $_POST["reference_name"], $_POST["reference_company"], $_POST["reference_title"], $_POST["reference_email"], $_POST["reference_gsm"], "", $_POST["reference_order"]);
        goto output;
    } else if ($callRequest == "delete") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("reference_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->delReference($_POST["reference_id"]);
        goto output;
    } else {
        goto nothing;
    }
    //endregion
} else if ($callCategory == "user_language") {
    //region Language
    if ($callRequest == "select") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("member_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("count", "", 1, 3, ValidObject::Integer),
            new ValidObject("page", "", 1, 3, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->getLanguage($_POST["member_id"], $_POST["count"], $_POST["page"]);
        goto output;
    } else if ($callRequest == "insert") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("language_member", "", 1, 32, ValidObject::Integer),
            new ValidObject("language_code", "", 1, 4, ValidObject::CleanText),
            new ValidObject("language_description", "", 0, 256, ValidObject::CleanText),
            new ValidObject("language_order", "", 0, 3, ValidObject::Integer),
            new ValidObject("language_level", "", 0, 3, ValidObject::Integer, 5)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->addLanguage($_POST["language_code"], $_POST["language_description"], $_POST["language_order"], $_POST["language_level"], $_POST["language_member"]);
        goto output;
    } else if ($callRequest == "update") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("language_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("language_code", "", 1, 4, ValidObject::CleanText),
            new ValidObject("language_description", "", 0, 256, ValidObject::CleanText),
            new ValidObject("language_order", "", 0, 3, ValidObject::Integer),
            new ValidObject("language_level", "", 0, 3, ValidObject::Integer, 5)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->setLanguage($_POST["language_id"], $_POST["language_code"], $_POST["language_description"], $_POST["language_order"], $_POST["language_level"]);
        goto output;
    } else if ($callRequest == "delete") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("language_id", "", 1, 32, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = $user->delLanguage($_POST["language_id"]);
        goto output;
    } else {
        goto nothing;
    }
    //endregion
} else if ($callCategory == "job") {
    //region JOB
    if ($callRequest == "insert") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("job_title", "", 3, 512, ValidObject::Integer),
            new ValidObject("job_desc", "", 3, 4096, ValidObject::Html),
            new ValidObject("district", "", 1, 256, ValidObject::Check),
            new ValidObject("job_type", "", 1, 12, ValidObject::Integer),
            new ValidObject("category", "", 1, 8, ValidObject::Integer),
            new ValidObject("special", "", 1, 8, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = Job::insertJob(0, $_POST["job_title"], $_POST["job_desc"], $_POST["job_type"], $_POST["category"], $_POST["district"], $_POST["special"]);
        goto output;
    } else if ($callRequest == "get") {
        $inputs = Valid::check([
            new ValidObject("job_id", "", 1, 16, ValidObject::Integer),
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = Job::getJob($_POST["job_id"]);
        goto output;
    } else if ($callRequest == "update") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("job_id", "", 1, 12, ValidObject::Integer),
            new ValidObject("job_title", "", 3, 512, ValidObject::Integer),
            new ValidObject("job_desc", "", 3, 4096, ValidObject::Html),
            new ValidObject("district", "", 1, 256, ValidObject::Check),
            new ValidObject("job_type", "", 1, 12, ValidObject::Integer),
            new ValidObject("category", "", 1, 8, ValidObject::Integer),
            new ValidObject("special", "", 1, 8, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = Job::editJob($_POST["job_id"], $_POST["job_title"], $_POST["job_desc"], $_POST["job_type"], $_POST["category"], $_POST["district"], $_POST["special"]);
        goto output;
    } else if ($callRequest == "select") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("keyword", "", 0, 36, ValidObject::CleanText),
            new ValidObject("page", "", 1, 16, ValidObject::Integer),
            new ValidObject("count", "", 1, 16, ValidObject::Integer),
            new ValidObject("active", "", 0, 16, ValidObject::Integer),
            new ValidObject("user", "", 0, 16, ValidObject::Integer)
            //new ValidObject("district", "", 1, 256, ValidObject::Check),
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        if ($_POST["keyword"] != "" && strlen($_POST["keyword"]) < 3) {
            $callResult = [false, message("check_short", "var_keyword", "3")];
            goto output;
        }

        $callResult = Job::selectJobForAdmin($_POST["keyword"], $_POST["active"], $_POST["user"], $_POST["page"], $_POST["count"]);
        goto output;
    } else if ($callRequest == "search") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("keyword", "", 0, 36, ValidObject::CleanText),
            new ValidObject("page", "", 1, 16, ValidObject::Integer),
            new ValidObject("count", "", 1, 16, ValidObject::Integer),
            new ValidObject("type", "", 0, 16, ValidObject::Integer),
            new ValidObject("cat", "", 0, 16, ValidObject::Integer),
            new ValidObject("locations", "", 0, 256, ValidObject::CleanText),
            new ValidObject("company", "", 1, 8, ValidObject::Integer),
            new ValidObject("special", "", 1, 8, ValidObject::Integer)
            //new ValidObject("district", "", 1, 256, ValidObject::Check),
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        if ($_POST["keyword"] != "" && strlen($_POST["keyword"]) < 3) {
            $callResult = [false, message("check_short", "var_keyword", "3")];
            goto output;
        }

//        for ($i = 0; $i < count($_POST["locations"]); $i++) {
//            $_POST["locations"][$i] = Valid::clear( $_POST["locations"][$i]);
//        }

        $callResult = Job::selectJob($_POST["keyword"], $_POST["locations"], $_POST["type"], $_POST["cat"], $_POST["page"], $_POST["count"], $_POST["company"], $_POST["special"]);
        goto output;
    } else if ($callRequest == "close_apply") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("job_id", "", 1, 16, ValidObject::Integer),
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = Job::closeJobAdv($_POST["job_id"]);
        goto output;
    } else if ($callRequest == "apply_job") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("job_id", "", 1, 16, ValidObject::Integer),
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = Job::applyJob($_POST["job_id"]);
        goto output;
    } else if ($callRequest == "select_job_apply") {
        //OK
        $inputs = Valid::check([
            new ValidObject("job_id", "", 1, 16, ValidObject::Integer),
            new ValidObject("page", "", 1, 16, ValidObject::Integer),
            new ValidObject("count", "", 1, 16, ValidObject::Integer),
            new ValidObject("keyword", "", 0, 32, ValidObject::CleanText),
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = Job::selectJobApply($_POST["job_id"], $_POST["keyword"], $_POST["page"], $_POST["count"]);
        goto output;
    } else if ($callRequest == "mark_apply") {
        //OK
        $inputs = Valid::check([
            new ValidObject("apply_id", "", 1, 16, ValidObject::Integer)
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = Job::markApply($_POST["apply_id"]);
        goto output;
    } else if ($callRequest == "delete") {
        $inputs = Valid::check([
            new ValidObject("job_id", "", 1, 16, ValidObject::Integer),
        ]);

        if ($inputs[0] == false) {
            $callResult = $inputs;
            goto output;
        }

        $callResult = Job::deleteJob($_POST["job_id"]);
        goto output;
    }
    //endregion
} else {
    goto nothing;
}

nothing:
$callResult = [false, lang("call_null")];

output:
echo json_encode($callResult, true);
