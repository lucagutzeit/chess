$(document).ready(function () {
    var wsUri = "ws://localhost:9000/chat/";
    var websocket = new WebSocket(wsUri);
    $("#send_btn")[0].addEventListener("click", function () {});

    websocket.onopen = function () {
        $("#message-box").append(
            '<div class="msg system_msg">Verbindung hergestellt. /n ES LEBT!!!!</div>'
        );
    };

    websocket.onmessage = function () {};

    websocket.onerror = function () {};

    websocket.onclose = function () {};
});
