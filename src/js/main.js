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

function itemValue(id) {
    return document.getElementById(id).value;
}

function setValue(id, val = ""){
    document.getElementById(id).value = val;
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

function reload(WAIT) {
    sleep(WAIT).then(() => {
        window.location.reload();
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

function postForm(NAME, HREF = "", WAIT = 0, BUTTON) {
    // if ($("#modal-" + NAME + "-form")[0].checkValidity() === false) {
    //     return;
    // }  todo

    if (BUTTON != null) {
        BUTTON.disabled = true;
    }

    $.post("api.php",
        $("#modal-" + NAME + "-form").serializeArray(),
        function (data, status) {
        console.log(data);
            if (status === "success") {
                var result = JSON.parse(data);

                if (result[0]) {
                    Message.modalSuccess("modal-" + NAME + "-result", result[1]);

                    if (HREF !== "") {
                        if (HREF == "") {
                            location.reload();
                        } else {
                            href(HREF, WAIT)
                        }
                    }
                } else {
                    Message.modalError("modal-" + NAME + "-result", result[1]);
                }
            }

            if (BUTTON != null) {
                BUTTON.disabled = false;
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

function getLocation(id, level, obj) {
    getLocation(id, level, obj, null);
}

function getLocation(id, level, obj, callback) {
    var file = "";

    if (level == 0) {
        file = "/const/country.json";
    } else if (level == 1) {
        if (obj != "" && id == 0) {
            $("#" + obj).html('<option value = "0">' + langDefault + '</option>');
            $("#content-distinct").html("");
            return;
        }

        file = "/const/il_" + id + ".json";
    } else if (level == 2) {
        file = "/const/ilce_" + id + ".json";
    } else {
        return;
    }

    $.getJSON(file, function (result) {
        var options = '<option value = "0">' + langDefault + '</option>';

        if (obj != "" && ((id == 0 && level == 0) || id != 0 && level != 0)) {
            for (var i = 0; i < result.length; i++) {
                options += '<option value = "' + result[i]["location_id"] + '">' + result[i]["location_name"] + '</option>';
            }
        }


        $("#" + obj).html(options);

        if (callback != null) {
            callback();
        }
    });
}

function getDistrict(id) {
    getDistrict(id, null);
}

function getDistrict(id, callback) {
    if (id == 0) {
        $("#content-distinct").html("");
        return;
    }

    var file = "/const/ilce_" + id + ".json";

    $.getJSON(file, function (result) {
        var options = "";


        for (var i = 0; i < result.length; i++) {
            options += '<div class="custom-control custom-checkbox custom-control-inline"><input type="checkbox" class="custom-control-input" id="district' + i + '" name="district[]"';
            options += 'value="' + result[i]["location_id"] + '"><label class="custom-control-label" for="district' + i + '">' + result[i]["location_name"] + '</label></div>';
        }


        $("#content-distinct").html(options);

        if (callback != null) {
            callback();
        }
    });
}

function loadSelect(URL, TAG, OBJECT, DB) {
    var file = "/const/" + URL + ".json";

    $.getJSON(file, function (result) {
        var options = '<option value = "0">' + langDefault + '</option>';


        for (var i = 0; i < result.length; i++) {
            options += '<option value = "' + result[i][DB + "_id"] + '">' + result[i][DB + "_name_" + CURRENT_LANG] + '</option>';
        }

        $("#" + OBJECT).html(options);
    });
}

function loadCheck(URL, TAG, OBJECT, DB) {
    loadCheck(URL, TAG, OBJECT, DB, null);
}

function loadCheck(URL, TAG, OBJECT, DB, callback) {
    if(URL == "category_0"){
        $("#" + OBJECT).html("");
        return;
    }

    var file = "/const/" + URL + ".json";

    $.getJSON(file, function (result) {
        var options = '';

        for (var i = 0; i < result.length; i++) {
            options += '<div class="form-check custom-control-inline"><input class="form-check-input" type="radio" id="' + TAG + i + '" name="' + TAG + '"';
            options += 'value="' + result[i][DB + "_id"] + '"><label class="form-check-label" for="' + TAG + i + '">' + result[i][DB + "_name_" + CURRENT_LANG] + '</label></div>';
        }

        $("#" + OBJECT).html(options);

        if (callback != null) {
            callback();
        }
    });
}


function hideErrorArea(id) {
    item(id).style.display = "none";
    item(id).innerHTML = "";
}

function showErrorArea(id, msg) {
    item(id).style.display = "block";
    item(id).innerHTML = msg;
}

//https://stackoverflow.com/a/1395954
function decodeEntities(encodedString) {
    var div = document.createElement('div');
    div.innerHTML = encodedString;
    return div.textContent;
}