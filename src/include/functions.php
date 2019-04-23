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

//https://stackoverflow.com/a/18542272
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "db.php";

$user = new User();

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $user->getLang() . ".php")) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/lang/" . $user->getLang() . ".php";
} else {
    //todo error ?
    include_once $_SERVER['DOCUMENT_ROOT'] . "/lang/tr.php";
}

class Perm
{
    const VISITOR = 0;
    const USER = 1;
    const COMPANY = 2;
    const SUPPORT = 3;
    const ADMIN = 4;

    const SELF_OR_UPPER = 1;
    const OR_UPPER = 2;
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
    const VARIABLE = 4;

    public $isCorrect = 1;
    public $requestName = "";
    public $langName = "";
    public $minLength = 0;
    public $maxLength = 0;
    public $method = 0;
    public $isNullable = 0;
    public $inputType;
    public $value;
    public $maxValue;

    public function __construct($requestName, $langName, $minLength, $maxLength, $inputType, $maxValue = 0, $method = ValidObject::POST, $isNullable = false, $value = "")
    {
        if ($requestName == "" || $requestName == null) {
            //System error, devoloper side
            $this->isCorrect = false;
            return;
        }

        $this->langName = $langName;

        if ($langName == "" || $langName == null) {
            $this->langName = "var_" . $requestName;
        }

        $this->requestName = $requestName;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->inputType = $inputType;
        $this->method = $method;
        $this->isNullable = $isNullable; //Sadece "" ollacak, boş geçemeez
        $this->value = $value;
        $this->maxValue = $maxValue;
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

    public static function day($timestampFirst, $timestampSecond)
    {
        //todo
    }

    public static function check($inputs)
    {
        foreach ($inputs as $input) {
            if ($input->isCorrect == false) {
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

                        if ($var == "" && $input->minLength == 0) {
                            $var = 0;
                            $_POST[$input->requestName] = 0;
                        }
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
                case ValidObject::VARIABLE:
                    $correctMethod = true;
                    $var = $input->value;
                    break;
                default:
                    $correctMethod = false;
                    $var = "";
                    break;
            }

            if ($correctMethod == false) {
                return [false, message("check_null", $input->langName)];
            }

            if ($input->minLength > 0) {
                if (strlen($var) < $input->minLength) {
                    return [false, message("check_short", $input->langName, $input->minLength)];
                }
            }

            if ($input->maxLength > 0) {
                if (strlen($var) > $input->maxLength) {
                    return [false, message("check_long", $input->langName, $input->maxLength)];
                }
            }

            $checkInputType = false;
            $overMaxValue = false;

            switch ($input->inputType) {
                case ValidObject::Integer:
                    $checkInputType = filter_var($var, FILTER_VALIDATE_INT);

                    if ($var == "0" || $var == 0) {
                        $checkInputType = true;
                    }

                    if ($checkInputType && $input->maxValue > 0) {
                        if ($var > $input->maxValue) {
                            $overMaxValue = true;
                        }
                    }
                    break;
                case ValidObject::Float:
                    if ($var == "" || $var == 0) {
                        $var = 0;
                        $checkInputType = true;
                    } else {
                        $checkInputType = filter_var($var, FILTER_VALIDATE_FLOAT);
                    }
                    break;
                case ValidObject::Boolean:
                    //todo kontrol et, 0 ve 1 mi yoksa true false mu arıyor
                    $checkInputType = is_bool($var);
                    break;
                case ValidObject::Email:
                    $checkInputType = filter_var($var, FILTER_VALIDATE_EMAIL);
                    break;
                case ValidObject::URL:
                    if ($var == "") {
                        $checkInputType = true;
                    } else {
                        $checkInputType = filter_var($var, FILTER_VALIDATE_URL);
                    }
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
                    //Gün - Ay - yıl alıcak  yyyy-aa-gg yada boşluk

                    if ($var == "") {
                        $checkInputType = true;
                    } else {
                        $check = explode("-", $var);

                        if (count($check) < 3) {
                            $checkInputType = false;
                        } else {
                            $checkInputType = checkdate($check[1], $check[2], $check[0]);
                        }
                    }

                    break;
                default:
                    $checkInputType = false;
                    break;
            }

            if ($checkInputType == false) {
                return [false, message("check_type", $input->langName)];
            }

            if ($overMaxValue == true) {
                return [false, message("check_over", $input->langName, $input->maxValue)];
            }

            //todo Formatlanıp tekrar yhazılıyor
            switch ($input->method) {
                case ValidObject::GET:
                    $_GET[$input->requestName] = $var;
                    break;
                case ValidObject::POST:
                    $_POST[$input->requestName] = $var;
                    break;
                case ValidObject::REQUEST:
                    $_REQUEST[$input->requestName] = $var;
                    break;
                case ValidObject::SESSION:
                    Session::set($input->requestName, $var);
                    break;
                case ValidObject::VARIABLE:
                    $input->value = $var;
                    break;
            }
        }

        if (count($inputs) == 0) {
            return [false, "valid_null"];
        } else {
            return [true];
        }
    }
}

class DB
{
    public static function execute($paramQuery)
    {
        try {
            global $db;
            return [$db->prepare($paramQuery)->execute(), "exec_result"];
        } catch (Exception $e) {
            //todo
            return [false, $e];
        }
    }

    public static function executeId($paramQuery)
    {
        try {
            global $db;
            return [$db->prepare($paramQuery)->execute(), $db->lastInsertId()];
        } catch (Exception $e) {
            return [false, $paramQuery];
        }
    }

    public static function select($paramQuery)
    {
        try {
            global $db;
            $conn = $db->prepare($paramQuery);

            if ($conn->execute() == false) {
                return [false, $conn->errorInfo()];
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
    const MEMBER = 0;
    const COMPANY = 1;

    public $memberId = 0, $power, $type;
    public $token, $token_key, $token_id;
    public $email, $nick;
    public $gender, $military, $military_date, $smoke, $special;
    public $name, $surname, $description, $picture;
    public $website, $fax, $gsm;
    public $isLogged = false;

    public function __construct($memberId = 0)
    {
        if ($memberId == -1) {
            //nothing todo
        } else if ($memberId != 0) {
            //todo, hariciden user çağırılıyor
        } else {
            $this->checkLogin();
        }
    }

    public function logout()
    {
        if ($this->isLogged) {
            $result = DB::execute("UPDATE token SET token_active = 0 WHERE token_id = " . $this->token_id);
            if ($result[0]) {
                return [true, lang("success_exit")];
            } else {
                return [true, lang("failed_exit")];
            }
        }

        return [true, lang("success_exit")];
    }

    private function checkLogin($customMember = 0)
    {
        if ($customMember != 0) {
            //todo auth Dışarıdan kullanıcının bilgisi getirilmek isteniyor
        }

        $memberId = Session::Get("member_id");
        $token = Session::Get("token_lock");
        $token_key = Session::Get("token_key");

        if ($memberId == "" || $token == "" || $token_key == "") {
            //todo, visitor
            return false;
        }

        $qToken = DB::Select("SELECT token_id FROM token WHERE token_lock = '{$token}' AND token_key = '{$token_key}' AND token_member = '{$memberId}' AND token_active = 1 ");

        $customMember = $memberId;

        if ($qToken[0] == false || $qToken[1] == null) {
            return false;
        }

        $this->token_id = $qToken[1][0]["token_id"];

        $qUser = DB::Select("SELECT * FROM member WHERE member_id = {$customMember}");

        if ($qUser[0] == false || isset($qUser[1][0]) == false) {
            return false;
        }

        $qUser = $qUser[1][0];

        $this->memberId = $qUser["member_id"];
        $this->nick = $qUser["member_nick"];
        $this->type = $qUser["member_type"];
        $this->power = $qUser["member_power"];
        $this->email = $qUser["member_email"];

        $this->name = $qUser["member_name"];
        $this->surname = $qUser["member_surname"];

        $this->gsm = $qUser["member_gsm"];
        //$this->tel = $qUser["member_tel"];
        $this->fax = $qUser["member_fax"];

        $this->special = $qUser["member_special"];

        $this->smoke = $qUser["member_smoke"];
        $this->military = $qUser["member_military"];

        //todo $this->military_date = $qUser["user_"];

        $this->gender = $qUser["member_gender"];

        $this->token = $token;
        $this->token_key = $token_key;

        $this->description = $qUser["member_description"];
        $this->picture = $qUser["member_picture"];
        $this->website = $qUser["member_website"];

        $this->isLogged = true;

        return true;
    }

    public function login($usernameOrEmail, $password)
    {
        $prefix = DB::Select("SELECT member_prefix, member_id FROM member WHERE (member_email = 'asd@gmail.com' OR member_nick = '$usernameOrEmail')");

        if ($prefix[0] == false) {
            return [false, lang("wrong_login")];
        }

        if (isset($prefix[1][0]["member_id"]) == false) {
            return [false, lang("wrong_login")];
        }

        $prefix = $prefix[1][0];

        $memberId = $prefix["member_id"];

        $password = $this->encPassword($password, $prefix["member_prefix"]);

        $checkLogin = DB::Select("SELECT member_id FROM member WHERE member_id = $memberId AND  member_password = '{$password}'");

        if (isset($checkLogin[1][0]["member_id"]) == false) {
            return [false, lang("wrong_login")];
        }

        if (is_int($memberId) == false || intval($memberId) < 1) {
            return [false, lang("wrong_login")];
        }

        $token_lock = Valid::generate();
        $token_key = Valid::generate();
        $memberIP = $this->getIP();

        while (DB::isAvailable("SELECT token_id FROM token WHERE token_member = {$memberId} AND token_lock =  '{$token_lock}' AND token_key = '{$token_key}'")) {
            $token_lock = Valid::generate();
            $token_key = Valid::generate();
        }

        DB::Execute("UPDATE token SET token_active = 0 WHERE token_member = {$memberId}");

        $qInsert = DB::ExecuteId("INSERT INTO token (token_member, token_lock, token_key, token_ip) VALUES ({$memberId}, '{$token_lock}', '{$token_key}','$memberIP')");

        if ($qInsert[0]) {
            Session::Set("token_id", $qInsert);
            Session::Set("token_lock", $token_lock);
            Session::Set("token_key", $token_key);
            Session::Set("member_id", $memberId);

            return [true, lang("login_success"), $qInsert[1], $token_lock, $token_key];
        } else {
            return [false, lang("login_system_error")];
        }
    }

    //X Kullanıcı ve üstü, Y => Hangisi
    //Örnk. SELF_OR_UPPER, ADMIN
    public function checkAuth($permType, $permNeed, $userId = 0)
    {
        if ($permType == Perm::SELF_OR_UPPER) {
            //Kendisi yada X üstü, eğer id kendisi değilse powera bakar, azsa error döner
            if ($userId != $this->memberId && $permNeed > $this->power) {
                return [false, lang("perm_error")];
            }
        } else if ($permType == Perm::OR_UPPER) {
            if ($this->power < $permNeed) {
                return [false, lang("perm_error")];
            }
        }

        return [true, "perm_ok"];
    }

    private function encPassword($password, $prefix)
    {
        return sha1(md5($password) . $prefix);
    }

    public function register($type, $email, $name, $surname, $password)
    {
        if ($this->checkAuth(Perm::OR_UPPER, Perm::VISITOR)[0] == false) {
            return [false, lang("perm_error")];
        }

        $power = $type == User::MEMBER ? Perm::USER : Perm::COMPANY;

        if (DB::isAvailable("SELECT member_id FROM member WHERE member_email = '$email'")) {
            return [false, lang("already_email")];
        }

        $password_prefix = Valid::generate();

        $password = $this->encPassword($password, $password_prefix);

        $result = DB::executeId("INSERT INTO member (
                    member_email, member_type, member_power, member_name, member_surname, member_password, member_prefix
                    ) VALUES ('$email', $type, $power, '$name', '$surname', '$password', '$password_prefix')");

        if ($result[0]) {
            return [true, message("success_insert", "user"), $result];
        } else {
            return [false, $result];
        }
    }

    public function getIP()
    {
        try {
            $ip = null;

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            return $ip;
        } catch (Exception $e) {
            ///todo log sistemi ? belkli Log::error("ip", $e);
            return "ERR";
        }
    }

    public function getLang()
    {
        //todo

        return "tr";
    }

    //region Experience
    public function addExperience($name, $company, $description, $start, $end = null, $order = 0, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::executeId("INSERT INTO experience (
                       experience_member, 
                       experience_name, 
                       experience_company, 
                       experience_desc,  
                       experience_start,
                       experience_end,
                       experience_order
                       ) VALUES ($memberId, '$name', '$company', '$description', '$start', '$end',$order)");

        if ($result[0]) {
            return [true, message("success_insert", "experience")];
        } else {
            return [false, message("failed_insert", "experience")];
        }
    }

    public function setExperience($experienceId, $name, $company, $description, $start, $end = null, $order = 0)
    {
        $userId = DB::select("SELECT experience_member FROM experience WHERE experience_id = $experienceId");

        if ($userId[0] && count($userId[1]) > 0) {
            $userId = $userId[1][0]["experience_member"];
        } else {
            return [false, message("404_", "experience")];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId)) == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE experience SET 
                     experience_name = '$name',
                     experience_company = '$company',
                     experience_desc = '$description',
                     experience_start = '$start',
                     experience_end = '$end',
                     experience_order = $order
                     WHERE experience_id = $experienceId");
        if ($result[0]) {
            return [true, message("success_update", "experience")];
        } else {
            return [false, message("failed_update", "experience")];
        }
    }

    public function delExperience($experienceId)
    {
        $userId = DB::select("SELECT experience_member FROM experience WHERE experience_id = $experienceId");

        if ($userId[0] && count($userId[1]) > 0) {
            $userId = $userId[1][0]["experience_member"];
        } else {
            return [false, message("404_", "experience")];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE experience SET experience_active = 0 WHERE experience_id = $experienceId");

        if ($result[0]) {
            return [true, message("success_delete", "experience")];
        } else {
            return [false, message("failed_delete", "experience")];
        }
    }

    public function getExperience($memberId = 0, $count = 0, $page = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        $suffix = "";

        if ($count > 0 && $page > 0) {
            $suffix = " LIMIT " . ($count * $page) . ", $count";
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM experience WHERE experience_member = $memberId AND experience_active = 1 ORDER BY experience_order DESC" . $suffix);
    }
    //endregion

    //region Education
    public function addEducation($name, $department, $type, $start, $end = null, $note = null, $order = 0, $userId = 0)
    {
        if ($userId == 0) {
            $userId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId))[0] == false) {
            return $auth;
        }
        echo $name;
        $result = DB::executeId("INSERT INTO education (
                       education_member, 
                       education_name, 
                       education_department, 
                       education_note, 
                       education_type, 
                       education_start,
                       education_end,
                       education_order
                       ) VALUES ($userId, '$name', '$department', '$note',$type, '$start', '$end',$order)");

        if ($result[0]) {
            return [true, message("success_insert", "education"), $result[1]];
        } else {
            return [false, message("failed_insert", "education")];
        }
    }

    public function setEducation($educationId, $name, $department, $type, $start, $end = null, $note = null, $order = 0)
    {
        $userId = DB::select("SELECT education_member FROM education WHERE education_id = $educationId");

        if ($userId[0] && count($userId[1]) > 0) {
            $userId = $userId[1][0]["education_member"];
        } else {
            return [false, message("404_", "education")];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE education SET 
                     education_name = '$name',
                     education_department = '$department',
                     education_note = '$note',
                     education_type = $type,
                     education_start = '$start',
                     education_end = '$end',
                     education_order = $order
                     WHERE education_id = $educationId");

        if ($result[0]) {
            return [true, message("success_update", "education")];
        } else {
            return [false, message("failed_update", "education")];
        }
    }

    public function delEducation($educationId)
    {
        $memberId = DB::select("SELECT education_member FROM education WHERE education_id = $educationId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["education_member"];
        } else {
            return [false, message("404_", "education")];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE education SET education_active = 0 WHERE education_id = $educationId");

        if ($result[0]) {
            return [true, message("success_delete", "education")];
        } else {
            return [false, message("failed_delete", "education")];
        }
    }

    public function getEducation($memberId = 0, $count = 0, $page = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        $suffix = "";

        if ($count > 0 && $page > 0) {
            $suffix = " LIMIT " . ($count * $page) . ", $count";
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM education WHERE education_member = $memberId AND education_active = 1 ORDER BY education_order DESC" . $suffix);
    }
    //endregion

    //region Reference
    public function addReference($name, $company, $title, $email, $gsm, $description, $order = 0, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::executeId("INSERT INTO reference (
                       reference_member, 
                       reference_name, 
                       reference_company, 
                       reference_title, 
                       reference_email, 
                       reference_gsm,
                       reference_description,
                       reference_order
                       ) VALUES ($memberId, '$name', '$company', '$title','$email', '$gsm', '$description',$order)");

        if ($result[0]) {
            return [false, message("success_insert", "reference"), $result[1]];
        } else {
            return [false, message("failed_insert", "reference")];
        }
    }

    public function setReference($referenceId, $name, $company, $title, $email, $gsm, $description, $order = 0)
    {
        $memberId = DB::select("SELECT reference_member FROM reference WHERE reference_id = $referenceId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["reference_member"];
        } else {
            return [false, message("404_", "reference")];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE reference SET 
                     reference_name = '$name',
                     reference_company = '$company',
                     reference_title = '$title',
                     reference_email = '$email',
                     reference_gsm = '$gsm',
                     reference_description = '$description',
                     reference_order = $order
                     WHERE reference_id = $referenceId");

        if ($result[0]) {
            return [false, message("success_update", "reference")];
        } else {
            return [false, message("failed_update", "reference")];
        }
    }

    public function delReference($referenceId)
    {
        $memberId = DB::select("SELECT reference_member FROM reference WHERE reference_id = $referenceId");

        if ($memberId[0] && count($memberId) > 0) {
            $memberId = $memberId[1][0]["reference_member"];
        } else {
            return [false, message("404_", "reference")];
        }


        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE reference SET reference_active = 0 WHERE reference_id = $referenceId");

        if ($result[0]) {
            return [true, message("success_delete", "reference")];
        } else {
            return [true, message("failed_delete", "reference")];
        }
    }

    public function getReference($memberId = 0, $count = 0, $page = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        $suffix = "";

        if ($count > 0 && $page > 0) {
            $suffix = " LIMIT " . ($count * $page) . ", $count";
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM reference WHERE reference_member = $memberId AND reference_active = 1  ORDER BY reference_order DESC " . $suffix);
    }
    //endregion

    //region Certificate
    public function addCertificate($name, $company, $url, $description, $date, $order = 0, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::executeId("INSERT INTO certificate (
                       certificate_member, 
                       certificate_name, 
                       certificate_company, 
                       certificate_url, 
                       certificate_desc, 
                       certificate_date,
                       certificate_order
                       ) VALUES ($memberId, '$name', '$company', '$url','$description', '$date', $order)");

        if ($result[0]) {
            return [true, message("success_insert", "certificate")];
        } else {
            return [false, message("failed_insert", "certificate")];
        }
    }

    public function setCertificate($certificateId, $name, $company, $url, $description, $date, $order = 0)
    {
        $memberId = DB::select("SELECT certificate_member FROM certificate WHERE certificate_id = $certificateId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["certificate_member"];
        } else {
            return [false, message("404_", "certificate")];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE certificate SET 
                     certificate_name = '$name',
                     certificate_company = '$company',
                     certificate_url = '$url',
                     certificate_desc = '$description',
                     certificate_date = '$date',
                     certificate_order = $order
                     WHERE certificate_id = $certificateId");

        if ($result[0]) {
            return [true, message("success_update", "certificate")];
        } else {
            return [false, message("failed_update", "certificate")];
        }
    }

    public function delCertificate($certificateId)
    {
        //tips Procedure yazılabilir
        $memberId = DB::select("SELECT certificate_member FROM certificate WHERE certificate_id = $certificateId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["certificate_member"];
        } else {
            return [false, message("404_", "reference")];
        }


        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE certificate SET certificate_active = 0 WHERE certificate_id = $certificateId");

        if ($result[0]) {
            return [true, message("success_delete", "certificate")];
        } else {
            return [false, message("success_delete", "certificate")];
        }
    }

    public function getCertificate($memberId = 0, $count = 0, $page = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        $suffix = "";

        if ($count > 0 && $page > 0) {
            $suffix = " LIMIT " . ($count * $page) . ", $count";
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM certificate WHERE certificate_member = $memberId AND certificate_active = 1 ORDER BY certificate_order DESC " . $suffix);
    }
    //endregion

    //region Skill
    public function addSkill($name, $level, $order = 0, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        return DB::executeId("INSERT INTO skill (
                       skill_member, 
                       skill_name, 
                       skill_level,
                       skill_order
                       ) VALUES ($memberId, '$name', $level, $order)");
    }

    public function setSkill($skillId, $name, $level, $order = 0)
    {
        $memberId = DB::select("SELECT skill_member FROM skill WHERE skill_id = $skillId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["skill_member"];
        } else {
            return [false, "404_skill"];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId)) == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE skill SET 
                     skill_name = '$name',
                     skill_level = $level,
                     skill_order = $order
                     WHERE skill_id = $skillId");

        if ($result[0]) {
            $result[1] = message("success_update", "skill");
        } else {
            $result[1] = message("failed_update", "skill");
        }

        return $result;
    }

    public function delSkill($skillId)
    {
        //tips Procedure yazılabilir
        $memberId = DB::select("SELECT skill_member FROM skill WHERE skill_id = $skillId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["skill_member"];
        } else {
            return [false, message("404_", "skill")];
        }


        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE skill SET skill_active = 0 WHERE skill_id = $skillId");

        if ($result[0]) {
            return [true, message("success_delete", "skill")];
        } else {
            return [false, message("failed_delete", "skill")];
        }
    }

    public function getSkill($memberId = 0, $count = 0, $page = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        $suffix = "";

        if ($count > 0 && $page > 0) {
            $suffix = " LIMIT " . ($count * $page) . ", $count";
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM skill WHERE skill_member = $memberId AND skill_active = 1 ORDER BY skill_order DESC " . $suffix);
    }
    //endregion

    //region Language
    public function addLanguage($code, $desc, $order = 0, $languageLevel = 0, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::executeId("INSERT INTO language (
                       language_member, 
                       language_code, 
                       language_desc,
                       language_order,
                      language_level
                       ) VALUES ($memberId, (SELECT lang_id FROM lang WHERE lang_code = '$code' AND lang_active = 1), '$desc', $order, $languageLevel)");

        if ($result[0]) {
            return [true, message("success_insert", "language"), $result[1]];
        } else {
            return [false, message("failed_insert", "language")];
        }
    }

    public function setLanguage($languageId, $code, $desc, $order = 0, $languageLevel = 0)
    {
        $memberId = DB::select("SELECT language_member FROM language WHERE language_id = $languageId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["language_member"];
        } else {
            return [false, message("404_", "language")];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE language SET 
                     language_code = (SELECT lang_id FROM lang WHERE lang_code = '$code' AND lang_active = 1),
                     language_desc = '$desc',
                     language_order = $order,
                    language_level = $languageLevel
                     WHERE language_id = $languageId");

        if ($result[0]) {
            return [true, message("success_update", "language")];
        } else {
            return [false, message("failed_update", "language")];
        }
    }

    public function delLanguage($languageId)
    {
        //tips Procedure yazılabilir
        $memberId = DB::select("SELECT language_member FROM language WHERE language_id = $languageId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["language_member"];
        } else {
            return [false, message("404_", "language")];
        }


        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE language SET language_active = 0 WHERE language_id = $languageId");

        if ($result[0]) {
            return [true, message("success_delete", "language")];
        } else {
            return [false, message("failed_delete", "language")];
        }
    }

    public function getLanguage($memberId = 0, $count = 0, $page = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        $suffix = "";

        if ($count > 0 && $page > 0) {
            $suffix = " LIMIT " . ($count * $page) . ", $count";
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM language WHERE language_member = $memberId AND language_active = 1 ORDER BY language_order DESC " . $suffix);
    }
    //endregion

    //region Licence
    public function addLicence($name, $date, $code, $order = 0, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::executeId("INSERT INTO licence (
                       licence_member, 
                        licence_name,
                       licence_code, 
                        licence_date,
                       licence_order
                       ) VALUES ($memberId, '$name', '$code', '$date', $order)");

        if ($result[0]) {
            return [true, message("success_insert", "licence"), $result[1]];
        } else {
            return [false, message("failed_insert", "licence")];
        }
    }

    public function setLicence($licenceId, $name, $code, $date, $order = 0)
    {
        $memberId = DB::select("SELECT licence_member FROM licence WHERE licence_id = $licenceId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["licence_member"];
        } else {
            return [false, message("404_", "licence")];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE licence SET 
                     licence_code = '$code',
                     licence_name = '$name',
                    licence_date = '$date',
                     licence_order = $order
                     WHERE licence_id = $licenceId");

        if ($result[0]) {
            return [true, message("success_update", "licence")];
        } else {
            return [true, message("failed_update", "licence")];
        }
    }

    public function delLicence($licenceId)
    {
        //tips Procedure yazılabilir
        $memberId = DB::select("SELECT licence_member FROM licence WHERE licence_id = $licenceId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["licence_member"];
        } else {
            return [false, message("404_", "licence")];
        }


        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE licence SET licence_active = 0 WHERE licence_id = $licenceId");

        if ($result) {
            return [true, message("success_delete", "licence")];
        } else {
            return [false, message("success_delete", "licence")];
        }
    }

    public function getLicence($memberId = 0, $count = 0, $page = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        $suffix = "";

        if ($count > 0 && $page > 0) {
            $suffix = " LIMIT " . ($count * $page) . ", $count";
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM licence WHERE licence_member = $memberId AND licence_active = 1 ORDER BY licence_order DESC " . $suffix);
    }
    //endregion
}
//TODO Cache hazırlama ( db de değşiklik oldukça json output
//todo iş kategorileri
//ilan ypaısı

class Job{
    public function insertJob(){

    }
}