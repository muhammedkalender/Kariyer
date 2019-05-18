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

            <button class="form-control bg-warning text-white" onclick="loadMoreJob(this)"><?=lang("load_more_job")?></button>

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
    function jobView(){
        var html = '<div class="container-fluid">' +
            '            <div class="row">' +
            '            <div class="col-12 mt-3">' +
            '            <div class="card">' +
            '            <div class="card-horizontal">' +
            '            <div class="img-square-wrapper">' +
            '            <img class="" src="http://via.placeholder.com/180x180" alt="Card image cap">' +
            '            <b><p class="card-text text-center text-bold">Arslan Company</p></b>' +
            '        </div>' +
            '        <div class="card-body">' +
            '            <h4 class="card-title">Senior Android Devoloper</h4>' +
            '        <p class="card-text">Tam Zamanlı</p>' +
            '        <p class="align-text-bottom">Bilgisyaar / Yazılım Mimarı</p>' +
            '        <p class="align-text-bottom">İstanbul ( Tuzla, Pendik, Kartar )</p>' +
            '            </div>' +
            '            </div>' +
            '            <div class="card-footer">' +
            '            <button class="form-control bg-success text-white">İncele</button>' +
            '            </div>' +
            '            </div>' +
            '            </div>' +
            '            </div>' +
            '            </div>';

        $("#area_search_job").append(html);
    }

    var  keyword = "";
    var page = 0;
    var count = 5;
    var active = "";

    function loadMoreJob(button){
        if (button != null) {
            button.disabled = true;
        }

        $.post("api.php",
            {
                "call_category": "job",
                "call_request": "select",
                "keyword": keyword,
                "page": page,
                "count": count,
                "user":0,
                "active": active
            }, function (data, status) {

            console.log(data);

                if (status == "success") {

                    var result = JSON.parse(data);

                    if (result[0]) {
                        page++;
                        result = result[1][1];
                        var html = "";

                        for (var i = 0; i < result.length; i++) {
                            if(result[i]["job_adv_close"] == null){
                                result[i]["job_adv_close"] = "-";
                            }


                            html += "<tr><td><b>" + result[i]["job_adv_id"] + "</b></td>";
                            html += "<td>" + result[i]["job_adv_title"] + "</td>";
                            html += "<td>" + result[i]["company_name"] + "</td>";
                            html += "<td>" + result[i]["job_adv_close"] +"</td>";
                            html += "<td>" + result[i]["job_adv_app"] + "</td>";
                            html += "<td>" + result[i]["job_adv_view"] + "</td>";
                            html += "<td>" + lmjaItemActions(result[i]["job_adv_id"]) + "</td></tr>";
                        }

                        if (append) {
                            $("#table_job").append(html);
                        } else {
                            $("#table_job").html(html);
                        }
                    }else{
                        Message.error(result[1],"");
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
    });
</script>