<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 20-05-2019
 * Time : 01:50
 */

$userId = 0;

if (!isset($_GET["user"])) {
    echo lang("perm_error");
    die();
}

$userId = intval($_GET["user"]);

//https://stackoverflow.com/a/18542272
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once "include/functions.php";

$profile;

if ($userId > 0 && $userId != $user->memberId) {
    if (!DB::isAvailable("SELECT job_adv_author FROM job_apply INNER JOIN job_adv ON job_adv_id = job_apply_job_adv_id INNER JOIN member ON job_adv_author = member_id WHERE job_apply_member = $userId  AND job_adv_author =" . $user->memberId) && $user->power < Perm::ADMIN) {
        echo lang("perm_error");
        die();
    }

    $profile = new User($userId);

    if($profile == false){
        echo lang("perm_error");
        die();
    }
} else {
    $profile = $user;
}


//http://www.openresumetemplates.com/cthulhu-one-page-resume/


$html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>'.$profile->name.' '.$profile->surname.'</title>

    <style type="text/css">
        * { margin: 0; padding: 0; }
        body { font: 16px Dejavu Sans, Sans-Serif; line-height: 24px; }
        .clear { clear: both; }
        #page-wrap { width: 800px; margin: 40px auto 60px; }
        #pic { float: right; margin: -30px 0 0 0; }
        h1 { margin: 0 0 16px 0; padding: 0 0 16px 0; font-size: 42px; font-weight: bold; letter-spacing: -2px; border-bottom: 1px solid #999; }
        h2 { font-size: 20px; margin: 0 0 6px 0; position: relative; }
        h2 span { position: absolute; bottom: 0; right: 0; font-style: italic; font-family: Dejavu Sans, Serif; font-size: 16px; color: #999; font-weight: normal; }
        p { margin: 0 0 16px 0; }
        a { color: #999; text-decoration: none; border-bottom: 1px dotted #999; }
        a:hover { border-bottom-style: solid; color: black; }
        ul { margin: 0 0 32px 17px; }
        #objective { width: 500px; float: left; }
        #objective p { font-family: Dejavu Sans, Serif; font-style: italic; color: #666; }
        dt { font-style: italic; font-weight: bold; font-size: 18px; text-align: right; padding: 0 26px 0 0; width: 150px; float: left; height: 100px; border-right: 1px solid #999;  }
        dd { width: 600px; float: right; }
        dd.clear { float: none; margin: 0; height: 15px; }
    </style>
</head>

<body>

<div id="page-wrap">

    <img src="/images/profile/' . $profile->picture . '" style="width: 180px; height: 180px" alt="" id="pic" />

    <div id="contact-info" class="vcard">

        <!-- Microformats! -->

        <h1 class="fn">' . $profile->name . ' ' . $profile->surname . '</h1>

        <p>';
            if($profile->gsm != ""){
                $html .= lang("user_gsm").': <span class="tel">' . $profile->gsm . '</span><br />';
            }

           $html .= lang("user_email").': <a class="email" href="mailto:' . $profile->email . '">' . $profile->email . '</a>
        </p>
    </div>

    <div id="objective">
        <p>
            ' . $profile->description . '
        </p>
    </div>

    <div class="clear"></div>

    <dl>
        
        ';

$edus = $profile->selectEducation();

if ($edus[0] == false || count($edus[1]) < 1) {
    goto noEdus;
}

$html .= '<dt> '.lang("educations").'</dt><dd>';

for ($i = 0; $i < count($edus[1]);$i++){
    $html .= '<h2>'.$edus[1][$i]["education_name"].' - '.$edus[1][$i]["education_department"].'</h2>';
    $html .= '<p>'.$edus[1][$i]["education_start"]." ".($edus[1][$i]["education_end"] != $edus[1][$i]["education_start"] && $edus[1][$i]["education_end"] != "0000-00-00"?$edus[1][$i]["education_end"]:"");

    if($edus[1][$i]["education_note"] > 0){
        $html .= '<br>'.$edus[1][$i]["education_note"].'/4.00<br>';
    }

    $html .= '</p>';
}

$html .= '</dd>';

noEdus:

$skills = $profile->selectSkill();

if ($skills[0] == false || count($skills[1]) < 1) {
    goto noSkills;
}

$html .='<dd class="clear"></dd>';

$html .= '<dt> '.lang("skills").'</dt><dd>';

for ($i = 0; $i < count($skills[1]);$i++){
    $html .= '<h2><p>'.$skills[1][$i]["skill_name"].' - '.$skills[1][$i]["skill_level"].'/5</p></h2>';
}

$html .= "</dd><dd class='clear'></dd>";


noSkills:

$exps = $profile->selectExperience();

if ($exps[0] == false || count($exps[1]) < 1) {
    goto noExps;
}

$html .= '<dt> '.lang("experiences").'</dt><dd>';

for ($i = 0; $i < count($exps[1]);$i++){
    $html .= '<h2>'.$exps[1][$i]["experience_name"].' - '.$exps[1][$i]["experience_company"].'</h2>';
    $html .= '<p>'.$exps[1][$i]["experience_start"]." ".($exps[1][$i]["experience_end"] != $exps[1][$i]["experience_start"] && $exps[1][$i]["experience_end"] != "0000-00-00"?$exps[1][$i]["experience_end"]:"");

    if($exps[1][$i]["experience_desc"] != ""){
        $html .= '<br>'.$exps[1][$i]["experience_desc"].'<br>';
    }

    $html .= '</p>';
}

$html .= '</dd><dd class=\'clear\'></dd>';

noExps:

$refs = $profile->selectReference();

if ($refs[0] == false || count($refs[1]) < 1) {
    goto noRefs;
}

$html .= '<dt> '.lang("references").'</dt><dd>';

for ($i = 0; $i < count($refs[1]);$i++){
    $html .= '<h2>'.$refs[1][$i]["reference_name"].' - '.$refs[1][$i]["reference_company"].'</h2>';
    $html .= '<p>'.$refs[1][$i]["reference_title"]."<br>".$refs[1][$i]["reference_email"]." ".$refs[1][$i]["reference_gsm"];

    $html .= '</p>';
}

$html .= '</dd><dd class=\'clear\'></dd>';

noRefs:

$certs = $profile->selectCertificate();

if ($certs[0] == false || count($certs[1]) < 1) {
    goto noCerts;
}

$html .= '<dt> '.lang("certificates").'</dt><dd>';

for ($i = 0; $i < count($certs[1]);$i++){
    $html .= '<h2>'.$certs[1][$i]["certificate_name"].' - '.$certs[1][$i]["certificate_company"].'</h2>';
    $html .= '<p>'.$certs[1][$i]["certificate_desc"]."<br>".$certs[1][$i]["certificate_date"]." ".$certs[1][$i]["certificate_url"];

    $html .= '</p>';
}

$html .= '</dd>';

noCerts:

$html .= '

    <dd class="clear"></dd>

 
    </dl>

    <div class="clear"></div>

    </div>

    </body>

    </html>

<?php
';

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("dompdf_out.pdf", array("Attachment" => false));

//echo $html;
