<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 13-05-2019
 * Time : 19:18
 */

if (!isset($isAllowRequest)) {
    die();
}

$title = lang("page_company_main");

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";

if($user->type != 1&& $user->power < Perm::SUPPORT){
    echo lang("perm_error");
    die();
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?=lang("job_avs")?></h5>
                <p class="card-text"><?=lang("job_adv_desc")?></p>
                <a href="company.php?page=job" class="card-link"><?=lang("go")?></a>
            </div>
        </div>
    </div>
</div>



