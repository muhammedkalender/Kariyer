<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 16-05-2019
 * Time : 17:30
 */

if (!isset($isAllowRequest)) {
    die();
}
//todo auth sadece başvurduğu şirket yada kendi
$userId = "";

if (isset($_GET["user"])) {
    $userId = intval($_GET["user"]);
}

$profile = $user;

if ($userId > 0 && $userId != $user->memberId) {
    $profile = new User($userId);
} else {
    $profile = $user;
}

$title = $profile->name . " " . $profile->surname;

include_once $_SERVER['DOCUMENT_ROOT'] . "/page/header.php";
?>

<div class="container">
    <form class="">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                   placeholder="Enter email">
        </div>
    </form>
    <div class="row">
        <div class="col-md-1">

        </div>

        <div class="text-center">
            <img src="./images/profile.jpg" class="rounded" style="width: 256px" alt="...">
        </div>


        <br>
        <p class="font-weight-bold"><?= $profile->name . " " . $profile->surname ?></p>
        <p class="font-weight-bold"><?= $profile->name . " " . $profile->surname ?></p>
    </div>

    <div class="card">
        <div class="card-header">
            <?php
            echo lang("experiences");

            if ($profile->memberId == $user->memberId) {
                echo "<button class='btn' title='" . lang("add_experience") . "' onclick='showEditExp(0)'><i class='fa fa-plus'></i></button>";
            }
            ?>
        </div>
        <div class="card-body">
            <?php
            $exps = $profile->getExperience();
            $expHTML = "";

            if ($exps[0]) {
///                    $certs = json_decode($certs[1]);
                $exps = $exps[1];
                for ($i = 0; $i < count($exps); $i++) {
                    if ($i > 0) {
                        $expHTML .= "<hr>";
                    }

                    $expDate = $exps[$i]["experience_start"];

                    if ($expDate == $exps[$i]["experience_end"]) {
                        $expDate = $exps[$i]["experience_start"] . " - " . lang("resuming");
                    } else {
                        $expDate = $exps[$i]["experience_start"] . " - " . $exps[$i]["experience_end"];
                    }

                    $expHTML .= '<blockquote class="blockquote mb-0"><h6>' . $exps[$i]["experience_name"] . '</h6>
                    <p>' . $exps[$i]["experience_desc"] . ' </p>
                <footer class="blockquote-footer">' . $expDate . ' <cite title="Source Title">' . $exps[$i]["experience_company"] . '</cite></footer>
            </blockquote>';

                    if ($profile->memberId == $user->memberId) {
                        $expHTML .= "<div class='row'><button class='btn' title='" . lang("edit_experience") . "' onclick='showEditExp(" . $exps[$i]["experience_id"] . ")'><i class='fa fa-edit'></i></button><button class='btn' title='" . lang("delete_experience") . "' onclick='openModal(\"modal-delete-exp\"); item(\"delete-exp-id\").value = " . $exps[$i]["experience_id"] . "'><i class='fa fa-trash'></i></button></div>";
                    }
                }

                echo $expHTML;
            } else {
                //todo
            }
            ?>
        </div>
    </div>
    <br>

    <div class="card">
        <div class="card-header">
            <?php
            echo lang("certificates");

            if ($profile->memberId == $user->memberId) {
                echo "<button class='btn' title='" . lang("add_certificate") . "' onclick='showEditCert(0)'><i class='fa fa-plus'></i></button>";
            }
            ?>
        </div>
        <div class="card-body">
            <?php
            $certs = $profile->getCertificate();
            $certsHTML = "";

            if ($certs[0]) {
///                    $certs = json_decode($certs[1]);
                $certs = $certs[1];
                for ($i = 0; $i < count($certs); $i++) {
                    if ($i > 0) {
                        $certsHTML .= "<hr>";
                    }
                    $certsHTML .= '<blockquote class="blockquote mb-0"><a href="' . $certs[$i]["certificate_url"] . '"><h6>' . $certs[$i]["certificate_name"] . '</h6></a>
                     <p>' . $certs[$i]["certificate_desc"] . ' </p>
                <footer class="blockquote-footer">' . $certs[$i]["certificate_date"] . ' <cite title="Source Title">' . $certs[$i]["certificate_company"] . '</cite></footer>
            </blockquote>';

                    if ($profile->memberId == $user->memberId) {
                        $certsHTML .= "<div class='row'><button class='btn' title='" . lang("edit_certificate") . "' onclick='showEditCert(" . $certs[$i]["certificate_id"] . ")'><i class='fa fa-edit'></i></button><button class='btn' title='" . lang("delete_certificate") . "' onclick='openModal(\"modal-delete-certificate\"); item(\"delete-certificate-id\").value = " . $certs[$i]["certificate_id"] . "'><i class='fa fa-trash'></i></button></div>";
                    }
                }

                echo $certsHTML;
            } else {
                //todo
            }
            ?>
        </div>
    </div>
</div>

<div class="modal" id="modal-delete-certificate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("delete_certificate") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-delete-certificate')">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="alert" id="modal-delete-certificate-result" style="display: none">
                </div>

                <input id="delete-certificate-id" value="0" type="hidden">

                <div class="form-group">
                    <label><?= lang("are_you_sure") ?></label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="deleteCertificate(this); closeModal('modal-certificate-job')"><?=message("confirm")?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-delete-certificate')"><?=message("cancel")?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal-delete-exp">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("delete_experience") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-delete-exp')">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="alert" id="modal-delete-exp-result" style="display: none">
                </div>

                <input id="delete-exp-id" value="0" type="hidden">

                <div class="form-group">
                    <label><?= lang("are_you_sure") ?></label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="deleteExp(this); closeModal('modal-exp-job')"><?=message("confirm")?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-delete-exp')"><?=message("cancel")?></button>
            </div>
        </div>
    </div>
</div>

<script>

    function showEditExp(id) {
        if(id == 0){}
        //todo
    }

</script>