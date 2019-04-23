/*
 * Copyright (c) 2019
 * Project : Kariyer
 * Owner : Muhammed Kalender
 * Contact : muhammedkalender@protonmail.com
 * Date : 21-04-2019
 * Time : 00:05
 */

function item(id) {
    return document.getElementById(id);
}

class Message {
    static error(message, title = "") {
        if (title == "") {
            title = failedMessage;
        }

        $("#messageHeader").parent().addClass("bg-danger text-white").html(title);
        $("#messageHeaderButton").addClass("text-white");
        $("#messageButton").addClass("bg-danger text-white");
        $("#messagePanel").html(message);
        $("#messageDialog").show();
    }

    static success(message, title = "") {
        if (title == "") {
            title = successMessage;
        }

        $("#messageHeader").parent().addClass("bg-success text-white").html(title);
        $("#messageHeaderButton").addClass("text-white");
        $("#messageButton").addClass("bg-success text-white");
        $("#messagePanel").html(message);
        $("#messageDialog").show();
    }

    static modalError(object, message) {
        this.modalNone(object);

        $("#" + object).addClass("alert-danger")
            .html(message)
            .css("display", "block");
    }

    static modalSuccess(object, message) {
        this.modalNone(object);

        $("#" + object).addClass("alert-success")
            .html(message)
            .css("display", "block");
    }

    static modalNone(object) {
        $("#" + object)
            .removeClass("alert-danger")
            .removeClass("alert-success")
            .removeClass("alert-primary")
            .css("display", "none");
    }
}

//https://stackoverflow.com/a/951057
function sleep(time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}

function href(URL, WAIT = 0) {
    sleep(WAIT).then(() => {
        window.location.href = URL;
    });
}

class ValidObject {
    static TYPE_STRING = 1;
    static TYPE_INT = 2;
    static TYPE_FLOAT = 3;
    static TYPE_EMAIL = 4;

    constructor(ELEMENT, NAME, MIN, MAX, TYPE) {
        this.element = ELEMENT;
        this.name = NAME;
        this.min = MIN;
        this.max = MAX;
        this.type = TYPE;
    }

    static check(OBJS) {
        for (var i = 0; i < OBJS.count(); i++) {
            var obj = OBJS[i];

            var value = item(obj.name).value;

            if (obj.min > 0 && value.length < min) {
                return [false, "todo"];
            }
        }
    }
}

function logout() {
    $.post("api.php",
        {
            'call_category': "user",
            'call_request': "logout"

        },
        function (data, status) {
            if (status == "success") {
                var result = JSON.parse(data);

                if (result[0]) {
                    Message.success(result[1])
                    href("/", 3000)
                } else {
                    Message.error(result[1])
                }
            }
        });
}


function openModal(NAME) {
    $('#' + NAME).show();
    Message.modalNone(NAME + "-result");
}

function closeModal(NAME) {
    $('#' + NAME).hide();
}

function postForm(NAME, HREF = "", WAIT =0) {
    if ($("#modal-" + NAME + "-form")[0].checkValidity() === false) {
        return;
    }

    $.post("api.php",
        $("#modal-" + NAME + "-form").serializeArray(),
        function (data, status) {
            if (status === "success") {
                var result = JSON.parse(data);

                if (result[0]) {
                    Message.modalSuccess("modal-"+NAME+"-result", result[1]);

                    if(HREF !== ""){
                        href(HREF, WAIT)
                    }
                } else {
                    Message.modalError("modal-"+NAME+"register-result", result[1]);
                }
            }
        }
    );
}

function register() {
    if ($("#modal-register-form")[0].checkValidity() === false) {
        return;
    }

    if ($("#password").val() !== $("#password_repeat").val()) {
        Message.modalError("modal-register-result", "Passwords Don't Match");
        return;
    }

    postForm('register', '/', 5000);

//     $.post("api.php",
//         $('#modal-register-form').serializeArray(),
//         function (data, status) {
//             if (status == "success") {
//                 var result = JSON.parse(data);
// //console.log(result);
//                 if (result[0]) {
//                     Message.modalSuccess("modal-register-result", result[1]);
//                     href("/", "5000")
//                 } else {
//                     Message.modalError("modal-register-result", result[1]);
//                 }
//             }
//         }
//     );
}