$(document).ready(function () {
    var wsUri = "ws://127.0.0.1:9001/bin/chat_daemon.php";
    var websocket = new WebSocket(wsUri, "chat");

    $("#send_btn")[0].addEventListener("click", function () {
        sendMessage();
    });

    websocket.onopen = function () {
        console.log("Message open.");
        $("#message-box").append(
            '<div class="system_msg">Verbindung hergestellt.</div>'
        );
    };

    websocket.onmessage = function (ev) {
        var response = JSON.parse(ev.data); //PHP sends Json data

        var res_type = response.type; //message type
        var message = response.message; //message text
        var user_name = response.name; //user name
        var user_color = response.color; //color

        switch (res_type) {
            case "usermsg":
                $("#message-box").append(
                    '<div class="msg m1"><span class="user_name" style="color:' +
                        user_color +
                        '">' +
                        user_name +
                        '</span> : <span class="user_message">' +
                        message +
                        "</span></div>"
                );
                break;
            case "system":
                $("#message-box").append(
                    '<div style="msg system_msg">' + message + "</div>"
                );
                break;
        }
        $("#message-box")[0].scrollTop = $("#message-box")[0].scrollHeight; //scroll message
    };

    websocket.onerror = function (ev) {
        $("#message-box").append(
            '<div class="system_error">Error Occurred - ' + ev.data + "</div>"
        );
    };

    websocket.onclose = function () {
        $("#message-box").append(
            '<div class="msg system_msg">Verbindung geschlossen.</div>'
        );
    };
});

function sendMessage() {
    var message_input = $("#message"); //user message text
    var name_input = $("#name"); //user name

    if (message_input.val() == "") {
        //empty name?
        alert("Enter your name please!");
        return;
    }
    if (message_input.val() == "") {
        //emtpy message?
        alert("Enter some message please!");
        return;
    }

    //prepare json data
    var msg = {
        message: message_input.val(),
        name: name_input.val(),
    };
    //convert and send data to server
    websocket.send(JSON.stringify(msg));
    message_input.val(""); //reset message input
}
