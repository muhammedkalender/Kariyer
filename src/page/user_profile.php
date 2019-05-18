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
    <?php
    $exps = $profile->selectExperience();

    if ($exps[0] == false || count($exps[1]) < 1) {
        if ($profile->memberId != $user->memberId) {
            goto noExps;
        }
    }
    ?>
    <div class="card">
        <div class="card-header">
            <?php
            echo lang("experiences");

            if ($profile->memberId == $user->memberId) {
                echo "<button class='btn' title='" . lang("add_experience") . "' onclick='showExperience(0)'><i class='fa fa-plus'></i></button>";
            }
            ?>
        </div>
        <div class="card-body">
            <?php
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
                        $expHTML .= "<div class='row'><button class='btn' title='" . lang("edit_experience") . "' onclick='showExperience(" . $exps[$i]["experience_id"] . ")'><i class='fa fa-edit'></i></button><button class='btn' title='" . lang("delete_experience") . "' onclick='openModal(\"modal-delete-exp\"); item(\"delete-exp-id\").value = " . $exps[$i]["experience_id"] . "'><i class='fa fa-trash'></i></button></div>";
                    }
                }

                echo $expHTML;
            } else {
                //todo
            }

            noExps:
            ?>
        </div>
    </div>
    <br>

    <?php
    $edus = $profile->selectEducation();

    if ($edus[0] == false || count($edus[1]) < 1) {
        if ($profile->memberId != $user->memberId) {
            goto noEdus;
        }
    }
    ?>
    <div class="card">
        <div class="card-header">
            <?php
            echo lang("educations");

            if ($profile->memberId == $user->memberId) {
                echo "<button class='btn' title='" . lang("add_edu") . "' onclick='showEducation(0)'><i class='fa fa-plus'></i></button>";
            }
            ?>
        </div>
        <div class="card-body">
            <?php
            $eduHTML = "";

            if ($edus[0]) {
///                    $certs = json_decode($certs[1]);
                $edus = $edus[1];
                for ($i = 0; $i < count($edus); $i++) {
                    if ($i > 0) {
                        $eduHTML .= "<hr>";
                    }

                    $eduDate = $edus[$i]["education_start"];

                    if ($eduDate == $edus[$i]["education_end"] || $edus[$i]["education_end"] == "0000-00-00") {
                        $eduDate = $edus[$i]["education_start"] . " - " . lang("resuming");
                    } else {
                        $eduDate = $edus[$i]["education_start"] . " - " . $edus[$i]["education_end"];
                    }

                    $eduHTML .= '<blockquote class="blockquote mb-0"><h6>' . lang("education_level_" . $edus[$i]["education_type"]) . " " . $edus[$i]["education_department"] . '</h6>
                    <p>' . $edus[$i]["education_name"] . ' </p>
                <footer class="blockquote-footer">' . $eduDate . ' <cite title="Source Title">' . ($edus[$i]["education_note"] == "0" ? "" : "<b>" . $edus[$i]["education_note"] . "</b>") . '</cite></footer>
            </blockquote>';

                    if ($profile->memberId == $user->memberId) {
                        $eduHTML .= "<div class='row'><button class='btn' title='" . lang("edit_education") . "' onclick='showEducation(" . $edus[$i]["education_id"] . ")'><i class='fa fa-edit'></i></button><button class='btn' title='" . lang("delete_education") . "' onclick='openModal(\"modal-delete-edu\"); item(\"delete-edu-id\").value = " . $edus[$i]["education_id"] . "'><i class='fa fa-trash'></i></button></div>";
                    }
                }

                echo $eduHTML;
            } else {
                //todo
            }

            noEdus:
            ?>
        </div>
    </div>
    <br>

    <?php
    $certs = $profile->selectCertificate();

    if ($certs[0] == false || count($certs[1]) < 1) {
        if ($profile->memberId != $user->memberId) {
            goto noCerts;
        }
    }
    ?>

    <div class="card">
        <div class="card-header">
            <?php
            echo lang("certificates");

            if ($profile->memberId == $user->memberId) {
                echo "<button class='btn' title='" . lang("add_certificate") . "' onclick='showCertificate(0)'><i class='fa fa-plus'></i></button>";
            }
            ?>
        </div>
        <div class="card-body">
            <?php
            $certsHTML = "";

            if ($certs[0]) {
///                    $certs = json_decode($certs[1]);
                $certs = $certs[1];
                for ($i = 0; $i < count($certs); $i++) {
                    if ($i > 0) {
                        $certsHTML .= "<hr>";
                    }

                    $href = "";
                    $hrefEnd = "";

                    if ($certs[$i]["certificate_url"] != "") {
                        $href = '<a href="' . $certs[$i]["certificate_url"] . '">';
                        $hrefEnd = '</a>';
                    }


                    $certsHTML .= '<blockquote class="blockquote mb-0">' . $href . '<h6>' . $certs[$i]["certificate_name"] . '</h6>' . $hrefEnd . '
                     <p>' . $certs[$i]["certificate_desc"] . ' </p>
                <footer class="blockquote-footer">' . $certs[$i]["certificate_date"] . ' <cite title="Source Title">' . $certs[$i]["certificate_company"] . '</cite></footer>
            </blockquote>';

                    if ($profile->memberId == $user->memberId) {
                        $certsHTML .= "<div class='row'><button class='btn' title='" . lang("edit_certificate") . "' onclick='showCertificate(" . $certs[$i]["certificate_id"] . ")'><i class='fa fa-edit'></i></button><button class='btn' title='" . lang("delete_certificate") . "' onclick='openModal(\"modal-delete-certificate\"); item(\"delete-certificate-id\").value = " . $certs[$i]["certificate_id"] . "'><i class='fa fa-trash'></i></button></div>";
                    }
                }

                echo $certsHTML;
            } else {
                //todo
            }

            noCerts:
            ?>
        </div>
    </div>


    <br>

    <?php
    $refs = $profile->selectReference();

    if ($refs[0] == false || count($refs[1]) < 1) {
        if ($profile->memberId != $user->memberId) {
            goto noRefs;
        }
    }
    ?>

    <div class="card">
        <div class="card-header">
            <?php
            echo lang("references");

            if ($profile->memberId == $user->memberId) {
                echo "<button class='btn' title='" . lang("add_reference") . "' onclick='showReference(0)'><i class='fa fa-plus'></i></button>";
            }
            ?>
        </div>
        <div class="card-body">
            <?php
            $refsHTML = "";

            if ($refs[0]) {
///                    $certs = json_decode($certs[1]);
                $refs = $refs[1];
                for ($i = 0; $i < count($refs); $i++) {
                    if ($i > 0) {
                        $refsHTML .= "<hr>";
                    }
                    $refsHTML .= '<blockquote class="blockquote mb-0"><h6>' . $refs[$i]["reference_name"] . '</h6>
                     <p>' . $refs[$i]["reference_company"] . " - " . $refs[$i]["reference_title"] . ' </p>
                <footer class="blockquote-footer">' . $refs[$i]["reference_email"] . ' <cite title="Source Title">' . $refs[$i]["reference_gsm"] . '</cite></footer>
            </blockquote>';

                    if ($profile->memberId == $user->memberId) {
                        $refsHTML .= "<div class='row'><button class='btn' title='" . lang("edit_reference") . "' onclick='showReference(" . $refs[$i]["reference_id"] . ")'><i class='fa fa-edit'></i></button><button class='btn' title='" . lang("delete_reference") . "' onclick='openModal(\"modal-delete-ref\"); item(\"edit-reference-id\").value = " . $refs[$i]["reference_id"] . "'><i class='fa fa-trash'></i></button></div>";
                    }
                }

                echo $refsHTML;
            } else {
                //todo
            }

            noRefs:
            ?>
        </div>
    </div>
    <br>

    <?php
    $skills = $profile->selectSkill();

    if ($skills[0] == false || count($skills[1]) < 1) {
        if ($profile->memberId != $user->memberId) {
            goto noSkills;
        }
    }
    ?>

    <div class="card">
        <div class="card-header">
            <?php
            echo lang("skills");

            if ($profile->memberId == $user->memberId) {
                echo "<button class='btn' title='" . lang("add_skill") . "' onclick='showSkill(0)'><i class='fa fa-plus'></i></button>";
            }
            ?>
        </div>
        <div class="card-body">
            <?php
            $skillsHTML = "";

            if ($skills[0]) {
///                    $certs = json_decode($certs[1]);
                $skills = $skills[1];
                for ($i = 0; $i < count($skills); $i++) {
                    if ($i > 0) {
                        // $skillsHTML .= "<hr>";
                    }

                    $star = "";

                    for ($j = 0; $j < $skills[$i]["skill_level"]; $j++) {
                        $star .= "<span class=\"fa fa-star\">";
                    }

                    $admin = "";
                    $adminClose = "";

                    if ($profile->memberId == $user->memberId) {
                        $admin = "<a style=' cursor:pointer;' onclick='showSkill(" . $skills[$i]["skill_id"] . ");'>";
                        $adminClose = "</a>";
                    }

                    $skillsHTML .= $admin . '<span class="badge badge-pill badge-dark">' . $skills[$i]["skill_name"] . $star . '</span>' . $adminClose;

                    if ($profile->memberId == $user->memberId) {
                        //  $skillsHTML .= "<div class='row'><button class='btn' title='" . lang("edit_reference") . "' onclick='showEditSkill(" . $skills[$i]["reference_id"] . ")'><i class='fa fa-edit'></i></button><button class='btn' title='" . lang("delete_skill") . "' onclick='openModal(\"modal-delete-ref\"); item(\"delete-ref-id\").value = " . $refs[$i]["reference_id"] . "'><i class='fa fa-trash'></i></button></div>";
                    }
                }

                echo $skillsHTML;
            } else {
                //todo
            }

            noSkills:
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
                        onclick="deleteCertificate(); closeModal('modal-delete-certificate')"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-delete-certificate')"><?= message("cancel") ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-delete-edu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("delete_education") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-delete-edu')">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="alert" id="modal-delete-edu-result" style="display: none">
                </div>

                <input id="delete-edu-id" value="0" type="hidden">

                <div class="form-group">
                    <label><?= lang("are_you_sure") ?></label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="deleteEducation(); closeModal('modal-delete-edu')"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-delete-edu')"><?= message("cancel") ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-delete-ref">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("delete_reference") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-delete-ref')">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="alert" id="modal-delete-ref-result" style="display: none">
                </div>

                <input id="delete-ref-id" value="0" type="hidden">

                <div class="form-group">
                    <label><?= lang("are_you_sure") ?></label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="deleteRef(); closeModal('modal-delete-ref')"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-delete-ref')"><?= message("cancel") ?></button>
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
                        onclick="deleteExperience(); closeModal('modal-exp-job')"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-delete-exp')"><?= message("cancel") ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-edit-skill">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("edit_add_skill") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-edit-skill')">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="alert" id="modal-edit-skill-result" style="display: none">
                </div>

                <input id="edit-skill-id" value="0" type="hidden">
                <input id="edit-skill-point" value="0" type="hidden">
                <input id="edit-skill-order" value="0" type="hidden">


                <div class="form-group">
                    <div class="form-group">
                        <label for="skill_name"><?= lang("skill_name") ?></label>
                        <input type="text" class="form-control" name="skill_name" id="skill_name"
                               placeholder="<?= lang("skill") ?>" minlength="1" maxlength="32" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label for="skill_name"><?= lang("skill_level") ?></label>
                        <span id="star_1" onclick="changeStar(1)" class="fa fa-star"></span>
                        <span id="star_2" onclick="changeStar(2)" class="fa fa-star"></span>
                        <span id="star_3" onclick="changeStar(3)" class="fa fa-star"></span>
                        <span id="star_4" onclick="changeStar(4)" class="fa fa-star"></span>
                        <span id="star_5" onclick="changeStar(5)" class="fa fa-star"></span>
                    </div>
                </div>

                <button type="submit" id="delete-skill-button" class="btn btn-warning"
                        onclick="deleteSkill(); closeModal('modal-edit-skill')"><?= message("delete") ?></button>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="editSkill();"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-edit-skill')"><?= message("cancel") ?></button>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-edit-reference">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("edit_add_reference") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-edit-reference')">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="alert" id="modal-edit-reference-result" style="display: none">
                </div>

                <input id="edit-reference-id" value="0" type="hidden">
                <input id="edit-reference-order" value="0" type="hidden">

                <div class="form-group">
                    <div class="form-group">
                        <label for="reference_name"><?= lang("reference_name") ?></label>
                        <input type="text" class="form-control" name="reference_name" id="reference_name"
                               placeholder="<?= lang("reference") ?>" minlength="1" maxlength="32" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="reference_company"><?= lang("reference_company") ?></label>
                        <input type="text" class="form-control" name="reference_company" id="reference_company"
                               placeholder="<?= lang("reference_company") ?>" minlength="1" maxlength="32" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="reference_title"><?= lang("reference_title") ?></label>
                        <input type="text" class="form-control" name="reference_title" id="reference_title"
                               placeholder="<?= lang("reference_title") ?>" minlength="1" maxlength="32" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="reference_gsm"><?= lang("reference_gsm") ?></label>
                        <input type="text" class="form-control" name="reference_gsm" id="reference_gsm"
                               placeholder="<?= lang("reference_gsm") ?>" minlength="1" maxlength="32">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="reference_email"><?= lang("reference_email") ?></label>
                        <input type="email" class="form-control" name="reference_gsm" id="reference_email"
                               placeholder="<?= lang("reference_email") ?>" minlength="1" maxlength="32">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="editReference();"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-edit-reference')"><?= message("cancel") ?></button>

            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal-edit-certificate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("edit_add_certificate") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-edit-certificate')">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="alert" id="modal-edit-certificate-result" style="display: none">
                </div>

                <input id="edit-certificate-id" value="0" type="hidden">
                <input id="edit-certificate-order" value="0" type="hidden">

                <div class="form-group">
                    <div class="form-group">
                        <label for="reference_name"><?= lang("certificate_name") ?></label>
                        <input type="text" class="form-control" name="certificate_name" id="certificate_name"
                               placeholder="<?= lang("certificate") ?>" minlength="1" maxlength="128" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="certificate_company"><?= lang("certificate_company") ?></label>
                        <input type="text" class="form-control" name="certificate_company" id="certificate_company"
                               placeholder="<?= lang("certificate_company") ?>" minlength="1" maxlength="32" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="certificate_desc"><?= lang("certificate_desc") ?></label>
                        <input type="text" class="form-control" name="certificate_desc" id="certificate_desc"
                               placeholder="<?= lang("certificate_desc") ?>" minlength="0" maxlength="512">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="certificate_url"><?= lang("certificate_url") ?></label>
                        <input type="url" class="form-control" name="certificate_url" id="certificate_url"
                               placeholder="<?= lang("certificate_url") ?>" minlength="0" maxlength="512">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="certificate_date"><?= lang("certificate_date") ?></label>
                        <input type="date" class="form-control" name="certificate_date" id="certificate_date"
                               placeholder="<?= lang("certificate_date") ?>" max="2020-12-31"
                               min="1950-01-01" minlength="1" maxlength="32">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="editCertificate();"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-edit-certificate')"><?= message("cancel") ?></button>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-edit-education">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("edit_add_education") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-edit-education')">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="alert" id="modal-edit-education-result" style="display: none">
                </div>

                <input id="edit-education-id" value="0" type="hidden">
                <input id="edit-education-order" value="0" type="hidden">

                <div class="form-group">
                    <div class="form-group">
                        <label for="education_name"><?= lang("education_name") ?></label>
                        <input type="text" class="form-control" name="education_name" id="education_name"
                               placeholder="<?= lang("education") ?>" minlength="1" maxlength="128" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="education_type"><?= lang("education_type") ?></label>
                    <select class="form-control" name="education_type" id="education_type">
                        <option value="1" selected><?= lang("education_level_1") ?></option>
                        <option value="2"><?= lang("education_level_2") ?></option>
                        <option value="3"><?= lang("education_level_3") ?></option>
                        <option value="4"><?= lang("education_level_4") ?></option>
                        <option value="5"><?= lang("education_level_5") ?></option>
                        <option value="6"><?= lang("education_level_6") ?></option>

                    </select>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="education_department"><?= lang("education_department") ?></label>
                        <input type="text" class="form-control" name="education_department" id="education_department"
                               placeholder="<?= lang("education_department") ?>" minlength="1" maxlength="32" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="education_note"><?= lang("education_note") ?></label>
                        <input type="number" class="form-control" name="education_note" id="education_note"
                               placeholder="<?= lang("education_note") ?>" minlength="0" maxlength="512">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="education_start"><?= lang("education_start") ?></label>
                        <input type="date" class="form-control" name="education_start" id="education_start"
                               max="2020-12-31"
                               min="1950-01-01" minlength="1" maxlength="32">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="education_end"><?= lang("education_end") ?></label>
                        <input type="date" class="form-control" name="education_end" id="education_end"
                               max="2020-12-31"
                               min="1950-01-01" minlength="1" maxlength="32">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="editEducation();"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-edit-education')"><?= message("cancel") ?></button>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-edit-experience">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><?= lang("edit_add_experience") ?></h4>
                <button type="button" class="close text-white" data-dismiss="modal"
                        onclick="closeModal('modal-edit-experience')">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="alert" id="modal-edit-experience-result" style="display: none">
                </div>

                <input id="edit-experience-id" value="0" type="hidden">
                <input id="edit-experience-order" value="0" type="hidden">

                <div class="form-group">
                    <div class="form-group">
                        <label for="experience_name"><?= lang("experience_name") ?></label>
                        <input type="text" class="form-control" name="experience_name" id="experience_name"
                               placeholder="<?= lang("experience") ?>" minlength="1" maxlength="128" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="experience_company"><?= lang("experience_company") ?></label>
                        <input type="text" class="form-control" name="experience_company" id="experience_company"
                               placeholder="<?= lang("experience_company") ?>" minlength="1" maxlength="64" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="experience_desc"><?= lang("experience_desc") ?></label>
                        <input type="text" class="form-control" name="experience_desc" id="experience_desc"
                               placeholder="<?= lang("experience_desc") ?>" minlength="0" maxlength="512">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="experience_start"><?= lang("experience_start") ?></label>
                        <input type="date" class="form-control" name="experience_start" id="experience_start"
                               max="2020-12-31"
                               min="1950-01-01" minlength="1" maxlength="32">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label for="experience_end"><?= lang("experience_end") ?></label>
                        <input type="date" class="form-control" name="experience_end" id="experience_end"
                               max="2020-12-31"
                               min="1950-01-01" minlength="1" maxlength="32">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                        onclick="editExperience();"><?= message("confirm") ?></button>
                <button type="submit" class="btn btn-danger"
                        onclick="closeModal('modal-edit-experience')"><?= message("cancel") ?></button>

            </div>
        </div>
    </div>
</div>
<script>
    function deleteExperience() {
        var id = itemValue("delete-exp-id");

        $.post("api.php", {
            "call_category": "user_experience",
            "call_request": "delete",
            "experience_id": id
        }, function (data, result) {
            closeModal("modal-delete-exp");

            if (result == "success") {
                data = JSON.parse(data);

                if (data[0]) {
                        Message.success(data[1]);
                } else {
                    Message.error(data[1]);
                }
            }}
        );
    }


    function editExperience() {
        var id = itemValue("edit-experience-id");

        var method = "insert";

        if (id > 0) {
            method = "update";
        }

        $.post("api.php", {
            "call_category": "user_experience",
            "call_request": method,
            "experience_member": id,
            "experience_id": id,
            "experience_name": itemValue("experience_name"),
            "experience_company": itemValue("experience_company"),
            "experience_description": itemValue("experience_desc"),
            "experience_start": itemValue("experience_start"),
            "experience_end": itemValue("experience_end"),
            "experience_order": itemValue("edit-experience-order")
        }, function (data, result) {
            if (result == "success") {
                data = JSON.parse(data);

                if (data[0]) {
                    if (method == "insert") {
                        closeModal("modal-edit-experience");
                        Message.success(data[1]);
                    } else {
                        Message.modalSuccess("modal-edit-experience-result", data[1]);
                    }
                } else {
                    Message.modalError("modal-edit-experience-result", data[1]);
                }
            }
        });
    }


    function showExperience(id) {
        if (id == 0) {
            setValue("edit-experience-id", 0);
            setValue("edit-experience-order", 0);
            setValue("experience_name");
            setValue("experience_desc");
            setValue("experience_company");
            setValue("experience_start");
            setValue("experience_end");

            openModal("modal-edit-experience");
        } else {
            $.post("api.php", {
                "call_category": "user_experience",
                "call_request": "get",
                "experience_id": id
            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (data[0]) {
                        setValue("edit-experience-id", data[1][0]["experience_id"]);
                        setValue("edit-experience-order", data[1][0]["experience_order"]);
                        setValue("experience_name", data[1][0]["experience_name"]);
                        setValue("experience_desc", data[1][0]["experience_desc"]);
                        setValue("experience_company", data[1][0]["experience_company"]);
                        setValue("experience_start", data[1][0]["experience_start"]);
                        setValue("experience_end", data[1][0]["experience_end"]);

                        openModal("modal-edit-experience");
                    } else {
                        Message.error(data[1]);
                    }
                } else {
                    //todo
                }
            });
        }
    }


    function deleteEducation() {
        var id = itemValue("delete-edu-id");

        $.post("api.php", {
            "call_category": "user_education",
            "call_request": "delete",
            "education_id": id
        }, function (data, result) {
            if (result == "success") {
                data = JSON.parse(data);

                if (data[0]) {
                    Message.success(data[1]);
                } else {
                    Message.error(data[1]);
                }

                closeModal("modal-delete-edu");
            }
        });
    }

    function editEducation() {
        var id = itemValue("edit-education-id");

        if (id == 0) {
            $.post("api.php", {
                "call_category": "user_education",
                "call_request": "insert",
                "education_member": 0,
                "education_name": itemValue("education_name"),
                "education_department": itemValue("education_department"),
                "education_type": itemValue("education_type"),
                "education_start": itemValue("education_start"),
                "education_end": itemValue("education_end"),
                "education_order": 0,
                "education_note": itemValue("education_note")
            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (data[0]) {
                        Message.success(data[1]);
                        closeModal("modal-edit-education");
                    } else {
                        Message.modalError("modal-edit-education-result", data[1]);
                    }
                } else {
                    //todo
                }
            });
        } else {
            $.post("api.php", {
                "call_category": "user_education",
                "call_request": "update",
                "education_id": id,
                "education_name": itemValue("education_name"),
                "education_department": itemValue("education_department"),
                "education_type": itemValue("education_type"),
                "education_start": itemValue("education_start"),
                "education_end": itemValue("education_end"),
                "education_order": 0,
                "education_note": itemValue("education_note")
            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (data[0]) {
                        Message.modalSuccess("modal-edit-education-result", data[1]);
                    } else {
                        Message.modalError("modal-edit-education-result", data[1]);
                    }
                } else {
                    //todo
                }
            });
        }
    }


    function showEducation(id) {
        if (id == 0) {
            setValue("edit-education-id", 0);
            setValue("edit-education-order", 0);

            setValue("education_name");
            setValue("education_type", 0);
            setValue("education_department");
            setValue("education_note");
            setValue("education_start");
            setValue("education_end");

            hideErrorArea("modal-edit-education-result");
            openModal("modal-edit-education");
        } else {
            $.post("api.php", {
                "call_category": "user_education",
                "call_request": "get",
                "education_id": id,
            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (data[0]) {
                        setValue("edit-education-id", data[1][0]["education_id"]);
                        setValue("edit-education-order", data[1][0]["education_order"]);

                        setValue("education_name", data[1][0]["education_name"]);
                        setValue("education_type", data[1][0]["education_type"]);
                        setValue("education_department", data[1][0]["education_department"]);
                        setValue("education_note", data[1][0]["education_note"]);
                        setValue("education_start", data[1][0]["education_start"]);
                        setValue("education_end", data[1][0]["education_end"]);

                        hideErrorArea("modal-edit-education-result");
                        openModal("modal-edit-education");
                    } else {
                        setValue("edit-education-id", 0);
                        setValue("edit-education-order", 0);

                        setValue("education_name");
                        setValue("education_type", 0);
                        setValue("education_department");
                        setValue("education_note");
                        setValue("education_start");
                        setValue("education_end");

                        Message.error(data[1], "");
                    }
                }
            });
        }
    }

    function deleteCertificate() {
        var id = itemValue("delete-certificate-id");

        $.post("api.php", {
            "call_category": "user_certificate",
            "call_request": "delete",
            "certificate_id": id,
        }, function (data, result) {
            if (result == "success") {
                data = JSON.parse(data);

                if (data[0]) {
                    Message.success(data[1], "");
                } else {
                    Message.error(data[1], "");
                }
            } else {
                //todo
            }
        });
    }

    function editCertificate() {
        var id = item("edit-certificate-id").value;

        if (id == 0) {
            $.post("api.php", {
                    "call_category": "user_certificate",
                    "call_request": "insert",
                    "certificate_member": 0,
                    "certificate_name": item("certificate_name").value,
                    "certificate_company": item("certificate_company").value,
                    "certificate_url": item("certificate_url").value,
                    "certificate_description": item("certificate_desc").value,
                    "certificate_date": item("certificate_date").value,
                    "certificate_order": item("edit-certificate-order").value
                }, function (data, result) {
                    if (result == "success") {
                        data = JSON.parse(data);

                        if (data[0]) {
                            closeModal("modal-edit-certificate");
                            Message.success(data[1], "");
                        } else {
                            Message.modalError("modal-edit-certificate-result", data[1])
                        }
                    }
                }
            );
        } else {
            $.post("api.php", {
                    "call_category": "user_certificate",
                    "call_request": "update",
                    "certificate_id": itemValue("edit-certificate-id"),
                    "certificate_name": item("certificate_name").value,
                    "certificate_company": item("certificate_company").value,
                    "certificate_url": item("certificate_url").value,
                    "certificate_description": item("certificate_desc").value,
                    "certificate_date": item("certificate_date").value,
                    "certificate_order": item("edit-certificate-order").value
                }, function (data, result) {
                    if (result == "success") {
                        data = JSON.parse(data);

                        if (data[0]) {
                            Message.modalSuccess("modal-edit-certificate-result", data[1])
                        } else {
                            Message.modalError("modal-edit-certificate-result", data[1])
                        }
                    }
                }
            );
        }
    }

    function showCertificate(id) {
        if (id == 0) {
            item("edit-certificate-id").value = 0;
            item("edit-certificate-order").value = 0;
            item("certificate_date").value = "";
            item("certificate_url").value = "";
            item("certificate_desc").value = "";
            item("certificate_company").value = "";
            item("certificate_name").value = "";

            hideErrorArea("modal-edit-certificate-result");

            openModal("modal-edit-certificate");
        } else {
            $.post("api.php", {
                "call_category": "user_certificate",
                "call_request": "get",
                "certificate_id": id
            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (data[0]) {
                        if (data[1].length > 0) {
                            item("edit-certificate-id").value = data[1][0]["certificate_id"];
                            item("edit-certificate-order").value = data[1][0]["certificate_order"];
                            item("certificate_date").value = data[1][0]["certificate_date"];
                            item("certificate_url").value = data[1][0]["certificate_url"];
                            item("certificate_desc").value = data[1][0]["certificate_desc"];
                            item("certificate_company").value = data[1][0]["certificate_company"];
                            item("certificate_name").value = data[1][0]["certificate_name"];

                            hideErrorArea("modal-edit-certificate-result");
                        }
                    } else {
                        item("edit-certificate-id").value = 0;
                        item("edit-certificate-order").value = 0;
                        item("certificate_date").value = "";
                        item("certificate_url").value = "";
                        item("certificate_desc").value = "";
                        item("certificate_company").value = "";
                        item("certificate_name").value = "";

                        hideErrorArea("modal-edit-certificate-result");
                        closeModal("modal-edit-certificate");

                        Message.error("", data[1]);
                    }

                    openModal("modal-edit-certificate");
                }
            });
        }
    }

    function editReference() {
        var id = item("edit-reference-id").value;

        if (id == 0) {
            $.post("api.php", {
                "call_category": "user_reference",
                "call_request": "insert",
                "reference_name": item("reference_name").value,
                "reference_company": item("reference_company").value,
                "reference_gsm": item("reference_gsm").value,
                "reference_email": item("reference_email").value,
                "reference_title": item("reference_title").value,
                "reference_order": item("edit-reference-order").value,
                "reference_member": 0

            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (data[0]) {
                        closeModal("modal-edit-reference");
                        Message.success(data[1], "");
                    } else {
                        Message.modalError("modal-edit-reference-result", data[1]);
                        //item("modal-edit-reference-result").style.display = "block";
                        //item("modal-edit-reference-result").innerHTML = data[1];
                    }
                }
            });
        } else {
            $.post("api.php", {
                "call_category": "user_reference",
                "call_request": "update",
                "reference_id": item("edit-reference-id").value,
                "reference_name": item("reference_name").value,
                "reference_company": item("reference_company").value,
                "reference_gsm": item("reference_gsm").value,
                "reference_email": item("reference_email").value,
                "reference_title": item("reference_title").value,
                "reference_order": item("edit-reference-order").value,
                "reference_member": 0

            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (data) {
                        closeModal("modal-edit-reference");
                        Message.success(data[1], "");
                    } else {
                        Message.modalError("modal-edit-reference-result", data[1]);
                        //item("modal-edit-reference-result").style.display = "block";
                        //item("modal-edit-reference-result").innerHTML = data[1];
                    }
                }
            });
        }
    }

    function deleteRef() {
        closeModal("modal-edit-reference");

        var id = item("edit-reference-id").value;

        $.post("api.php", {
            "call_category": "user_reference",
            "call_request": "delete",
            "reference_id": id
        }, function (data, result) {
            data = JSON.parse(data);

            if (data[0]) {
                Message.success(data[1]);
            } else {
                Message.error(data[1]);
            }
        })
    }

    function showReference(id) {
        openModal("modal-edit-reference");

        item("edit-reference-id").value = id;

        if (id > 0) {
            $.post("api.php", {
                "call_category": "user_reference",
                "call_request": "get",
                "reference_id": id
            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (result[0]) {
                        item("edit-reference-id").value = data[1][0]["reference_id"];
                        item("reference_name").value = data[1][0]["reference_name"];
                        item("reference_company").value = data[1][0]["reference_company"];
                        item("reference_gsm").value = data[1][0]["reference_gsm"];
                        item("reference_email").value = data[1][0]["reference_email"];
                        item("reference_title").value = data[1][0]["reference_title"];
                        item("edit-reference-order").value = data[1][0]["reference_order"];

                        item("modal-edit-reference-result").innerHTML = "";
                        item("modal-edit-reference-result").style.display = "none";
                    } else {
                        item("edit-reference-id").value = 0;

                        item("edit-reference-id").value = 0;
                        item("reference_name").value = "";
                        item("reference_company").value = "";
                        item("reference_gsm").value = "";
                        item("reference_email").value = "";
                        item("reference_title").value = "";
                        item("edit-reference-order").value = 0;

                        Message.modalError("modal-edit-reference-result", data[1]);

                        //item("modal-edit-reference-result").innerHTML = data[1];
                        //item("modal-edit-reference-result").style.display = "block";

                        // Message.error("", data[1]);
                        // closeModal("modal-edit-reference")
                    }

                } else {
                    //todo
                }

            });
        } else {
            item("modal-edit-reference-result").style.display = "none";
            item("modal-edit-reference-result").innerHTML = "";

            item("edit-reference-id").value = 0;

            item("edit-reference-id").value = 0;
            item("reference_name").value = "";
            item("reference_company").value = "";
            item("reference_gsm").value = "";
            item("reference_email").value = "";
            item("reference_title").value = "";
            item("edit-reference-order").value = 0;
        }
    }

    function deleteSkill() {
        $.post("api.php", {
            "call_category": "user_skill",
            "call_request": "delete",
            "skill_id": item("edit-skill-id").value

        }, function (data, result) {
            if (result == "success") {
                data = JSON.parse(data);

                if (data) {
                    closeModal("modal-edit-skill");
                    Message.success(data[1], "");
                } else {
                    Message.modalError("modal-edit-skill-result", data[1]);
                    // item("modal-edit-skill-result").style.display = "block";
                    //item("modal-edit-skill-result").innerHTML = data[1];
                }
            }
        });
    }

    function editSkill() {
        id = item("edit-skill-id").value;

        if (id > 0) {
            $.post("api.php", {
                "call_category": "user_skill",
                "call_request": "update",
                "skill_id": item("edit-skill-id").value,
                "skill_name": item("skill_name").value,
                "skill_level": item("edit-skill-point").value,
                "skill_order": item("edit-skill-order").value,
                "skill_member": 0

            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (data) {
                        closeModal("modal-edit-skill");
                        Message.success(data[1], "");
                    } else {
                        Message.modalError("modal-edit-skill-result", data[1]);
                        //item("modal-edit-skill-result").style.display = "block";
                        //item("modal-edit-skill-result").innerHTML = data[1];
                    }
                }
            });
        } else {
            $.post("api.php", {
                "call_category": "user_skill",
                "call_request": "insert",
                "skill_name": item("skill_name").value,
                "skill_level": item("edit-skill-point").value,
                "skill_order": item("edit-skill-order").value,
                "skill_member": 0
            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (data[0]) {
                        closeModal("modal-edit-skill");
                        Message.success(data[1], "");
                    } else {
                        Message.modalError("modal-edit-skill-result", data[1]);
                        // item("modal-edit-skill-result").style.display = "block";
                        //item("modal-edit-skill-result").innerHTML = data[1];
                    }
                }
            });
        }
    }

    function showSkill(id) {
        openModal("modal-edit-skill");

        if (id > 0) {
            $.post("api.php", {
                "call_category": "user_skill",
                "call_request": "get",
                "skill_id": id
            }, function (data, result) {
                if (result == "success") {
                    data = JSON.parse(data);

                    if (result[0]) {
                        item("skill_name").value = data[1][0]["skill_name"];
                        item("edit-skill-id").value = id;
                        item("edit-skill-point").value = data[1][0]["skill_level"];
                        item("modal-edit-skill-result").innerHTML = "";
                        item("modal-edit-skill-result").style.display = "none";

                        changeStar(data[1][0]["skill_level"]);
                        item("delete-skill-button").style.display = "block";
                    } else {
                        item("delete-skill-button").style.display = "none";

                        Message.modalError("modal-edit-skill-result", data[1]);
                        //item("modal-edit-skill-result").style.display = "block";
                        //item("modal-edit-skill-result").innerHTML = data[1];

                        item("skill_name").value = "";
                        item("edit-skill-id").value = 0;
                        item("edit-skill-point").value = 0;

                        changeStar(0);
                    }

                } else {
                    //todo
                }

            });
        } else {
            item("delete-skill-button").style.display = "none";

            item("modal-edit-skill-result").style.display = "none";
            item("modal-edit-skill-result").innerHTML = "";

            item("skill_name").value = "";
            item("edit-skill-id").value = 0;
            item("edit-skill-point").value = 0;

            changeStar(0);
        }
    }

    function changeStar(level) {
        for (var i = 0; i <= 5; i++) {
            $("#star_" + i).removeClass("text-success");
        }

        for (var i = 0; i <= level; i++) {
            $("#star_" + i).addClass("text-success");
        }

        item("edit-skill-point").value = level;
    }
</script>