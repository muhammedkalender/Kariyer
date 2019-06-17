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
<!-- https://www.unicorntraining.com/blog/top-tips-for-learning--work-week -->
<div class="container-fluid"
     style="background-image: url('./images/hint.jpeg');  background-position: center; background-repeat:  repeat;">
    <div class="row">
        <div class="col-1">

        </div>
        <center class="col-10">
            <br>
            <center><h3 class="text-center text-white shadow-black"><?= lang("main_text_1", $activeJobs) ?></h3>
            </center>
            <br>
            <center>
                <div class="row col-8">
                        <input type="text" class="form-control input-lg" id="keyword"
                               placeholder="<?= lang('hint_fj_keyword') ?>">
                </div>
            </center>
            <br>
            <center>
                <button class="btn btn-outline-light font-weight-bold btn-lg"
                        onclick="goPage()"><?= lang("search_now") ?></button>
            </center>
            <br>
            <center><h5 class="text-white shadow-black"><?= lang("or") ?></h5></center>
            <br>
            <center>
                <a href="index.php?page=is-ilanlari">
                    <button class="btn btn-outline-primary font-weight-bold btn-lg">
                        <?= lang("go_search_job") ?>
                    </button>
                </a>
            </center>
            <br>
    </div>

    <div class="col-1">
    </div>
</div>
</div>

<div class="container">
    <br>
    <div class="card">
        <div class="card-header text-center text-white font-weight-bold bg-gedik">
            <h4 class=""><?= lang("current_statics") ?></h4>
        </div>

        <div class="card-body bg-secondary">
            <div class="row">
                <div class="col-6">
                    <h5 class="text-center  statics-badge text-white"><?= lang("active_jobs", $activeJobs) ?></h5>
                </div>
                <div class="col-6 ">
                    <h5 class="text-center statics-badge text-white"><?= lang("job_applys", $jobApply) ?></h5>
                </div>
            </div>
            <hr class="text-white">
            <div class="row">
                <div class="col-6">
                    <h5 class="text-center statics-badge text-white"><?= lang("active_users", $activeMembers) ?></h5>
                </div>
                <div class="col-6">
                    <h5 class="text-center statics-badge text-white"><?= lang("active_companys", $activeCompanys) ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function goPage() {
        window.location.href = "index.php?page=is-ilanlari&keyword=" + itemValue("keyword");
    }
</script>