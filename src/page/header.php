<http>
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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
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
        <a class="navbar-brand" href="#"><?= lang("site_title") ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=is-ilanlari"><?= lang("page_find_job") ?></a>
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
                            <a class="dropdown-item" href="#"><?= lang("my_profile") ?></a>
                            <a class="dropdown-item" href="company.php"><?= lang("company_profile") ?></a>
                            <a class="dropdown-item" href="#"><?= lang("settings") ?></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" onclick="logout()" href="#"><?= lang("exit") ?></a>
                        </div>
                    </li>
                    <?php
                } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="openModal('modal-login')"><?= lang("login") ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="openModal('modal-register')"><?= lang("register") ?></a>
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

    <!-- The Modal -->
    <div class="modal" id="modal-register">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title"><?= lang("register") ?></h4>
                    <button type="button" class="close text-white" data-dismiss="modal"
                            onclick="closeModal('modal-register')">&times;
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="messagePanel">
                    <form id="modal-register-form" action="#" onsubmit="return false">
                        <input type="hidden" name="call_category" value="user">
                        <input type="hidden" name="call_request" value="register">
                        <!-- alert-danger, alert-success, alert-primary -->
                        <div class="alert" id="modal-register-result" style="display: none">
                        </div>
                        <div class="form-group">
                            <label for="user_name"><?= lang("user_type") ?></label>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="user_type0" name="user_type"
                                       value="0">
                                <label class="custom-control-label" for="user_type0"><?= lang("user") ?></label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="user_type1" name="user_type"
                                       value="1">
                                <label class="custom-control-label" for="user_type1"><?= lang("company") ?></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_name"><?= lang("name") ?></label>
                            <input type="text" class="form-control" name="user_name" minlength="3" maxlength="32"
                                   placeholder="Muhammed" required>
                        </div>
                        <div class="form-group">
                            <label for="user_surname"><?= lang("surname") ?></label>
                            <input type="text" class="form-control" name="user_surname" placeholder="Kalender"
                                   minlength="3" maxlength="32" required>
                        </div>
                        <div class="form-group">
                            <label for="user_email"><?= lang("email") ?></label>
                            <input type="email" class="form-control" name="user_email" placeholder="example@mail.com"
                                   minlength="3" maxlength="64" required>
                        </div>
                        <div class="form-group">
                            <label for="user_password"><?= lang("password") ?></label>
                            <input type="password" id="password" class="form-control" name="user_password"
                                   placeholder="<?= lang("password") ?>" minlength="6" maxlength="32" required>
                        </div>
                        <div class="form-group">
                            <label for="registerPasswordRepeat"><?= lang("password_repeat") ?></label>
                            <input type="password" id="password_repeat" class="form-control"
                                   name="registerPasswordRepeat" placeholder="<?= lang("password_repeat") ?>"
                                   minlength="6" maxlength="32" required>
                        </div>
                        <button type="submit" class="btn btn-primary"
                                onclick="register()"><?= lang("register") ?></button>
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
                    </form>
                </div>
            </div>
        </div>
    </div>

