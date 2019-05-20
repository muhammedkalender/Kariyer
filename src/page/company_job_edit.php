<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 14-05-2019
 * Time : 22:58
 */

if (!isset($isAllowRequest)) {
    die();
}

$title = lang("page_company_job");

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";

$jobId = 0;
if (isset($_GET["job_id"])) {
    $jobId = $_GET["job_id"];
//todo
}

if($user->type != 1&& $user->power < Perm::SUPPORT){
    echo lang("perm_error");
    die();
}
?>


<div class="contains">
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">
            <div class="alert" id="modal-edit-job-result" style="display: none">
            </div>

            <form id="modal-edit-job-form" action="#" onsubmit="return false">
                <input type="hidden" name="call_category" value="job">
                <input type="hidden" name="call_request" value="<?= $jobId != 0 ? "update" : "insert" ?>">
                <input type="hidden" name="job_id" value="<?= $jobId ?>">
                <input type="hidden" name="job_desc" id="job_desc" value="">
                <!-- alert-danger, alert-success, alert-primary -->

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="job_title"><?= lang("var_job_title") ?></label>
                            <input type="text" class="form-control" id="job_title" name="job_title"
                                   placeholder="<?= lang('hint_job_title') ?>" minlength="3" maxlength="256">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="job_desc_tiny"><?= lang("var_job_description") ?></label>
                            <textarea  minlength="3" maxlength="2048" id="job_desc_tiny" name="job_desc_tiny" class="form-control itsmce"
                                      placeholder="<?= lang('hint_job_desc') ?>"></textarea>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="fj_country"><?= lang("var_job_location") ?></label>
                            <select class="form-control" id="fj_country" name="fj_country"
                                    onchange="getLocation(this.value,1, 'fj_city')" required
                            >
                            </select>
                        </div>


                        <div class="form-group">
                            <select class="form-control" id="fj_city" name="fj_city" onclick="getDistrict(this.value)"
                                    required>
                                <?php
                                $category = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/const/category.json", true);
                                ?>
                            </select>
                        </div>

                        <div id="content-distinct">
                        </div>
                    </div>
                </div>

                <div class="card" id="card-work-type">

                    <div class="card-body">
                        <div class="form-group">
                            <label><?= lang("var_job_type") ?></label>
                        </div>
                        <div class="form-group ">
                            <?php
                            $workType = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/const/work_type_" . $currentLang . ".json"), true);

                            for ($i = 0; $i < count($workType); $i++) {
                                echo '<div class="form-check custom-control-inline">';
                                echo '<input class="form-check-input" type="radio" name="job_type" id="work_type' . $workType[$i]["id"] . '" value="' . $workType[$i]["id"] . '"' . ($i == 0 ? "checked" : "") . '>';
                                echo '<label class="form-check-label" for="work_type' . $workType[$i]["id"] . '">' . $workType[$i]["text"] . '</label>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?= lang("lbl_special") ?></label>
                        </div>
                        <div class="form-group ">
                            <select class="form-control" name="special" id="special">
                                <option value="0" selected><?=lang("job_special_0")?></option>
                                <option value="1"><?=lang("job_special_1")?></option>
                                <option value="2"><?=lang("job_special_2")?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="job_category"><?= lang("var_job_category") ?></label>
                            <select class="form-control" id="fj_category" name="fj_category"
                                    onchange='loadCheck("category_"+this.value, "category", "content_sub_category", "category")'
                                    required>

                            </select>
                        </div>

                        <div class="form-group">

                            <div id="content_sub_category">

                            </div>
                        </div>
                    </div>
                </div>

            </form>

            <input type="submit" class="form-control bg-success" onclick="jobEdit()"
                   value="<?= message('apply') ?>">
        </div>
    </div>
</div>


<script>
    function getJobEdit(id) {
        $.post("api.php",
            {
                'call_category': "job",
                'call_request': "get",
                'job_id': id

            },
            function (data, status) {
                if (status == "success") {
                    var result = JSON.parse(data);

                    if (result[0]) {
                        var job = result[1];
                        var locations = JSON.parse(result[2]);

                        if (locations.length > 0) {
                            getLocation(locations[0]["big_father"], 1, 'fj_city', (function () {
                                item("fj_country").value = locations[0]["big_father"];
                                item("fj_city").value = locations[0]["location_father"];
                                getDistrict(locations[0]["location_father"], function () {
                                    var objs = item("content-distinct").getElementsByTagName("input");

                                    for (var i = 0; i < objs.length; i++) {
                                        var ava = false;

                                        for (var j = 0; j < locations.length; j++) {
                                            if (objs[i].value == locations[j]["location_id"]) {
                                                ava = true;
                                            }
                                        }

                                        objs[i].checked = ava;
                                    }
                                });
                            }));
                        }

                        item("job_title").value = job["job_adv_title"];

                        tinyMCE.get('job_desc_tiny').setContent(job["job_adv_description"]);

                        var objs = item("card-work-type").getElementsByTagName("input");

                        for (var i = 0; i < objs.length;i++){
                            if(objs[i].value == job["job_adv_type"]){
                                objs[i].checked = true;
                            }else{
                                objs[i].checked = false;
                            }
                        }

                        item("fj_category").value = job["job_adv_category_father"];
                        loadCheck("category_"+job["job_adv_category_father"], "category", "content_sub_category", "category", function () {
                            var objs = item("content_sub_category").getElementsByTagName("input");

                            for (var i = 0; i < objs.length;i++){
                                if(objs[i].value == job["job_adv_category"]){
                                    objs[i].checked = true;
                                }else{
                                    objs[i].checked = false;
                                }
                            }
                        });

                        setValue("special", job["job_adv_special"]);

                        if (result[1]["job_adv_id"] !== 1) {
                          //  Message.success(result[1]["job_adv_id"])
                        }
                    } else {
                        Message.error(result[1])
                    }
                }
            });
        //todo o
    }


    function jobEdit(button) {
        //check todo
        var desc = tinyMCE.get('job_desc_tiny').getContent();

        item("job_desc").value = desc;
        postForm("edit-job", "", 0, button);

//        postForm('form_edit_job', '/', 5000);
    }

    $(document).ready(function () {
        getLocation(0, 0, "fj_country");
        getLocation(0, 1, "fj_city");
        loadSelect("category", "category", "fj_category", "category");

        tinymce.init({mode: "specific_textareas", editor_selector: 'itsmce'});

        var jobId = <?=$jobId?>;

        if (jobId != 0) {
            getJobEdit(jobId);
        }
    });
</script>
