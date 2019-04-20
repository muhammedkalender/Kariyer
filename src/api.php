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
    } else {
        goto nothing;
    }

    //endregion
} else if ("user_licence") {
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
    } else if ($callRequest == "update") {
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

        $callResult = $user->setLicence($_POST["licence_id"], $_POST["licence_name"], $_POST["licence_code"], $_POST["licence_date"], $_POST["licence_order"], $_POST["licence_id"]);
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
    }else {
        goto nothing;
    }

    //endregion
}

output:
echo json_encode($callResult, JSON_FORCE_OBJECT);

nothing:
