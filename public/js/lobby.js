var lobbyWs = new WebSocket("ws://127.0.0.1:8080/lobby", "lobby");
var chatWs = new WebSocket("ws://127.0.0.1:9001/chat", "chat");

$(document).ready(function () {
    $("#send_btn")[0].addEventListener("click", function () {
        sendChatMessage();
    });

    lobbyWs.onopen = () => {
        console.log("Verbindung zur lobby hergestellt.");
    };

    lobbyWs.onmessage = (ev) => {
        var response = JSON.parse(ev.data);

        switch (response.type) {
            case "update":
                updateLobby(response.add, response.remove);
                break;

            default:
                break;
        }
    };

    chatWs.onopen = function () {
        console.log("Message open.");
        $("#message-box").append(
            '<div class="system_msg">Verbindung hergestellt.</div>'
        );
    };

    chatWs.onmessage = function (ev) {
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

    chatWs.onerror = function (ev) {
        $("#message-box").append(
            '<div class="system_error">Error Occurred - ' + ev.data + "</div>"
        );
    };

    chatWs.onclose = function () {
        $("#message-box").append(
            '<div class="msg system_msg">Verbindung geschlossen.</div>'
        );
    };
});

function sendChatMessage() {
    var messageInput = $("#message"); //user message text
    var name = document.getElementById("name").innerHTML;

    if (messageInput.val() == "") {
        //emtpy message?
        alert("Enter some message please!");
        return;
    }

    //prepare json data
    var msg = {
        message: messageInput.val(),
        name: name,
    };

    //convert to JSON and send data to server
    chatWs.send(JSON.stringify(msg));
    messageInput.val(""); //reset message input
}

function updateLobby(gamesAdded, gamesRemoved) {
    $.each(gamesAdded, function (index, value) {
        addGame(value);
    });
    $.each(gamesRemoved, function (index, value) {
        removeGame(value);
    });
}

function addGame({ id, name }) {
    var container = $("#lobby_container");

    var gameCard = `<div class="Karte">
        <div class="card" id="card${id}" style="width: 18rem;">
            <img src="../public/img/Schachbrett.jpeg" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"> ${name} </h5>
                <button id="button${id}" class="btn btn-outline-success">Beitreten</button>
            </div>
        </div>
    </div>`;

    container.append(gameCard);

    var selector = `#button${id}`;
    $(selector).click(() => {
        $.post("lobby/joinGame.php", { id: id }, (url) => {
            location.href = url;
        });
    });
}

function removeGame({ id }) {
    var gameCard = $(`#card${id}`);
    /* gameCard.parentNode.removeChild(gameCard); */
}
