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
    static error(message, title ="") {
        if(title == ""){
            title = failedMessage;
        }

        $("#messageHeader").parent().addClass("bg-danger text-white").html(title);
        $("#messageHeaderButton").addClass("text-white");
        $("#messageButton").addClass("bg-danger text-white");
        $("#messagePanel").html(message);
        $("#messageDialog").show();
    }

    static success(message, title = "") {
        if(title == ""){
            title = successMessage;
        }

        $("#messageHeader").parent().addClass("bg-success text-white").html(title);
        $("#messageHeaderButton").addClass("text-white");
        $("#messageButton").addClass("bg-success text-white");
        $("#messagePanel").html(message);
        $("#messageDialog").show();
    }
}

//https://stackoverflow.com/a/951057
function sleep (time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}

function href(URL, WAIT = 0) {
    sleep(WAIT).then(() => {
        window.location.href = URL;
    });
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