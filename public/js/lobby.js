var wsUri = "ws://127.0.0.1:9002/bin/lobby_daemon.php";
var websocket = new WebSocket(wsUri, "lobby");

$(document).ready(() => {
    websocket.addEventListener("open", () => {
        console.log("Verbinfung zur lobby hergestellt.");
    });

    websocket.addEventListener("message", (ev) => {
        var response = JSON.parse(ev.data);

        console.log(response);
        switch (response.type) {
            case "add":
                updateLobby(response.games);
                break;

            default:
                break;
        }
    });
});

function updateLobby(games) {
    var container = $("#lobby_container");
    $.each(games, function (index, value) {
        let lobbyCard = `${index} ${value.name}`;
        container.append(lobbyCard);
    });
}
