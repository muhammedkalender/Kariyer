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

    public function __construct($requestName, $langName, $minLength, $maxLength, $inputType, $method = ValidObject::POST, $isNullable = false, $value = "")
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
        $this->value = $value;
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
                case ValidObject::VARIABLE:
                    $input->value = $var;
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
    const MEMBER = 0;
    const COMPANY = 1;

    private $memberId, $power, $type;
    private $token, $token_key, $token_id;
    private $email, $nick;
    private $gender, $military, $military_date, $smoke, $special;
    private $name, $surname, $description, $picture;
    private $website, $fax, $gsm;

    function __construct($memberId = 0)
    {
        if ($memberId = 0) {

        }
    }

    //X Kullanıcı ve üstü, Y => Hangisi
    //Örnk. SELF_OR_UPPER, ADMIN
    public function checkAuth($permType, $permNeed, $userId = 0)
    {
        if ($permType == Perm::SELF_OR_UPPER) {
            //Kendisi yada X üstü, eğer id kendisi değilse powera bakar, azsa error döner
            if ($userId != $this->userId && $permNeed < $this->power) {
                return [false, "perm_error"];
            }
        } else if ($permType == Perm::OR_UPPER) {
            if ($this->power < $permNeed) {
                return [false, "perm_error"];
            }
        }

        return [true, "perm_ok"];
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

        $password = $this->password($password, $password_prefix);

        $result = DB::executeId("INSERT INTO member (
                    member_email, member_type, member_power, member_name, member_surname, member_password, member_prefix
                    ) VALUES ('$email', $type, $power, '$name', '$surname', '$password', '$password_prefix')");

        if ($result[0]) {
            return $result;
        } else {
            return [false, $result[1]];
        }
    }

    //region Experience
    public function addExperience($name, $company, $description, $start, $end = null, $order = 0, $memberId = 0)
    {
        if ($memberId == 0) {
            $memberId = $this->userId;
        }

        if ($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId)) {
            return $auth;
        }

        return DB::executeId("INSERT INTO experience (
                       experience_member, 
                       experience_name, 
                       experience_company, 
                       experience_desc,  
                       experience_start,
                       experience_end,
                       experience_order
                       ) VALUES ($memberId, '$name', '$company', '$description', '$start', '$end',$order)");
    }

    public function setExperience($experienceId, $name, $company, $description, $start, $end = null, $order = 0)
    {
        $userId = DB::select("SELECT experience_member FROM experience WHERE experience_id = $experienceId");

        if ($userId[0]) {
            $userId = $userId[1]["experience_member"];
        } else {
            return [false, "404_experience"];
        }

        if ($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId)) {
            return $auth;
        }

        return DB::execute("UPDATE experience SET 
                     experience_name = '$name',
                     experience_company = '$company',
                     experience_desc = '$description',
                     experience_start = '$start',
                     education_end = '$end',
                     education_order = $order,
                     WHERE experience_id = $experienceId");
    }

    public function delExperience($experienceId)
    {
        $userId = DB::select("SELECT experience_member FROM experience WHERE experience_id = $experienceId");

        if ($userId[0]) {
            $userId = $userId[1]["experience_member"];
        } else {
            return [false, "404_experience"];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId))[0] == false) {
            return $auth;
        }

        return DB::execute("UPDATE experience SET experience_active = 0 WHERE experience_id = $experienceId");
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
            $userId = $this->userId;
        }

        if ($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId)) {
            return $auth;
        }

        return DB::executeId("INSERT INTO education (
                       education_member, 
                       education_name, 
                       education_department, 
                       education_note, 
                       education_type, 
                       education_start,
                       education_end,
                       education_order
                       ) VALUES ($userId, '$name', '$department', $note,$type, '$start', '$end',$order)");
    }

    public function setEducation($educationId, $name, $department, $type, $start, $end = null, $note = null, $order = 0)
    {
        $userId = DB::select("SELECT education_member FROM education WHERE education_id = $educationId");

        if ($userId[0]) {
            $userId = $userId[1]["education_member"];
        } else {
            return [false, "404_education"];
        }

        if ($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $userId)) {
            return $auth;
        }

        return DB::execute("UPDATE education SET 
                     education_name = '$name',
                     education_department = '$department',
                     education_note = '$note',
                     education_type = $type,
                     education_start = '$start',
                     education_end = '$end',
                     education_order = $order,
                     WHERE education_id = $educationId");
    }

    public function delEducation($educationId)
    {
        $memberId = DB::select("SELECT education_member FROM education WHERE education_id = $educationId");

        if ($memberId[0]) {
            $memberId = $memberId[1]["education_member"];
        } else {
            return [false, "404_education"];
        }

        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        return DB::execute("UPDATE education SET active = 0 WHERE education_id = $educationId");
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

        if ($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId)) {
            return $auth;
        }

        return DB::executeId("INSERT INTO reference (
                       reference_member, 
                       reference_name, 
                       reference_company, 
                       reference_title, 
                       reference_email, 
                       reference_gsm,
                       reference_description,
                       reference_order
                       ) VALUES ($memberId, '$name', '$company', '$title','$email', '$gsm', '$description',$order)");
    }

    public function setReference($referenceId, $name, $company, $title, $email, $gsm, $description, $order = 0)
    {
        $memberId = DB::select("SELECT reference_member FROM reference WHERE reference_id = $referenceId");

        if ($memberId[0]) {
            $memberId = $memberId[1]["reference_id"];
        } else {
            return [false, "404_reference"];
        }

        if ($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId)) {
            return $auth;
        }

        return DB::execute("UPDATE reference SET 
                     reference_name = '$name',
                     reference_company = '$company',
                     reference_title = '$title',
                     reference_email = '$email',
                     reference_gsm = '$gsm',
                     reference_description = '$description',
                     reference_order = $order,
                     WHERE reference_id = $referenceId");
    }

    public function delReference($referenceId)
    {
        $memberId = DB::select("SELECT reference_member FROM reference WHERE reference_id = $referenceId");

        if ($memberId[0]) {
            $memberId = $memberId[1]["reference_member"];
        } else {
            return [false, "404_reference"];
        }


        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        return DB::execute("UPDATE reference SET reference_active = 0 WHERE reference_id = $referenceId");
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

        if ($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId)) {
            return $auth;
        }

        return DB::executeId("INSERT INTO certificate (
                       certificate_member, 
                       certificate_name, 
                       certificate_company, 
                       certificate_url, 
                       certificate_desc, 
                       certificate_date,
                       certificate_order
                       ) VALUES ($memberId, '$name', '$company', '$url','$description', '$date', $order)");
    }

    public function setCertificate($certificateId, $name, $company, $url, $description, $date, $order = 0)
    {
        $memberId = DB::select("SELECT certificate_member FROM certificate WHERE certificate_id = $certificateId");

        if ($memberId[0]) {
            $memberId = $memberId[1]["certificate_id"];
        } else {
            return [false, "404_certificate"];
        }

        if ($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId)) {
            return $auth;
        }

        return DB::execute("UPDATE certificate SET 
                     certificate_name = '$name',
                     certificate_company = '$company',
                     certificate_url = '$url',
                     certificate_desc = '$description',
                     certificate_date = '$date',
                     certificate_order = $order,
                     WHERE certificate_id = $certificateId");
    }

    public function delCertificate($certificateId)
    {
        //tips Procedure yazılabilir
        $memberId = DB::select("SELECT certificate_member FROM certificate WHERE certificate_id = $certificateId");

        if ($memberId[0]) {
            $memberId = $memberId[1]["reference_member"];
        } else {
            return [false, "404_reference"];
        }


        if (($auth = $this->checkAuth(Perm::SELF_OR_UPPER, Perm::SUPPORT, $memberId))[0] == false) {
            return $auth;
        }

        return DB::execute("UPDATE certificate SET certificate_active = 0 WHERE certificate_id = $certificateId");
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

}