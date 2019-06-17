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

$currentLang = "tr";

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/" . $user->getLang() . ".php")) {
    $currentLang = $user->getLang();
    include_once $_SERVER['DOCUMENT_ROOT'] . "/lang/" . $user->getLang() . ".php";
} else {
    //todo error ?
    $currentLang = "tr";
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
    const Html = 9;
    const Radio = 10;
    const Check = 11;

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
        return htmlspecialchars($rawText, ENT_QUOTES);
    }

    public static function decode($rawText)
    {
        return htmlspecialchars_decode($rawText, ENT_QUOTES);
    }

//todo bu ve düz text ayrı olmalı, işaretler var bunda
    public static function clear($rawText)
    {
        //https://stackoverflow.com/questions/25507489/slug-url-turkish-character

        return preg_replace("/[^a-zA-Z0-9.,+-?^<> #$!%&()?:;\x{00E7}\x{011F}\x{0131}\x{015F}\x{00F6}\x{00FC}\x{00C7}\x{011E}\x{0130}\x{015E}\x{00D6}\x{00DC} _-]/u", "", $rawText);
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

                        if ($var == "" && $input->minLength == 0 && ($input->inputType == ValidObject::Integer || $input->inputType == ValidObject::Float)) {
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
                if ($input->inputType == ValidObject::Check) {
                    if (is_array($var) && count($var) >= $input->minLength) {
                        for ($i = 0; $i < count($var); $i++) {
                            $_POST[$input->requestName][$i] = intval($_POST[$input->requestName][$i]);
                        }

                        if ($input->maxLength > 0 && count($var) > $input->maxLength) {
                            return [false, message("check_long_array", $input->langName, $input->maxLength)];
                        }

                        continue;
                    } else {
                        return [false, message("check_short_array", $input->langName, $input->minLength)];
                    }
                } else {
                    if (strlen($var) < $input->minLength) {
                        return [false, message("check_short", $input->langName, $input->minLength)];
                    }
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

                    if($checkInputType == false){
                        if($var == 1){
                            $checkInputType = true;
                            $var = 1;
                        }else if($var == 0){
                            $checkInputType = true;
                            $var = 0;
                        }
                    }
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
                    $checkInputType = true;
                    $var = Valid::clear($var);
                    break;
                case ValidObject::SpecialText:
                    $var = Valid::encode($_POST[$input->requestName]);
                    $checkInputType = true;
                    break;
                case ValidObject::Phone:
                    //todo
                    //todo re format
                    $checkInputType = true;
                    break;
                case ValidObject::Html:
                    $var = Valid::encode($_POST[$input->requestName]);
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
                case ValidObject::Check:
                    if ($var == "") {
                        $checkInputType = true;
                    } else {
                        echo $var;
                        $checkInputType = is_array($var);
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
            if ($var != "") {
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
    public $address;
    public $birt_date;
    public $active;

    public function __construct($memberId = 0)
    {
        $memberId = intval($memberId);
        if ($memberId == -1) {
            //nothing todo
        } else if ($memberId != 0) {
            $qUser = DB::Select("SELECT * FROM member WHERE member_id = $memberId");

            if ($qUser[0] == false || isset($qUser[1][0]) == false) {
                return false;
            }

            $qUser = $qUser[1][0];

            $this->memberId = $qUser["member_id"];
            $this->nick = $qUser["member_nick"];
            $this->type = $qUser["member_type"];
            $this->power = $qUser["member_power"];
            $this->email = $qUser["member_email"];

            $this->active = $qUser["member_active"];
            $this->name = $qUser["member_name"];
            $this->surname = $qUser["member_surname"];

            $this->gsm = $qUser["member_gsm"];
            //$this->tel = $qUser["member_tel"];
            $this->fax = $qUser["member_fax"];

            $this->birt_date = $qUser["member_bd"];

            $this->address = $qUser["member_address"];

            $this->special = $qUser["member_special"];

            $this->smoke = $qUser["member_smoke"];
            $this->military = $qUser["member_military"];

            $this->military_date = $qUser["member_military_date"];

            $this->gender = $qUser["member_gender"];

            $this->description = $qUser["member_description"];
            $this->picture = $qUser["member_picture"];
            $this->website = $qUser["member_website"];

            $this->isLogged = true;
            //todo user bulunamayabilir
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

        return [true, lang("failure_exit")];
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

        $this->active = $qUser["member_active"];
        $this->name = $qUser["member_name"];
        $this->surname = $qUser["member_surname"];

        $this->gsm = $qUser["member_gsm"];
        //$this->tel = $qUser["member_tel"];
        $this->fax = $qUser["member_fax"];

        $this->birt_date = $qUser["member_bd"];

        $this->address = $qUser["member_address"];

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
        $usernameOrEmail = strtolower($usernameOrEmail);

        $prefix = DB::Select("SELECT member_prefix, member_id FROM member WHERE (member_email = '$usernameOrEmail' OR member_nick = '$usernameOrEmail')");

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

    public function changePassword($currentPassword, $newPassword)
    {
        $prefix = DB::Select("SELECT member_prefix, member_id, member_password FROM member WHERE (member_email = '$this->email')");

        if ($prefix[0] == false) {
            return [true, lang("wrong_password")];
        }

        if (isset($prefix[1][0]["member_id"]) == false) {
            return [false, lang("wrong_password")];
        }

        $prefix = $prefix[1][0];

        $password = $this->encPassword($currentPassword, $prefix["member_prefix"]);

        if ($prefix["member_password"] != $password) {
            return [false, lang("wrong_password")];
        }

        $newPassword = $this->encPassword($newPassword, $prefix["member_prefix"]);

        $res = DB::execute("UPDATE member SET member_password = '$newPassword' WHERE member_id = " . $this->memberId);

        if ($res[0]) {
            return [true, lang("success_change_password")];
        } else {
            return [false, lang("failure_success_change_password")];
        }
    }

    public function register($type, $email, $name, $surname, $password)
    {
        //Artık sadece admin
        if ($this->checkAuth(Perm::OR_UPPER, Perm::SUPPORT)[0] == false) {
            return [false, lang("perm_error")];
        }

        $power = $type == User::MEMBER ? Perm::USER : Perm::COMPANY;

        if (DB::isAvailable("SELECT member_id FROM member WHERE member_email = '$email'")) {
            return [false, lang("already_email")];
        }

        $password_prefix = Valid::generate();

        $password = $this->encPassword($password, $password_prefix);

        $email = strtolower($email);

        $result = DB::executeId("INSERT INTO member (
                    member_email, member_type, member_power, member_name, member_surname, member_password, member_prefix
                    ) VALUES ('$email', $type, $power, '$name', '$surname', '$password', '$password_prefix')");

        if ($result[0]) {
            return [true, message("success_register"), $result];
        } else {
            return [false, $result];
        }
    }

    public function changeStatus($userId)
    {
        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId))[0] == false) {
            return $auth;
        }

        $prefix = DB::Select("SELECT member_power FROM member WHERE member_id = $userId");

        if ($prefix[0] == false) {
            return [true, lang("unknown_user")];
        }

        if (isset($prefix[1][0]["member_power"]) == false) {
            return [false, lang("unknown_user")];
        }

        if ($prefix[1][0]["member_power"] >= $this->power) {
            return [false, lang("perm_error")];
        }

        $res = DB::execute("UPDATE member SET  member_active = ((member_active+1) % 2) WHERE  member_id = $userId");

        if ($res[0]) {
            return [true, lang("success_update_status")];
        } else {
            return [false, lang("failure_update_status")];
        }
    }

    public function updateUserInfo($userId, $email, $name, $surname, $gsm, $bd, $website, $gender, $smoke, $mil, $mil_date, $address, $special)
    {
        if ($userId == 0) {
            $userId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId))[0] == false) {
            return $auth;
        }

        $email = strtolower($email);

        $result = DB::execute("UPDATE member SET member_email = '$email', member_name = '$name', member_surname = '$surname', member_gsm = '$gsm', member_bd = '$bd', member_website = '$website', member_gender = $gender, member_smoke = $smoke, member_military = $mil, member_military_date = '$mil_date', member_address = '$address', member_special = $special WHERE member_id = $userId AND member_type = 0");

        if ($result[0]) {
            return [true, lang("success_update_user")];
        } else {
            return [false, lang("failure_update_user")];
        }
    }

    public function updateCompanyInfo($userId, $email, $name, $gsm, $fax, $bd, $website, $address)
    {
        if ($userId == 0) {
            $userId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE member SET member_email = '$email', member_name = '$name', member_gsm = '$gsm', member_fax = '$fax', member_bd = '$bd', member_website = '$website', member_address = '$address' WHERE member_id = $userId AND member_type = 1");

        if ($result[0]) {
            return [true, lang("success_update_company")];
        } else {
            return [false, lang("failure_update_company")];
        }
    }

    public function updateUserDesc($userId, $desc)
    {
        if ($userId == 0) {
            $userId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId))[0] == false) {
            return $auth;
        }

//        $desc = Valid::encode($desc);

        $result = DB::execute("UPDATE member SET member_description = '$desc' WHERE member_id = $userId");

        if ($result[0]) {
            return [true, lang("success_update_user_desc")];
        } else {
            return [false, lang("failure_update_user_desc")];
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

    public function forgotPassword($email)
    {
        try {

            $us = DB::select("SELECT * FROM member WHERE  member_email = '$email'");

            if ($us[0] == false || count($us[1]) < 1) {
                return [false, lang("unknow_user")];
            }

            $token = Valid::generate(16);

            $newPassword = $this->encPassword($token, $us[1][0]["member_prefix"]);

            if (DB::execute("UPDATE member SET member_password = '$newPassword' WHERE member_id = " . $us[1][0]["member_id"])[0] == false) {
                return [false, lang("failure_send_password")];
            }

            $html = "<html>Yeni Şifreniz : <br><b>" . $token . "</b></html>";

            include 'class.phpmailer.php';
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->Username = 'muhammedkalender.kariyer@gmail.com';
            $mail->Password = '123456.aA';
            $mail->SetFrom($mail->Username, 'Kariyer');
            $mail->AddAddress($us[1][0]["member_email"], $us[1][0]["member_name"] . " " . $us[1][0]["member_surname"]);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Yeni Şifre';
            $content = $html;
            $mail->MsgHTML($content);

            if ($mail->Send()) {
                return [true, lang("success_send_password")];

            } else {
                return [false, lang("failure_send_password")];
            }
        } catch (Exception $e) {
            return [false, lang("failure_send_password")];
        }
    }

    //region User Management
    public function selectUser($keyword, $type, $page, $count)
    {
        $suffix = "";

        if ($keyword != "") {
            //TODO Sorgu iyileştir
            $suffix = " WHERE (member_email LIKE '$keyword' OR member_name LIKE '$keyword' OR member_surname LIKE '$keyword') AND member_type = $type";
        } else {
            $suffix = " WHERE member_type = $type";
        }

        if ($count > 0 && $page > 0) {
            $suffix = " LIMIT " . ($count * $page) . ", $count";
        }

        if (($auth = $this->checkAuth(Perm::OR_UPPER, Perm::SUPPORT, 0))[0] == false) {
            return $auth;
        }

        $res = DB::select("SELECT member_id, member_name, member_surname, member_type, member_email, member_insert, member_gsm, member_fax FROM member " . $suffix);

        if ($res[0]) {
            if (is_array($res[1]) && count($res[1]) > 0) {
                return $res;
            } else {
                return [false, message("404_", "user")];
            }
        } else {
            return $res;
        }
    }
    //endregion

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

    public function selectExperience($memberId = 0, $count = 0, $page = 0)
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

    public function getExperience($experienceId, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM experience WHERE experience_id = $experienceId AND experience_active = 1");
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

    public function selectEducation($memberId = 0, $count = 0, $page = 0)
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

    public function getEducation($educationId, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM education WHERE education_id = $educationId AND education_active = 1");
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
            return [true, message("success_insert", "reference"), $result[1]];
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

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["reference_member"];
        } else {
            return [false, message("404_", "reference") . var_dump($memberId)];
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

    public function selectReference($memberId = 0, $count = 0, $page = 0)
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

    public function getReference($referenceId, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM reference WHERE reference_id = $referenceId");
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

    public function selectCertificate($memberId = 0, $count = 0, $page = 0)
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

    public function getCertificate($certificateId, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM certificate WHERE certificate_id = $certificateId");
    }
    //endregion

    //region CV
    public function addCV($name, $file, $desc, $memberId = 0, $order = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::executeId("INSERT INTO cv (
                       cv_member, 
                       cv_name, 
                        cv_file,
                       cv_desc, 
                       cv_order
                       ) VALUES ($memberId, '$name', '$file', '$desc', $order)");

        if ($result[0]) {
            return [true, message("success_insert", "cv")];
        } else {
            return [false, message("failed_insert", "cv")];
        }
    }

    public function setCV($cvId, $name, $desc, $file, $order = 0)
    {
        $memberId = DB::select("SELECT cv_member FROM cv WHERE cv_id = $cvId");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["cv_member"];
        } else {
            return [false, message("404_", "cv")];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $fileQuery = "";

        if ($file != "") {
            $fileQuery = " cv_file = '$file', ";
        }

        $result = DB::execute("UPDATE cv SET 
                     cv_name = '$name',
                     " . $fileQuery . "
                     cv_desc = '$desc',
                     cv_order = $order
                     WHERE cv_id = $cvId");

        if ($result[0]) {
            return [true, message("success_update", "cv")];
        } else {
            return [false, message("failed_update", "cv")];
        }
    }

    public function delCV($cvID)
    {
        $memberId = DB::select("SELECT cv_member FROM cv WHERE cv_id = $cvID");

        if ($memberId[0] && count($memberId[1]) > 0) {
            $memberId = $memberId[1][0]["cv_member"];
        } else {
            return [false, message("404_", "cv")];
        }


        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE cv SET cv_active = 0 WHERE cv_id = $cvID");

        if ($result[0]) {
            return [true, message("success_delete", "cv")];
        } else {
            return [false, message("success_delete", "cv")];
        }
    }

    public function selectCV($memberId = 0, $count = 0, $page = 0)
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

        return DB::select("SELECT * FROM cv WHERE cv_member = $memberId AND cv_active = 1 ORDER BY cv_order DESC " . $suffix);
    }

    public function getCV($cvID, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM cv WHERE cv_id = $cvID");
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

        $result = DB::executeId("INSERT INTO skill (
                       skill_member, 
                       skill_name, 
                       skill_level,
                       skill_order
                       ) VALUES ($memberId, '$name', $level, $order)");

        if ($result[0]) {
            return [true, lang("success_insert_skill"), $result[1]];
        } else {
            return [true, lang("failure_insert_skill")];
        }
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

    public function selectSkill($memberId = 0, $count = 0, $page = 0)
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

    public function getSkill($skillId, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::VISITOR, $memberId))[0] == false) {
            return $auth;
        }

        return DB::select("SELECT * FROM skill WHERE skill_id = $skillId");
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

    //region Notification
    public function getNotificationCount($memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $res = DB::select("SELECT COUNT(*) as nc FROM notification WHERE notification_member = $memberId AND notification_read = 0");

        if ($res[0]) {
            return [true, $res[1][0]["nc"]];
        } else {
            return [false, lang("failure_notification_count")];
        }
    }

    public function getNotification($notificationId)
    {
        $memberId = DB::select("SELECT notification_member FROM notification WHERE notification_id = $notificationId");

        if ($memberId[0]) {
            if (isset($memberId[0][1]["notification_member"])) {
                $memberId = $memberId[0][1]["notification_member"];
            } else {
                return [false, message("404_", "notification")];
            }
        } else {
            return [false, lang("perm_error")];
        }

        if (($auth = $this->checkAuth(Perm::OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $res = DB::select("SELECT COUNT(*) as nc FROM notification WHERE notification_member = $memberId AND notification_read = 0");

        if ($res[0]) {
            return [true, $res[1][0]["nc"]];
        } else {
            return [false, lang("failure_notification_count")];
        }
    }

    public function sendNotification($message, $to)
    {
        if (($auth = $this->checkAuth(Perm::OR_UPPER, Perm::USER))[0] == false) {
            return $auth;
        }

        $message = Valid::encode($message);

        $res = DB::execute("INSERT INTO notification(notification_message, notification_member, notification_from) VALUES ('$message', $to, $this->memberId)");

        if ($res[0]) {
            return [true, lang("success_send_notification")];
        } else {
            return [false, lang("failure_send_notification")];
        }
    }

    public function selectNotification($memberId, $keyword, $page, $count)
    {
        $suffix = "";

        if ($memberId == 0) {
            $memberId = $this->memberId;
        }

        if ($keyword != "") {
            //TODO Sorgu iyileştir
            $suffix = " WHERE (notification_message LIKE '%$keyword%') AND notification_member = $memberId";
        } else {
            $suffix = " WHERE notification_member = $memberId";
        }

        $suffix .= " ORDER BY notification_read ASC ";

        if ($count > 0 && $page > 0) {
            $suffix .= " LIMIT " . ($count * $page) . ", $count";
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        $res = DB::select("SELECT * FROM notification " . $suffix);

        if ($res[0]) {
            if (is_array($res[1]) && count($res[1]) > 0) {
                return $res;
            } else {
                return [false, message("404_", "notification") . "SELECT * FROM notification " . $suffix];
            }
        } else {
            return $res;
        }
    }

    public function markNotification($notificationId, $mark)
    {
        if (($auth = $this->checkAuth(Perm::OR_UPPER, Perm::USER))[0] == false) {
            return $auth;
        }

        $res = DB::execute("UPDATE notification SET notification_read = $mark WHERE notification_id = $notificationId AND notification_member = " . $this->memberId);

        if ($res[0]) {
            return [true, lang("success_mark_notification")];
        } else {
            return [false, lang("failure_mark_notification")];
        }
    }
    //endregion
}

//TODO Cache hazırlama ( db de değşiklik oldukça json output

class Cache
{
    public static function locationJSON()
    {
        $country = DB::select("SELECT * FROM location WHERE location_level = 0 AND location_active = 1");

        if ($country[0] && ($country[1]) > 0) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/const/country.json", json_encode($country[1]));
        }

        $father = DB::select("SELECT * FROM location WHERE location_level = 1 AND location_active = 1");

        if ($father[0] && ($father[1]) > 0) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/const/il_10001.json", json_encode($father[1]));

            for ($i = 0; $i < count($father[1]); $i++) {
                $fatherId = $father[1][$i]["location_id"];

                $child = DB::select("SELECT * FROM location WHERE location_father = $fatherId AND location_active = 1");

                if ($child[0] && ($child[1]) > 0) {
                    for ($j = 0; $j < count($child[1]); $j++) {
                        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/const/ilce_" . $fatherId . ".json", json_encode($child[1]));
                    }
                }
            }
        }
    }

    public static function categoryJSON()
    {
        $father = DB::select("SELECT * FROM category WHERE category_father = 0 AND category_active = 1");

        if ($father[0] && count($father) > 0) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/const/category.json", json_encode($father[1]));

            for ($i = 0; $i < count($father); $i++) {
                $fatherId = $father[1][$i]["category_id"];

                $child = DB::select("SELECT * FROM category WHERE category_father = " . $fatherId . " AND category_active = 1");

                if ($child[0] && count($child[1]) > 0) {
                    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/const/category_" . $fatherId . ".json", json_encode($child[1]));
                }
            }
        }
    }
}

class Job
{
    /*
     * İlçe seçmek zorunlu
     *
     * Sektör seçmek zorunlu ( en alttan , armayoı ordan yap)
     * İş tipi zorunlu
     * type radio
     *category radio
     * silicne kapansın
     */

    public static function insertJob($companyId, $title, $description, $type, $category, $locations, $special)
    {
        global $user;

        if ($companyId == 0) {
            $companyId = $user->memberId;
        }

        if (($auth = $user->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $companyId))[0] == false) {
            return $auth;
        }

        if ($user->type != User::COMPANY) {
            return [false, lang("perm_error")];
        }

        // $title = Valid:: clear($title);
        // $description = Valid::encode($description);

        $result = DB::executeId("INSERT INTO job_adv (job_adv_author, job_adv_title, job_adv_type,  job_adv_description,  job_adv_category, job_adv_special) VALUES ($companyId, '$title', $type, '$description', $category, $special)");

        if ($result[0] == false) {
            return [false, message("failed_job_adv")];
        }

        $jobAdvId = $result[1];

        $errCountLocation = 0;
        for ($i = 0; $i < count($locations); $i++) {
            if (DB::execute("INSERT INTO job_adv_location (job_adv_id, location_id) VALUES ($jobAdvId, $locations[$i])") == false) {
                $errCountLocation++;
            }
        }

        if ($errCountLocation > 0) {
            return [true, message("failed_insert_job_adv_location")];
        }

        return [true, message("success_insert_job_adv")];
    }

    public static function editJob($jobId, $title, $description, $type, $category, $locations, $special)
    {
        global $user;

        $job = DB::select("SELECT * FROM job_adv WHERE job_adv_id = " . intval($jobId));

        if ($job[0] == false || count($job[1]) < 1) {
            return [false, message("404_", "job")];
        }

        if (($auth = $user->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $job[1][0]["job_adv_author"]))[0] == false) {
            return $auth;
        }

        if ($user->type != User::COMPANY) {
            return [false, lang("perm_error")];
        }

        //$title = Valid:: clear($title);
        //$description = Valid::encode($description);

        $result = DB::execute("UPDATE job_adv SET job_adv_title = '" . $title . "', job_adv_type =  $type,  job_adv_description = '" . $description . "',  job_adv_category = $category, job_adv_special = $special WHERE job_adv_id = $jobId");

        if ($result[0] == false) {
            return [false, message("failed_job_adv_update")];
        }

        DB::execute("DELETE FROM job_adv_location WHERE  job_adv_id = $jobId");

        $errCountLocation = 0;
        for ($i = 0; $i < count($locations); $i++) {
            if (DB::execute("INSERT INTO job_adv_location (job_adv_id, location_id) VALUES ($jobId, $locations[$i])") == false) {
                $errCountLocation++;
            }
        }

        if ($errCountLocation > 0) {
            return [true, message("failed_update_job_adv_location")];
        }

        return [true, message("success_job_adv_update")];
    }

    public static function deleteJob($jobId)
    {
        $job = DB::select("SELECT * FROM job_adv WHERE job_adv_id = $jobId");

        if ($job[0] == false || isset($job[1][0]) == false) {
            return [false, message("404_", "job")];
        }

        global $user;

        if (($auth = $user->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $job[1][0]["job_adv_author"]))[0] == false) {
            return $auth;
        }

        if (DB::execute("UPDATE job_adv SET job_adv_active = 0 WHERE job_adv_id = " . intval($jobId))[0]) {
            return [true, message("success_delete_job")];
        } else {
            return [false, message("failed_delete_job")];
        }
    }

    public static function getJob($jobId)
    {
        global $user;

        $job = DB::select("SELECT *, (SELECT category_father FROM category WHERE  category_id = job_adv.job_adv_category) as job_adv_category_father FROM job_adv WHERE job_adv_id = $jobId");

        if ($job[0] == false || isset($job[1][0]) == false) {
            return [false, message("404_", "job")];
        }

        //todo
        if (($auth = $user->checkAuth(Perm::SELF_OR_UPPER, Perm::USER, $job[1][0]["job_adv_author"]))[0] == false) {
            return $auth;
        }

        $job = $job[1][0];

        $jobLocation = DB::select("SELECT lc.*, bf.location_father as big_father FROM job_adv_location jl 
INNER JOIN location lc USING (location_id)
INNER JOIN location bf ON lc.location_father = bf.location_id
WHERE jl.job_adv_id = " . intval($jobId));

        if ($jobLocation[0] == false || isset($jobLocation[1][0]) == false) {
            //todo
            // return false;
            $jobLocation = [[], []];
        }

        $jobLocations = $jobLocation[1];
        $job["job_adv_description"] = Valid::decode($job["job_adv_description"]);
        return [true, $job, json_encode($jobLocations, true)];
    }

    public static function getJobForView($jobId)
    {
        global $user;

        $job = DB::select("SELECT ja.*, CONCAT_WS(' - ', fct.category_name_tr, ct.category_name_tr) as category, CONCAT_WS(' ', mb.member_name, mb.member_surname) as company_name, mb.member_picture as companyImage, GROUP_CONCAT(loc.location_name SEPARATOR ', ') as locations, (SELECT location_name FROM location WHERE location_id = loc.location_father) as fatherLocation FROM job_adv ja
INNER JOIN category ct ON ct.category_id = ja.job_adv_category
INNER JOIN category fct ON ct.category_father = fct.category_id
INNER JOIN member mb ON ja.job_adv_author = mb.member_id
INNER JOIN job_adv_location jal ON jal.job_adv_id = ja.job_adv_id
INNER JOIN location loc ON jal.location_id = loc.location_id WHERE ja.job_adv_active = 1 AND  ja.job_adv_id = $jobId");

        if ($job[0] == false || isset($job[1][0]) == false) {
            return [false, message("404_", "job")];
        }

        //todo
        if (($auth = $user->checkAuth(Perm::SELF_OR_UPPER, Perm::USER, $job[1][0]["job_adv_author"]))[0] == false) {
            return $auth;
        }

        $job = $job[1][0];

        $jobLocation = DB::select("SELECT lc.*, bf.location_father as big_father FROM job_adv_location jl 
INNER JOIN location lc USING (location_id)
INNER JOIN location bf ON lc.location_father = bf.location_id
WHERE jl.job_adv_id = " . intval($jobId));

        if ($jobLocation[0] == false || isset($jobLocation[1][0]) == false) {
            //todo
            // return false;
            $jobLocation = [[], []];
        }

        $jobLocations = $jobLocation[1];

        return [true, $job, json_encode($jobLocations, true)];
    }

    public static function selectJobForAdmin($keyword, $active, $puser, $page, $count)
    {
        //todo close olmuşşsa select etmesin

        global $user;

        $query = "";

        if ($puser == 0) {
            if ($user->power >= Perm::SUPPORT) {
                if (intval($puser) != 0) {
                    $query = " WHERE job_adv_author = " . $puser;
                }
            } else {
                if (($auth = $user->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $puser))[0] == false) {
                    return $auth;
                }

                $query = " WHERE job_adv_author = " . $user->memberId;
            }
        } else {
            $query = " WHERE job_adv_author = " . $user->memberId;

            if (($auth = $user->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $puser))[0] == false) {
                return $auth;
            }
        }

        if ($active != "") {
            if ($query == "") {
                $query = " WHERE job_adv_active = " . intval($active);
            } else {
                $query .= " AND job_adv_active = " . intval($active);
            }
        }

        if ($keyword != "") {
            if ($query == "") {
                $query = " WHERE ";
            } else {
                $query .= " AND ";
            }

            //$keyword = Valid::clear($keyword);
            //$keyword = Valid::encode($keyword);

            $query .= "(co.member_name LIKE '%$keyword%' OR co.member_surname LIKE '%$keyword%' OR ja.job_adv_title LIKE '%$keyword%' OR ja.job_adv_description LIKE '%$keyword%')";
        }

        $query .= " ORDER BY ja.job_adv_id ";

        if (intval($count) > 0) {
            $query .= " LIMIT " . ($page * $count) . ", " . intval($count);
        }

        $job = DB::select("SELECT ja.*, CONCAT_WS(' ', co.member_name, co.member_surname) as company_name   FROM job_adv ja  INNER JOIN member co ON ja.job_adv_author = co.member_id" . $query);

        if ($job[0] && count($job[1]) > 0) {
            return [true, $job];
        } else {
            return [false, message("404_", "search_job")];
        }
    }

    public static function selectJob($keyword, $locations, $type, $cat, $page, $count, $company, $special)
    {
        $query = "";


        //$keyword = Valid::encode($keyword);

        if ($keyword != "") {
            $query .= " AND (job_adv_title LIKE '%" . $keyword . "%' OR  job_adv_description LIKE '%" . $keyword . "%' OR (SELECT location_name FROM location WHERE location_id = loc.location_father) LIKE '%$keyword%' OR loc.location_name LIKE '%$keyword%') ";
        }

        if (intval($type) > 0) {
            if ($query != "") {
                $query .= " AND job_adv_type = " . intval($type);
            } else {
                $query .= " AND (job_adv_type = " . intval($type);
            }
        }

        if (intval($cat) > 0) {
            if ($query != "") {
                $query .= " AND job_adv_category = " . intval($cat) . ")";
            } else {
                $query .= " AND (job_adv_category = " . intval($cat) . ")";
            }
        }

        $locations = explode(",", $locations);

        if ($locations != "" && count($locations) > 0) {
            $subQuery = "";

            for ($i = 0; $i < count($locations); $i++) {
                if (intval($locations[$i]) < 1) {
                    continue;
                }

                if ($subQuery != "") {
                    $subQuery .= " OR ";
                }
                $subQuery .= " loc.location_id = " . intval($locations[$i]);
            }

            if ($subQuery != "") {
                $query .= " AND (" . $subQuery . ") ";
            }
        }

        if ($company > 0) {
            $query .= " AND job_adv_author = " . $company;
        }

        if ($special > 0) {
            $query .= " AND job_adv_special = " . $special;
        }

        $query .= " GROUP BY ja.job_adv_id ORDER BY job_adv_id ";

        if (intval($count) > 0) {
            $query .= " LIMIT " . ($page * $count) . ", " . intval($count);
        }

        $job = DB::select("SELECT ja.*, CONCAT_WS(' - ', fct.category_name_tr, ct.category_name_tr) as category, CONCAT_WS(' ', mb.member_name, mb.member_surname) as company_name, mb.member_picture as companyImage, GROUP_CONCAT(loc.location_name SEPARATOR ', ') as locations, (SELECT location_name FROM location WHERE location_id = loc.location_father) as fatherLocation FROM job_adv ja
INNER JOIN category ct ON ct.category_id = ja.job_adv_category
INNER JOIN category fct ON ct.category_father = fct.category_id
INNER JOIN member mb ON ja.job_adv_author = mb.member_id
INNER JOIN job_adv_location jal ON jal.job_adv_id = ja.job_adv_id
INNER JOIN location loc ON jal.location_id = loc.location_id
WHERE ja.job_adv_active = 1 AND (job_adv_close IS NULL || job_adv_close = '') " . $query);

        if ($job[0] && count($job[1]) > 0) {
            return [true, $job];
        } else {
            return [false, message("404_", "search_job")];
        }
    }

    public static function applyJob($jobAdvId)
    {
        $jobAdvId = intval($jobAdvId);
        global $user;

        if ($user->isLogged == false || $user->type == User::COMPANY) {
            return [false, lang("perm_error")];
        }

        $job = DB::select("SELECT * FROM job_adv WHERE job_adv_id = " . $jobAdvId);

        if ($job[0] && count($job[1]) > 0) {
            if (!($job[1][0]["job_adv_close"] == null || $job[1][0]["job_adv_close"] == "")) {
                return [false, message("closed_job_apply")];
            }
        } else {
            return [false, message("404_", "job")];
        }

        if (DB::execute("INSERT INTO job_apply(job_apply_member, job_apply_job_adv_id) VALUES (" . $user->memberId . "," . $jobAdvId . ")")[0]) {
            Job::addApply($jobAdvId);
            $user->sendNotification(lang("notification_apply_job", $user->name . " " . $user->surname, $jobAdvId, $user->memberId), $job[1][0]["job_adv_author"]);
            return [true, message("success_job_apply")];
        } else {
            return [false, message("failed_job_apply")];
        }
    }

    public static function closeJobAdv($jobAdvId)
    {
        $jobAdvId = intval($jobAdvId);

        $job = DB::select("SELECT * FROM job_adv WHERE job_adv_id = " . $jobAdvId);

        if ($job[0] == false || isset($job[1][0]) == false) {
            return [false, message("404_", "job")];
        }

        global $user;

        if (($auth = $user->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $job[1][0]["job_adv_author"]))[0] == false) {
            return $auth;
        }

        if (DB::execute("UPDATE job_adv SET  job_adv_close = '" . date("d.m.y") . "' WHERE  job_adv_close IS NULL AND job_adv_id = " . $jobAdvId)[0] . "") {
            return [true, message("success_close_job_adv")];
        } else {
            return [true, message("failed_close_job_adv")];
        }
    }

    public static function selectJobApply($jobId, $keyword, $page, $count)
    {
        global $user;

        $job = DB::select("SELECT * FROM job_adv WHERE job_adv_id = " . intval($jobId));

        if ($job[0] == false || count($job[1]) < 1) {
            return [false, message("404_", "job")];
        }

        if (($auth = $user->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $job[1][0]["job_adv_author"]))[0] == false) {
            return $auth;
        }

        if ($user->type != User::COMPANY && $user->power < Perm::SUPPORT) {
            return [false, lang("perm_error")];
        }

        $query = "WHERE job_apply_active = 1 AND job_apply_job_adv_id = " . $jobId;

        if ($keyword != "") {
            // $keyword = Valid::clear($keyword);

            $query = " AND (member_name LIKE '%$keyword%' OR member_surname LIKE '%$keyword%') ";
        }

        $page = intval($page);
        $count = intval($count);

        $query .= " ORDER BY job_apply_review ASC LIMIT " . ($page * $count) . ", " . $count;

        $job = DB::select("SELECT * FROM job_apply INNER JOIN member ON member_id = job_apply.job_apply_member " . $query);

        if ($job[0] && count($job[1]) > 0) {
            return [true, $job];
        } else {
            return [false, message("404_", "404_job_apply")];
        }
    }

    public static function checkApply($memberId, $jobId)
    {
        return DB::isAvailable("SELECT job_apply_id FROM job_apply WHERE job_apply_member = $memberId AND job_apply_job_adv_id = " . $jobId);
    }

    public static function addView($jobId)
    {
        DB::execute("UPDATE job_adv SET job_adv_view = job_adv_view +1 WHERE job_adv_id = $jobId");
    }

    public static function addApply($jobId)
    {
        DB::execute("UPDATE job_adv SET job_adv_app = job_adv_app +1 WHERE job_adv_id = $jobId");
    }

    public static function markApply($jobId)
    {
        global $user;

        $job = DB::select("SELECT * FROM job_apply INNER JOIN job_adv ON job_adv_id = job_apply_job_adv_id WHERE job_apply_id = " . intval($jobId));

        if ($job[0] == false || count($job[1]) < 1) {
            return [false, message("404_", "job")];
        }

        if (($auth = $user->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $job[1][0]["job_adv_author"]))[0] == false) {
            return $auth;
        }

        $result = DB::execute("UPDATE job_apply SET job_apply_review = ((job_apply_review+1) % 2) WHERE job_apply_id = " . intval($jobId));

        if ($result[0]) {
            return [true, lang("success_mark_job")];
        } else {
            return [false, lang("failure_mark_job")];
        }
    }
}