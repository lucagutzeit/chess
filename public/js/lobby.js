var wsUri = "ws://127.0.0.1:9002/bin/lobby_daemon.php";
var websocket = new WebSocket(wsUri, "lobby");

$(document).ready(() => {
    websocket.onopen = function () {};

    websocket.addEventListener("message", (ev) => {
        var response = JSON.parse(ev.data);

        console.log(response);
        switch (response.type) {
            case "update":
                updateLobby(response.games);
                break;

            default:
                break;
        }
    });
});

function updateLobby(games) {
    var container = $("#lobby_container");
    $.each(games, function () {
        container.append("<div>Lobby</div>");
    });
}
