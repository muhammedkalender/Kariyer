<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 15-04-2019
 * Time : 16:19
 */


/*
 * Return [result , [ErrorCode | Result]]
 */

class Perm
{
    const VISITOR = 0;
    const USER = 1;
    const COMPANY = 2;
    const SUPPORT = 3;
    const ADMIN = 4;

    const SELF_OR_UPPER = 1;
}

class ValidObject
{
    const Integer = 0;
    const Float = 1;
    const CleanText = 2; //Name, surname vs.. [_,-] sadece
    const SpecialText = 3; //Taglar, özel karkaterler vs... dönüştürülecek, html kodkları felan silecek
    const URL = 4;
    const Phone = 5;
    const Email = 6;
    const Boolean = 7;
    const Date = 8; //standart tyok
    const Html = 9; //todo bu sakat

    const GET = 0;
    const POST = 1;
    const REQUEST = 2;
    const SESSION = 3;

    public $isCorrect = 1;
    public $requestName = "";
    public $langName = "";
    public $minLength = 0;
    public $maxLength = 0;
    public $method = 0;
    public $isNullable = 0;
    public $inputType;

    public function __construct($requestName, $langName, $minLength, $maxLength, $inputType, $method = ValidObject::POST, $isNullable = false)
    {
        if ($requestName == "" || $requestName == null) {
            //System error, devoloper side
            $this->isCorrect = false;
            return;
        }

        if ($langName == "" || $langName == null) {
            $this->langName = "var_" . $requestName;
        }

        $this->requestName = $requestName;
        $this->langName = $langName;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->inputType = $inputType;
        $this->method = $method;
        $this->isNullable = $isNullable; //Sadece "" ollacak, boş geçemeez
    }
}

class Valid
{
    public static function generate($length = 128)
    {
        $list = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $listLength = strlen($list);

        $token = "";

        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, $listLength - 1); //todo -1
            $token .= $list[$randomIndex];
        }

        return $token;
    }

    public static function encode($rawText)
    {
//todo
    }

    public static function decode($rawText)
    {
//todo
    }

    public static function check($inputs)
    {
        foreach ($inputs as $input) {
            if ($input->isCorrect) {
                return [false, lang("check_dev_error")];
            }

            $correctMethod = false;
            $var = "";

            switch ($input->method) {
                case ValidObject::GET:
                    $correctMethod = isset($_GET[$input->requestName]);

                    if ($correctMethod) {
                        $var = $_GET[$input->requestName];
                    }
                    break;
                case ValidObject::POST:
                    $correctMethod = isset($_POST[$input->requestName]);

                    if ($correctMethod) {
                        $var = $_POST[$input->requestName];
                    }
                    break;
                case ValidObject::REQUEST:
                    $correctMethod = isset($_REQUEST[$input->requestName]);

                    if ($correctMethod) {
                        $var = $_REQUEST[$input->requestName];
                    }
                    break;
                case ValidObject::SESSION:
                    $correctMethod = Session::get($input->name) == "" ? false : true;;

                    if ($correctMethod) {
                        $var = Session::get($input->name);
                    }
                    break;

                default:
                    $correctMethod = false;
                    $var = "";
                    break;
            }

            if ($correctMethod == false) {
                return [false, lang("check_null", $input->langName)];
            }

            if ($input->minLength > 0) {
                if (strlen($var) < $input->minLength) {
                    return [false, lang("check_short", $input->langName, $input->minLength)];
                }
            }

            if ($input->maxLength > 0) {
                if (strlen($var) > $input->maxLength) {
                    return [false, lang("check_long", lang($input->langName), $input->maxLength)];
                }
            }

            $checkInputType = false;

            switch ($input->inputType) {
                case ValidObject::Integer:
                    $checkInputType = is_int($var);
                    break;
                case ValidObject::Float:
                    $checkInputType = is_float($var);
                    break;
                case ValidObject::Boolean:
                    //todo kontrol et, 0 ve 1 mi yoksa true false mu arıyor
                    $checkInputType = is_bool($var);
                    break;
                case ValidObject::Email:
                    $checkInputType = filter_var($var, FILTER_VALIDATE_EMAIL);
                    break;
                case ValidObject::URL:
                    $checkInputType = filter_var($var, FILTER_VALIDATE_URL);
                    break;
                case ValidObject::CleanText:
                    //todo
                    $checkInputType = true;
                    break;
                case ValidObject::SpecialText:
                    //todo
                    //todo encode
                    $checkInputType = true;
                    break;
                case ValidObject::Phone:
                    //todo
                    //todo re format
                    $checkInputType = true;
                    break;
                case ValidObject::Html:
                    //todo
                    //todo encode
                    $checkInputType = true;
                    break;
                case ValidObject::Date:
                    //todo
                    //todo re format
                    $checkInputType = true;
                    break;
                default:
                    $checkInputType = false;
                    break;
            }

            if ($checkInputType == false) {
                return [false, lang("check_type", $input->langName)];
            }
            //todo Formatlanıp tekrar yhazılıyor
            switch ($input->method) {
                case ValidObject::GET:
                    $_GET[$input->name] = $var;
                    break;
                case ValidObject::POST:
                    $_POST[$input->name] = $var;
                    break;
                case ValidObject::REQUEST:
                    $_REQUEST[$input->name] = $var;
                    break;
                case ValidObject::SESSION:
                    Session::set($input->name, $var);
                    break;
            }
        }

        return [false, "valid_null"];
    }
}

class DB
{
    public static function execute($paramQuery)
    {
        global $db;
        return [$db->prepare($paramQuery)->execute(), "exec_result"];
    }

    public static function executeId($paramQuery)
    {
        global $db;
        return [$db->prepare($paramQuery)->execute(), $db->lastInsertId()];
    }

    public static function select($paramQuery)
    {
        try {
            global $db;
            $conn = $db->prepare($paramQuery);

            if ($conn->execute() == false) {
                return array(false, $conn->errorInfo());
            }

            return [true, $conn->fetchAll(PDO::FETCH_ASSOC)];
        } catch (Exception $e) {
            return [false, $e];
        }
    }

    /*
     * Koşul sağlanırsa false, sağlanmazsa true döner
     */
    public static function isAvailable($paramQuery)
    {
        return self::Select($paramQuery)[1] == null ? false : true;
    }
}

class Session
{

    public static function del($paramName)
    {
        //https://stackoverflow.com/a/18542272
        if (session_status() == PHP_SESSION_NONE) {
            return false;
        }

        unset($_SESSION[$paramName]);

        return true;
    }

    public static function get($paramName)
    {
        //https://stackoverflow.com/a/18542272
        if (session_status() == PHP_SESSION_NONE) {
            return "";
        }

        return isset($_SESSION[$paramName]) ? $_SESSION[$paramName] : "";
    }

    public static function set($paramName, $paramValue)
    {
        //https://stackoverflow.com/a/18542272
        if (session_status() == PHP_SESSION_NONE) {
            return false;
        }

        $_SESSION[$paramName] = $paramValue;

        return true;
    }
}

class User
{

    //X Kullanıcı ve üstü, Y => Hangisi
    //Örnk. SELF_OR_UPPER, ADMIN
    public function checkAuth($permType, $permNeed, $userId)
    {
        if ($permType == Perm::SELF_OR_UPPER) {
            //Kendisi yada X üstü, eğer id kendisi değilse powera bakar, azsa error döner
            if ($userId != $this->userId && $permNeed < $this->power) {
                return [false, "perm_error"];
            }
        }

        return [true, "perm_ok"];
    }

    public function addEducation()
    {

    }

    public function delEducation($educationId, $userId = 0)
    {
        if (($result = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId))[0] == false) {
            return $result;
        }

        return DB::execute("UPDATE education SET active = 0 WHERE education_id = $educationId");
    }

}