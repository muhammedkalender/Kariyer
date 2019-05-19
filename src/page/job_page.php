<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 18-05-2019
 * Time : 23:37
 */


if (!isset($isAllowRequest)) {
    die();
}

if (!isset($_GET["job_id"]) || intval($_GET["job_id"]) < 1) {
    echo "<center>" . message("404_", "job") . "</center>";
    die();
}


$jobId = intval($_GET["job_id"]);


$job = Job::getJobForView($jobId);

if ($job[0] == false) {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";
    echo "<center>" . $job[1] . "</center>";
    die();
}

$job = $job[1];


$title = $job["job_adv_title"];

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";

$applied = Job::checkApply($user->memberId, $jobId);
Job::addView($jobId);
?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-horizontal">
                                <div class="img-square-wrapper">
                                    <a href="index.php?page=company_profile&company_id=<?= $job["job_adv_author"] ?>"><img
                                                class=""
                                                style="width: 180px; height: 180px"
                                                src="<?= $job["company_image"] ?>"
                                                alt="<?= $job["company_name"] ?>">
                                        <b><p class="card-text text-center text-bold"><?= $job["company_name"] ?></p>
                                        </b></a>
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><?= $job["job_adv_title"] ?></h4>
                                    <p class="card-text"><?= lang("work_type_" . $job["job_adv_type"]) ?></p>
                                    <p class="align-text-bottom"><?= $job["category"] ?></p>
                                    <p class="align-text-bottom"><?= $job["fatherLocation"] ?>
                                        ( <?= $job["locations"] ?> )</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button onclick="showApplyJob(<?= $job["job_adv_id"] ?>)"
                                        id="btn_job_apply"
                                        class="form-control bg-info text-white" <?= $applied ?"disabled":""?>><?= $applied ? lang("already_apply_job") : lang("apply_job") ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <?= Valid::decode($job["job_adv_description"]); ?>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <p class="text-center font-weight-bold"><?= lang("job_view", ($job["job_adv_view"] + 1) . "") ?></p>
                </div>
                <div class="col-6">
                    <p class="text-center font-weight-bold"
                       id="job_apply"><?= lang("job_apply", ($job["job_adv_app"]) . "") ?></p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal-apply-job">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h4 class="modal-title"><?= lang("do_apply_job") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-apply-job')">&times;
                </button>
            </div>

            <div class="modal-body">
                <input id="apply-job-id" value="0" type="hidden">

                <div class="form-group">
                    <label class="text-center"><?= lang("are_you_sure_job") ?></label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="applyJob(this); closeModal('modal-apply-job')"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-apply-job')"><?= message("cancel") ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    function applyJob(button) {
        var id = itemValue("apply-job-id");

        if (id == 0) {
            return;
        }

        if (button != null) {
            button.disabled = true;
        }

        $.post("api.php", {
            "call_category" :"job",
            "call_request" : "apply_job",
            "job_id" : id
            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (data[0]) {
                        Message.success(data[1]);
                        item("btn_job_apply").disabled = true;
                    }else{
                        Message.error(data[1]);
                    }

                    button.disabled = false;
                } else {
                    //todo
                }
            }
        );
    }

    function showApplyJob(id) {
        setValue("apply-job-id", id);

        openModal("modal-apply-job");
    }

</script>