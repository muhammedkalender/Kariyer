<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 25-04-2019
 * Time : 16:20
 */

if (!isset($isAllowRequest)) {
    die();
}

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

            <button class="form-control bg-warning text-white"
                    onclick="loadMoreJob(this)"><?= lang("load_more_job") ?></button>
            <br>
            <div class="form-group">
                <input type="submit" class="form-control bg-primary text-white" onclick="searchJob(this)"
                       value="<?= lang('search_now') ?>"
            </div>

            <br>
            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <label for="fj_keyword"><?= lang("lbl_fj_keyword") ?></label>
                        <input type="text" class="form-control" id="fj_keyword" name="fj_keyword"
                               placeholder="<?= lang('hint_fj_keyword') ?>">
                    </div>
                </div>
            </div>

            <br>
            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <label for="fj_country"><?= lang("lbl_country") ?></label>
                        <select class="form-control" id="fj_country" name="fj_country"
                                onchange="getLocation(this.value,1, 'fj_city')"
                        >
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="fj_city"><?= lang("lbl_city") ?></label>
                        <select class="form-control" id="fj_city" name="fj_city" onclick="getDistrict(this.value)"
                        >
                            <?php
                            $category = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/const/category.json", true);
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= lang("lbl_distinct") ?></label>
                    </div>
                    <div id="content-distinct">
                    </div>
                </div>
            </div>

            <br>
            <div class="card" id="card-work-type">
                <div class="card-body">
                    <div class="form-group">
                        <label><?= lang("lbl_work_type") ?></label>
                    </div>
                    <div class="form-group ">
                        <?php
                        echo '<div class="form-check custom-control-inline" onclick="type=0">';
                        echo '<input class="form-check-input" type="radio" name="job_type" id="work_type0" value="0"checked>';
                        echo '<label class="form-check-label" for="work_type0">' . lang("default_select") . '</label>';
                        echo '</div>';

                        $workType = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/const/work_type_" . $currentLang . ".json"), true);

                        for ($i = 0; $i < count($workType); $i++) {
                            echo '<div class="form-check custom-control-inline" onclick="type=' . $workType[$i]["id"] . ';">';
                            echo '<input class="form-check-input" type="radio" name="job_type" id="work_type' . $workType[$i]["id"] . '" value="' . $workType[$i]["id"] . '">';
                            echo '<label class="form-check-label" for="work_type' . $workType[$i]["id"] . '">' . $workType[$i]["text"] . '</label>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <label for="fj_category"><?= lang("lbl_category") ?></label>
                        <select class="form-control" id="fj_category" name="fj_category"
                                onchange='loadCheck("category_"+this.value, "category", "content_sub_category", "category")'
                        >

                        </select>
                    </div>

                    <div class="form-group">
                        <div id="content_sub_category">

                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label><?= lang("lbl_special") ?></label>
                    </div>
                    <div class="form-group ">
                       <select class="form-control" id="special">
                           <option value="0" selected><?=lang("job_special_0")?></option>
                           <option value="1"><?=lang("job_special_1")?></option>
                           <option value="2"><?=lang("job_special_2")?></option>
                       </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script>

    var workType = [];

    workType["work_type_1"] = "Tam Zamanlı";
    workType["work_type_2"] = "Part Time";
    workType["work_type_3"] = "Staj";
    workType["work_type_4"] = "Freelancer";
    workType["work_type_5"] = "Proje";
    workType["work_type_6"] = "Serbest";

    function jobView(id, name, company_id, company_name, company_image, category_path, locations, location_father, type) {
        var html = '<div class="container-fluid">' +
            '            <div class="row">' +
            '            <div class="col-12 mt-3">' +
            '            <div class="card">' +
            '            <div class="card-horizontal">' +
            '            <div class="img-square-wrapper">' +
            '            <a href="index.php?page=firma&company=' + company_id + '"><img class="" style="width: 180px; height: 180px" src="/images/profile/' + company_image + '" alt="' + company_name + '">' +
            '            <b><p class="card-text text-center text-bold">' + company_name + '</p></b></a>' +
            '        </div>' +
            '        <div class="card-body">' +
            '            <h4 class="card-title">' + name + '</h4>' +
            '        <p class="card-text">' + workType["work_type_" + type] + '</p>' +
            '        <p class="align-text-bottom">' + category_path + '</p>' +
            '        <p class="align-text-bottom">' + location_father + '( ' + locations + ' )</p>' +
            '            </div>' +
            '            </div>' +
            '            <div class="card-footer">' +
            '            <a href="index.php?page=ilani-gor&job_id=' + id + '"><button class="form-control bg-success text-white"><?=lang("view")?></button></a>' +
            '            </div>' +
            '            </div>' +
            '            </div>' +
            '            </div>' +
            '            </div>';

        $("#area_search_job").append(html);
    }

    function searchJob(button) {
        keyword = itemValue("fj_keyword");

        if (keyword.length < 3) {
            //todo
            //return;
        }

        if (lastKeyword == keyword) {
            //todo return;
        }

        lastKeyword = keyword;

        var cats = document.getElementsByName("category");

        if (cats.length > 0) {
            var avaible = false;

            for (var i = 0; i < cats.length; i++) {
                if (cats[i].checked) {
                    cat = cats[i].value;
                    avaible = true;
                }
            }

            if (!avaible) {
                cat = 0;
            }
        } else {
            cat = 0;
        }

        locations = "";

        var locationsObjs = document.getElementsByName("district[]");

        if (locationsObjs.length > 0) {
            for (var i = 0; i < locationsObjs.length; i++) {
                if(locationsObjs[i].checked){
                    if(locations != ""){
                        locations += ",";
                    }
                    locations += locationsObjs[i].value;
                }
            }
        } else {
            locations = "";
        }

        special = 0;

        if(itemValue("special") > 0){
            special = itemValue("special");
        }

        //locations = document.getElementsByName("district[]")[0].value;

        page = 0;

        $("#area_search_job").html("");

        loadMoreJob(button);

    }

    var lastKeyword = "";
    var keyword = "";
    var page = 0;
    var count = 5;
    var active = "";
    var type = 0;
    var cat = 0;
    var locations = "";
    var company = 0;
    var special =0;

    function loadMoreJob(button) {
        if (button != null) {
            button.disabled = true;
        }

        $.post("api.php",
            {
                "call_category": "job",
                "call_request": "search",
                "keyword": keyword,
                "page": page,
                "count": count,
                "user": 0,
                "active": active,
                "type": type,
                "cat": cat,
                "locations": locations,
                "company":company,
                "special":special
            }, function (data, status) {

                console.log(data);

                if (status == "success") {

                    var result = JSON.parse(data);

                    if (result[0]) {
                        page++;
                        result = result[1][1];
                        var html = "";

                        for (var i = 0; i < result.length; i++) {
                            if (result[i]["job_adv_close"] == null) {
                                result[i]["job_adv_close"] = "-";
                            }

                            jobView(result[i]["job_adv_id"], result[i]["job_adv_title"], result[i]["job_adv_author"], result[i]["company_name"], result[i]["companyImage"], result[i]["category"], result[i]["locations"], result[i]["fatherLocation"], result[i]["job_adv_type"]);
                        }

                        //todo
                        if (true) {
                            $("#area_search_job").append(html);
                        } else {
                            $("#area_search_job").html(html);
                        }
                    } else {
                        Message.error(result[1], "");
                    }
                }

                if (button != null) {
                    button.disabled = false;
                }
            });
    }

    $(document).ready(function () {
        getLocation(0, 0, "fj_country");
        getLocation(0, 1, "fj_city");
        loadSelect("category", "category", "fj_category", "category");

        loadMoreJob(null);
    });
</script>