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
//todo
}

?>


<div class="contains">
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">
            <input type="hidden" name="call_category" value="job">
            <input type="hidden" name="call_request" value="<?= $jobId != 0 ? "update" : "insert" ?>">
            <!-- alert-danger, alert-success, alert-primary -->
            <div class="alert" id="job-edit-result" style="display: none">
            </div>

            <form id="form_edit_job" action="#" onsubmit="return false">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="et_tittle"><?= lang("lbl_et_tittle") ?></label>
                            <input type="text" class="form-control" name="et_tittle"
                                   placeholder="<?= lang('hint_ej_title') ?>" minlength="3" maxlength="256">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="ej_desc"><?= lang("lbl_ej_desc") ?></label>
                            <textarea minlength="3" maxlength="2048" name="ej_desc" class="form-control" placeholder="<?= lang('hint_ej_desc') ?>">

                            </textarea>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="fj_country"><?= lang("lbl_location") ?></label>
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
                            <label><?= lang("lbl_work_type") ?></label>
                        </div>
                        <div class="form-group ">
                            <?php
                            $workType = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/const/work_type_" . $currentLang . ".json"), true);

                            for ($i = 0; $i < count($workType); $i++) {
                                echo '<div class="form-check custom-control-inline">';
                                echo '<input class="form-check-input" type="radio" name="work_type" id="work_type' . $workType[$i]["id"] . '" value="' . $workType[$i]["id"] . '"' . ($i == 0 ? "checked" : "") . '>';
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
                            <label for="fj_category"><?= lang("lbl_category") ?></label>
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
                <input type="submit" class="form-control bg-success" onclick="jobEdit()" value="<?= message('apply') ?>">
            </form>
        </div>
    </div>
</div>


<script>
    function jobEdit() {
        if ($("#form_edit_job")[0].checkValidity() === false) {
            return;
        }

//        postForm('form_edit_job', '/', 5000);
    }

    $(document).ready(function () {
        getLocation(0, 0, "fj_country");
        getLocation(0, 1, "fj_city");
        loadSelect("category", "category", "fj_category", "category");
    });
</script>
