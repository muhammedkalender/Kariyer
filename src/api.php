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
    } else if ($callRequest == "logout") {
        //[OK]
        $callResult = $user->logout();
        goto output;
    } else {
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

        $callResult = $user->getSkill($_POST["member_id"], $_POST["count"], $_POST["page"]);
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

        $callResult = $user->getCertificate($_POST["member_id"], $_POST["count"], $_POST["page"]);
        goto output;
    } else if ($callRequest == "update") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("certificate_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("certificate_name", "", 1, 64, ValidObject::CleanText),
            new ValidObject("certificate_company", "", 0, 64, ValidObject::CleanText),
            new ValidObject("certificate_url", "", 0, 1024, ValidObject::URL),
            new ValidObject("certificate_description", "", 0, 1024, ValidObject::CleanText),
            new ValidObject("certificate_date", "", 0, 32, ValidObject::Date),
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
            new ValidObject("certificate_company", "", 0, 64, ValidObject::CleanText),
            new ValidObject("certificate_url", "", 0, 1024, ValidObject::URL),
            new ValidObject("certificate_description", "", 0, 1024, ValidObject::CleanText),
            new ValidObject("certificate_date", "", 0, 32, ValidObject::Date),
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

        $callResult = $user->getExperience($_POST["member_id"], $_POST["count"], $_POST["page"]);
    } else if ($callRequest== "insert") {
        //[OK]
        $inputs = Valid::check([
            new ValidObject("experience_member", "", 1, 32, ValidObject::Integer),
            new ValidObject("experience_name", "", 1, 32, ValidObject::CleanText),
            new ValidObject("experience_company", "", 1, 64, ValidObject::CleanText),
            new ValidObject("experience_description", "", 0, 1024, ValidObject::CleanText),
            new ValidObject("experience_start", "", 1, 32, ValidObject::Date),
            new ValidObject("experience_end", "", 0, 32, ValidObject::Date),
            new ValidObject("experience_order", "", 0, 3, ValidObject::Integer)
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
            new ValidObject("experience_id", "", 1, 32, ValidObject::Integer),
            new ValidObject("experience_name", "", 1, 32, ValidObject::CleanText),
            new ValidObject("experience_company", "", 1, 64, ValidObject::CleanText),
            new ValidObject("experience_description", "", 0, 1024, ValidObject::CleanText),
            new ValidObject("experience_start", "", 1, 32, ValidObject::Date),
            new ValidObject("experience_end", "", 0, 32, ValidObject::Date),
            new ValidObject("experience_order", "", 0, 3, ValidObject::Integer)
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
}


output:
echo json_encode($callResult, JSON_FORCE_OBJECT);

nothing:
