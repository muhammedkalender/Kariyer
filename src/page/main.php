<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 25-04-2019
 * Time : 16:29
 */

if (!isset($isAllowRequest)) {
    die();
}

$title = lang("page_main");

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";


$activeJobs = DB::select("SELECT COUNT(*) AS ai FROM job_adv WHERE  job_adv_active = 1 AND( job_adv_close = '' OR job_adv_close IS NULL)")[1][0]["ai"];
$jobApply = DB::select("SELECT COUNT(*) AS ai FROM job_apply")[1][0]["ai"];
$activeMembers = DB::select("SELECT COUNT(*) AS ai FROM member WHERE  member_active = 1 AND member_type = 0")[1][0]["ai"];
$activeCompanys = DB::select("SELECT COUNT(*) AS ai FROM member WHERE  member_active = 1 AND member_type = 1")[1][0]["ai"];

?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <p class="text-center font-weight-bold">
                <?=lang("main_message", $activeJobs)?>
            </p>
        </div>
        <div class="card-body">
<a href="index.php?page=is-ilanlari"> <button class="form-control btn-primary font-weight-bold"><?=lang("goto_jobs")?></button></a>
        </div>
    </div>

<br>
    <div class="card">
        <div class="card-header">
            <p class="font-weight-bol text-center"><?= lang("current_statics") ?></p>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <p class="text-center"><?= lang("active_jobs", $activeJobs) ?></p>
                </div>
                <div class="col-6">
                    <p class="text-center"><?= lang("job_applys", $jobApply) ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">
                    <p class="text-center"><?= lang("active_users", $activeMembers) ?></p>
                </div>
                <div class="col-6">
                    <p class="text-center"><?= lang("active_companys", $activeCompanys) ?></p>
                </div>
            </div>
        </div>

    </div>
</div>
