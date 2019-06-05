<?php
/**
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 16-05-2019
 * Time : 17:31
 */

if (!isset($isAllowRequest)) {
    die();
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
                integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
                crossorigin="anonymous"></script>
        <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <link  rel="stylesheet" type="text/css" href="../css/theme.css">
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
     <script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
              integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
              crossorigin="anonymous">

        <link rel="stylesheet" href="../css/theme.css">
        <script src="../js/main.js"></script>
        <script>
            const successMessage = "<?=lang('header_success')?>";
            const failedMessage = "<?=lang('header_failed')?>";
            const langDefault = "<?=lang('default_select')?>";
            const CURRENT_LANG = "<?=$currentLang?>";
        </script>
    </head>
    <title><?= lang("site_title") . " - " . $title ?></title>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold" href="index.php"><?= lang("site_title") ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="index.php"><?=lang("cat_home")?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="index.php?page=is-ilanlari"><?= lang("page_find_job") ?></a>
                </li>


            </ul>
            <ul class="navbar-nav">
                <?php if ($user->isLogged) {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $user->name . " " . $user->surname ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="index.php?page=<?=$user->type == 0?"profile&user":"firma&company"?>=<?=$user->memberId?>"><?= lang("my_profile") ?></a>

                            <?php

                            if($user->type == 1 ||$user->power >= Perm::SUPPORT){
                                echo '<a class="dropdown-item" href="company.php">'.lang("company_profile").'</a>';
                            }

                            if($user->power >= Perm::SUPPORT){
                                echo '<a class="dropdown-item" href="admin.php">' .lang("admin_panel").'</a>';
                            }
                            ?>

                            <!--<a class="dropdown-item" href="#"><?= lang("settings") ?></a>-->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" onclick="logout()" href="#"><?= lang("exit") ?></a>
                        </div>
                    </li>
                    <?php
                } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="openModal('modal-login')"><?= lang("login") ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <!-- The Modal -->
    <div class="modal" id="messageDialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="messageHeader">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal" id="messageHeaderButton">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="messagePanel">
                    Modal body..
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="messageButton"
                            onclick="$('#messageDialog').hide()"><?= lang("close") ?></button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="modal-forgot">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title"><?= lang("forgot_password") ?></h4>
                    <button type="button" class="close text-white" data-dismiss="modal"
                            onclick="closeModal('modal-forgot')">&times;
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="modal-forgot-form" onsubmit="return false">
                        <input type="hidden" name="call_category" value="user">
                        <input type="hidden" name="call_request" value="forgot_password">
                        <!-- alert-danger, alert-success, alert-primary -->
                        <div class="alert" id="modal-forgot-result" style="display: none">
                        </div>

                        <div class="form-group">
                            <label for="user_email"><?= lang("email") ?></label>
                            <input type="email" class="form-control" name="user_email" placeholder="example@mail.com"
                                   minlength="3" maxlength="64" required>
                        </div>

                        <button type="submit" class="btn btn-primary"
                                onclick="postForm('forgot', '/', 5000, this)"><?= lang("send_forgot") ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-login">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title"><?= lang("login") ?></h4>
                    <button type="button" class="close text-white" data-dismiss="modal"
                            onclick="closeModal('modal-login')">&times;
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="modal-login-form" onsubmit="return false">
                        <input type="hidden" name="call_category" value="user">
                        <input type="hidden" name="call_request" value="login">
                        <!-- alert-danger, alert-success, alert-primary -->
                        <div class="alert" id="modal-login-result" style="display: none">
                        </div>

                        <div class="form-group">
                            <label for="user_email"><?= lang("email") ?></label>
                            <input type="email" class="form-control" name="user_email" placeholder="example@mail.com"
                                   minlength="3" maxlength="64" required>
                        </div>
                        <div class="form-group">
                            <label for="user_password"><?= lang("password") ?></label>
                            <input type="password" class="form-control" name="user_password"
                                   placeholder="<?= lang("password") ?>" minlength="6" maxlength="32" required>
                        </div>
                        <button type="submit" class="btn btn-primary"
                                onclick="postForm('login', '/', 5000)"><?= lang("login") ?></button>

                        <br>
                        <small onclick="closeModal('modal-login'); openModal('modal-forgot')"><?=lang("i_forgot")?></small>
                    </form>
                </div>
            </div>
        </div>
    </div>

