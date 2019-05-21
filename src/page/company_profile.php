<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 19-05-2019
 * Time : 21:56
 */


if (!isset($isAllowRequest)) {
    die();
}
//todo auth sadece başvurduğu şirket yada kendi
$userId = "";

if (isset($_GET["company"])) {
    $userId = intval($_GET["company"]);
}

$profile = $user;
$ro = "";
$dasAdmin = false;

if ($userId > 0 && $userId != $user->memberId) {
    $ro = "readonly";
    $profile = new User($userId);

    if($user->power >= Perm::SUPPORT && $user->power > $profile->power){
        $ro = "";
        $dasAdmin = true;
    }
} else {
    $profile = $user;
}

$title = $profile->name . " " . $profile->surname;

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";

if ($profile->type != 1) {
    $title = lang("unknown_company");
    include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";
    echo '<script>Message.error("'.lang("unknown_company").'"); href("/", 3000);</script>';
    die();
}
?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <?php
            if ($dasAdmin) {
                echo '<button class="btn btn-danger" onclick="changeUserStatus()" >' . lang("change_status_user") . '</button><br>';
                echo '<p>Status : '.($profile->active?'Aktif':'Pasif');
            }
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-horizontal">
                                <div class="img-square-wrapper col-md-3">
                                    <img id="profileImage"
                                         style="width: 180px; height: 180px"
                                         src="<?= "/images/profile/" . $profile->picture ?>"
                                         alt="<?= $title ?>">

                                    <?php
                                    if ($ro == "") {
                                        echo '<form id="test"><br><input type="file" id="file" onchange="changeImage()" name="file" class="button col-md-10" placeholder="' . lang("upload_image") . '"></form>';
                                    }
                                    ?>
                                </div>
                                <div class="card-body ">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2"><?= lang("company_name") ?></label>
                                        <input type="text" id="name" lang="name" class="form-control col-sm-10"
                                               value="<?= $title ?>" <?= $ro ?>>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email"
                                               class="col-sm-2 col-form-label"><?= lang("user_email") ?></label>
                                        <input type="text" id="email" lang="email" class="form-control col-sm-10"
                                               value="<?= $profile->email ?>" <?= $ro ?>>
                                    </div>

                                    <div class="form-group row">
                                        <label for="gsm"
                                               class="col-sm-2 col-form-label"><?= lang("company_gsm") ?></label>
                                        <input type="text" id="gsm" lang="gsm" class="form-control col-sm-10"
                                               value="<?= $profile->gsm ?>" <?= $ro ?>>
                                    </div>

                                    <div class="form-group row">
                                        <label for="fax"
                                               class="col-sm-2 col-form-label"><?= lang("company_fax") ?></label>
                                        <input type="text" id="fax" lang="fax" class="form-control col-sm-10"
                                               value="<?= $profile->fax ?>" <?= $ro ?>>
                                    </div>

                                    <div class="form-group row">
                                        <label for="bd"
                                               class="col-sm-2 col-form-label"><?= lang("company_bd") ?></label>
                                        <input type="date" id="bd" lang="bd" class="form-control col-sm-10"
                                               value="<?= $profile->birt_date !=""? $profile->birt_date : "2000-01-01" ?>" <?= $ro ?>>
                                    </div>

                                    <div class="form-group row">
                                        <label for="website"
                                               class="col-sm-2 col-form-label"><?= lang("user_website") ?></label>
                                        <input type="url" id="website" lang="website" class="form-control col-sm-10"
                                               value="<?= $profile->website ?>" <?= $ro ?>>
                                    </div>
                                    <div class="form-group row">
                                        <label for="address"
                                               class="col-sm-2 col-form-label"><?= lang("user_address") ?></label>
                                        <textarea id="address" lang="address"
                                                  class="form-control col-sm-10"<?= $ro ?>><?= $profile->address ?></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if ($ro == "") {
            echo '<div class="card-footer"> <button type="button" onclick="saveUser(this)" class=" form-control btn btn-success">' . lang("save") . '</button></div>';
        }
        ?>
    </div>
    <br>

    <?php
    if ($ro != "" && $profile->description == "") {
        goto noDesc;
    }
    ?>

    <div class="card">
        <div class="card-header">
            <?= lang("company_description") ?>
        </div>

        <div class="card-body">
            <textarea class="form-control itsmce" id="user_desc">
                <?= Valid::decode($profile->description) ?>
            </textarea>
        </div>

        <div class="card-footer">
            <button type="button" class="btn btn-info" onclick="saveDesc(this)"><?= lang("save") ?></button>
        </div>
    </div>

    <br>

    <?php
    noDesc:

    if ($profile->memberId != $user->memberId) {
        goto noPassword;
    }

    ?>

    <br>

    <div class="card">
        <div class="card-header"><?= lang("change_password") ?></div>
        <div class="card-body">
            <div class="form-group">
                <label for="current_password"><?= lang("current_password") ?></label>
                <input type="password" class="form-control" id="current_password" name="current_password"
                       placeholder="<?= lang("current_password") ?>">
            </div>

            <div class="form-group">
                <label for="n_password"><?= lang("password") ?></label>
                <input type="password" class="form-control" id="n_password" name="n_password"
                       placeholder="<?= lang("password") ?>">
            </div>

            <div class="form-group">
                <label for="n_password_repeat"><?= lang("password_repeat") ?></label>
                <input type="password" class="form-control" id="n_password_repeat" name="n_password_repeat"
                       placeholder="<?= lang("password_repeat") ?>">
            </div>

            <button class="btn btn-warning" onclick="changePassword(this)"><?= lang("change_password") ?></button>

        </div>
    </div>
    <?php
    noPassword:
    ?>
    <br>
    <div class="card">
        <div class="card-header">
            <?= lang("company_jobs") ?>
        </div>
        <div class="card-body" id="area_search_job">
            <center><?= lang("company_jobs_null") ?></center>
        </div>

        <div class="card-footer">
            <button class="form-control bg-warning text-white"
                    onclick="loadMoreJob(this)"><?= lang("load_more_job") ?></button>
        </div>
    </div>


</div>
<script>
    function changeUserStatus() {
        $.post("api.php", {
            "call_category": "user",
            "call_request": "change_status",
            "user":<?=$profile->memberId?>
        }, function (data, result) {
            if(result == "success"){
                data = JSON.parse(data);

                if(data[0]){
                    Message.success(data[1]);
                }else{
                    Message.error(data[1]);
                }
            }
        });
    }

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
            '            <a href="index.php?page=ilani-gor&job_id=' + id + '" target="_blank"><button class="btn btn-outline-success btn-block"><?=lang("view")?></button></a>' +
            '            </div>' +
            '            </div>' +
            '            </div>' +
            '            </div>' +
            '            </div>';

        $("#area_search_job").append(html);
    }

    function searchJob(button) {
        company = <?=$profile->memberId?>;

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
    var company = <?=$profile->memberId?>;
    var first = true;
    var firstShow = true;

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
                "company": company,
                "special": 0
            }, function (data, status) {

                console.log(data);

                if (status == "success") {
                    var result = JSON.parse(data);

                    if (result[0]) {
                        page++;
                        result = result[1][1];
                        var html = "";

                        if (first && result.length > 0) {
                            document.getElementById("area_search_job").innerHTML = "";
                            first = false;
                        }

                        for (var i = 0; i < result.length; i++) {
                            if (result[i]["job_adv_close"] == null) {
                                result[i]["job_adv_close"] = "-";
                            }

                            jobView(result[i]["job_adv_id"], result[i]["job_adv_title"], result[i]["job_adv_author"], result[i]["company_name"], result[i]["companyImage"], result[i]["category"], result[i]["locations"], result[i]["fatherLocation"], result[i]["job_adv_type"]);
                        }

                        $("#area_search_job").append(html);
                    } else {
                        if (firstShow) {
                            firstShow = false;
                        } else {
                            Message.error(result[1], "");
                        }
                    }
                }

                if (button != null) {
                    button.disabled = false;
                }
            });
    }

    var okFile = '<?=lang("ok_file")?>';
    var notFile = '<?=lang("not_file")?>';

    function changePassword(button) {
        if (button != null) {
            button.disabled = true;
        }

        if (itemValue("n_password") != itemValue("n_password_repeat")) {
            Message.error('<?=lang("password_match")?>');

            if (button != null) {
                button.disabled = false;
            }
            return;
        }

        $.post("api.php", {
            "call_category": "user",
            "call_request": "change_password",
            "current_password": itemValue("current_password"),
            "password": itemValue("n_password"),
            "member":<?=$profile->memberId?>
        }, function (data, status) {
            if (status == "success") {
                data = JSON.parse(data);

                if (data[0]) {
                    Message.success(data[1]);
                } else {
                    Message.error(data[1]);
                }
            } else {
                //todo
            }

            if (button != null) {
                button.disabled = false;
            }
        });

    }

    function changeImage() {
        if ($('#file')[0].files[0] == null) {
            return;
        }

        var file = $('#file')[0].files[0];

        if (file.size > (1024 * 1024 * 2)) {
            //todo 2 mb limit
        }

        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file', files);
        fd.append('call_category', "user");
        fd.append('call_request', "upload_profile_image");
        fd.append("user",<?=$profile->memberId?>)
        //https://makitweb.com/how-to-upload-image-file-using-ajax-and-jquery/
        $.ajax({
            url: 'api.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                response = JSON.parse(response);

                console.log(response);
                if (response[0]) {
                    Message.success(response[1]);
                    $("#profileImage").attr("src", "/images/profile/" + response[2]);
                    // $(".preview img").show(); // Display image element
                } else {
                    Message.error(response[1]);
                    //todo alert('file not uploaded');
                }
                $('#file').val("");
            },
        });
    }

    function saveUser(button) {
        if (button != null) {
            button.disabled = true;
        }

        $.post("api.php", {
            "call_category": "user",
            "call_request": "update_company_info",
            "user_id": <?=$profile->memberId?>,
            "user_email": itemValue("email"),
            "company_name": itemValue("name"),
            "user_gsm": itemValue("gsm"),
            "user_fax": itemValue("fax"),
            "company_bd": itemValue("bd"),
            "user_website": itemValue("website"),
            "user_address": itemValue("address")
        }, function (data, result) {
            console.log(data);
            if (result == "success") {
                data = JSON.parse(data);

                if (data[0]) {
                    Message.success(data[1]);
                } else {
                    Message.error(data[1]);
                }
            }

            if (button != null) {
                button.disabled = false;
            }
        });
    }

    function saveDesc(button) {
        if (button != null) {
            button.disabled = true;
        }

        var desc = tinyMCE.get('user_desc').getContent();

        $.post("api.php", {
            "call_category": "user",
            "call_request": "update_desc",
            "user_id": <?=$profile->memberId?>,
            "user_desc": desc
        }, function (data, result) {
            if (result == "success") {
                data = JSON.parse(data);

                if (data[0]) {
                    Message.success(data[1]);
                } else {
                    Message.error(data[1]);
                }
            }


            if (button != null) {
                button.disabled = false;
            }
        });
    }

    $(document).ready(function () {
        tinymce.init({mode: "specific_textareas", editor_selector: 'itsmce'});
        reset = true;
        loadMoreJob(null);
    });
</script>