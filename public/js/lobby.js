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
    $.each(games, function (index, value) {
        addGame(value);
    });
}

function addGame({ id, name }) {
    let container = $("#lobby_container");

    let gameCard = `<div class="Karte">
        <div class="card" id="${id}" style="width: 18rem;">
            <img src="../../public/img/Schachbrett.jpeg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"> ${name} </h5>
                <a href="#" class="btn btn-outline-success">Beitreten</a>
            </div>
        </div>
    </div>`;

    container.append(gameCard);
}
