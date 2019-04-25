<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 25-04-2019
 * Time : 16:20
 */

$title = lang("page_find_job");

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";

?>

<div class="contains">
    <div class="row">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">
            <div id="area_search_job">

            </div>

            <form id="form_search_job">


                <div class="form-group">
                    <input type="submit" class="form-control bg-primary" value="<?= lang('search_now') ?>"
                </div>
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="fj_keyword"><?= lang("lbl_fj_keyword") ?></label>
                            <input type="text" class="form-control" name="fj_keyword"
                                   placeholder="<?= lang('hint_fj_keyword') ?>">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="fj_country"><?= lang("lbl_country") ?></label>
                            <select class="form-control" id="fj_country" name="fj_country"
                                    onchange="getLocation(this.value,1, 'fj_city')"
                            >
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="fj_city"><?= lang("lbl_city") ?></label>
                            <select class="form-control" id="fj_city" name="fj_city" onclick="getDistrict(this.value)"
                            >
                                <?php
                                    $category = file_get_contents( $_SERVER["DOCUMENT_ROOT"]."/const/category.json", true);
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card" id="card-distinct">

                    <div class="card-body">
                        <div class="form-group">
                            <label><?= lang("lbl_country") ?></label>
                        </div>
                        <div id="content-distinct">
                        </div>
                    </div>
                </div>

                <div class="card" id="card-work-type">

                    <div class="card-body">
                        <div class="form-group">
                            <label><?= lang("lbl_country") ?></label>
                        </div>
                        <div class="form-group">
                            <?php
                            $workType = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/const/work_type_" . $currentLang . ".json"), true);

                            for ($i = 0; $i < count($workType); $i++) {
                                echo '<div class="custom-control custom-checkbox custom-control-inline">';
                                echo '<input type="checkbox" class="custom-control-input" id="work_type' . $workType[$i]["id"] . '" name="work_type[]" value="' . $workType[$i]["id"] . '">';
                                echo '<label class="custom-control-label" for="work_type' . $workType[$i]["id"] . '">' . $workType[$i]["text"] . '</label>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="fj_category"><?= lang("lbl_country") ?></label>
                            <select class="form-control" id="fj_category" name="fj_category"
                                    onchange='loadCheck("category_"+this.value, "category", "content_sub_category", "category")'
                            >

                            </select>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <div class="form-group">
                                <label><?= lang("lbl_country") ?></label>
                            </div>
                            <div id="content_sub_category">

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        getLocation(0, 0, "fj_country");
        getLocation(0, 1, "fj_city");
        loadSelect("category", "category", "fj_category", "category");
    });
</script>