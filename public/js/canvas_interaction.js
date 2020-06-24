// saves the last Selected Chesspiece-coordinates
var CURRENTLY_SELECTED_FIELD = [];

// Handles highlighting and moving of Chesspieces
function clickEvaluation(event, boardstate, playerColor) {
    // killswitch for Cheating in enemies Turn
    if (MY_TURN === false) {
        return;
    }

    var canvas = $("#chess")[0];
    // saves the ImgData before any clickEvaluation or chesspiecemoves Appear
    if (IMGDATA_BEFORE_HIGHLIGHTING === false) {
        var ctx = canvas.getContext("2d");
        var height = canvas.height;
        var width = canvas.width;
        IMGDATA_BEFORE_HIGHLIGHTING = ctx.getImageData(0, 0, width, height);
    }

    // mouse Coordinates
    var boundRect = canvas.getBoundingClientRect();
    var mouseCoordX = event.clientX - boundRect.left;
    var mouseCoordY = event.clientY - boundRect.top;

    // converts mouse Coordinates into boardstate-coordinates
    var coordX = Math.floor(mouseCoordX / (canvas.width / 8));
    var coordY = Math.floor(mouseCoordY / (canvas.height / 8));

    //check if chesspiece is clicked
    if (boardstate[coordY][coordX] != "") {
        //check if another chesspiece is currently Selected
        if (CURRENTLY_SELECTED_FIELD.length != 0) {
            //check if Chesspiece is clicked twice
            if (
                boardstate[coordY][coordX] ==
                boardstate[CURRENTLY_SELECTED_FIELD[0]][
                    CURRENTLY_SELECTED_FIELD[1]
                ]
            ) {
                resetHighlighting();
                CURRENTLY_SELECTED_FIELD = [];
                return;
            } else if (
                boardstate[coordY][coordX].color !=
                boardstate[CURRENTLY_SELECTED_FIELD[0]][
                    CURRENTLY_SELECTED_FIELD[1]
                ].color
            ) {
                var moves =
                    boardstate[CURRENTLY_SELECTED_FIELD[0]][
                        CURRENTLY_SELECTED_FIELD[1]
                    ].moves;
                // actually moving the Chespiece and sending the message to the other Player
                if (
                    moves.find(
                        (element) =>
                            element[0] === coordY && element[1] === coordX
                    ) != undefined
                ) {
                    //move
                    moveChesspiece(
                        boardstate,
                        coordY,
                        coordX,
                        CURRENTLY_SELECTED_FIELD[0],
                        CURRENTLY_SELECTED_FIELD[1]
                    );
                    //check Checkmate
                    amICheckmate(boardstate, playerColor);
                    //send msg
                    sendMessage(
                        coordY,
                        coordX,
                        CURRENTLY_SELECTED_FIELD[0],
                        CURRENTLY_SELECTED_FIELD[1],
                        ENEMY_IN_CHECK
                    );
                    //unselect Field
                    CURRENTLY_SELECTED_FIELD = [];
                    return;
                }
            }
        }
        resetHighlighting();
        highlightChesspiece(boardstate[coordY][coordX]);
        CURRENTLY_SELECTED_FIELD = [coordY, coordX];
    } else if (CURRENTLY_SELECTED_FIELD.length != 0) {
        var moves =
            boardstate[CURRENTLY_SELECTED_FIELD[0]][CURRENTLY_SELECTED_FIELD[1]]
                .moves;
        // actually moving the Chespiece and sending the message to the other Player
        if (
            moves.find(
                (element) => element[0] === coordY && element[1] === coordX
            ) != undefined
        ) {
            //move
            moveChesspiece(
                boardstate,
                coordY,
                coordX,
                CURRENTLY_SELECTED_FIELD[0],
                CURRENTLY_SELECTED_FIELD[1]
            );
            //check Checkmate
            amICheckmate(boardstate, playerColor);
            //send msg
            sendMessage(
                coordY,
                coordX,
                CURRENTLY_SELECTED_FIELD[0],
                CURRENTLY_SELECTED_FIELD[1],
                ENEMY_IN_CHECK
            );
            //unselect Field
            CURRENTLY_SELECTED_FIELD = [];
        } else {
            resetHighlighting();
        }
    }
}
// Highlights the chosen Chesspiece
function highlightChesspiece(chesspiece) {
    var canvas = $("#chess")[0];
    var ctx = canvas.getContext("2d");

    for (var element of chesspiece.moves) {
        ctx.beginPath();
        ctx.lineWidth = "4";
        ctx.strokeStyle = "green";
        ctx.rect(
            (element[1] * canvas.height) / 8 + 2,
            (element[0] * canvas.width) / 8 + 2,
            canvas.width / 8 - 4,
            canvas.height / 8 - 4
        );
        ctx.stroke();
    }
}
// Resets all Highlighting
function resetHighlighting() {
    if (IMGDATA_BEFORE_HIGHLIGHTING !== false) {
        var canvas = $("#chess")[0];
        var ctx = canvas.getContext("2d");
        ctx.putImageData(IMGDATA_BEFORE_HIGHLIGHTING, 0, 0);
    }
}
// Moves a Chesspiece from before to After
function moveChesspiece(boardstate, yAfter, xAfter, yBefore, xBefore) {
    //initialize some variables for later usage
    var canvas = $("#chess")[0];

    //resets Highlightings
    resetHighlighting();

    //moves Chesspiece
    boardstate[yAfter][xAfter] = boardstate[yBefore][xBefore];
    boardstate[yAfter][xAfter].row = yAfter;
    boardstate[yAfter][xAfter].column = xAfter;
    boardstate[yBefore][xBefore] = "";

    //check for Pawn,rook or King
    switch (boardstate[yAfter][xAfter].name) {
        case "whitePawn":
        case "whiteRook":
        case "whiteKing":
        case "blackPawn":
        case "blackRook":
        case "blackKing":
            boardstate[yAfter][xAfter].hasMoved = true;
    }

    //Resets Fields on Board and draws Chesspiece at right place
    drawField(yBefore, xBefore);
    drawField(yAfter, xAfter);
    drawPiece(
        boardstate[yAfter][xAfter],
        (xAfter * canvas.height) / 8,
        (yAfter * canvas.width) / 8
    );

    //updates Chesspiece move array
    resetMovesOfChesspieces(boardstate);
    setMovesOfChesspieces(boardstate);

    //save new ImageData
    IMGDATA_BEFORE_HIGHLIGHTING = false;

    //end Turn
    MY_TURN = false;
}
//sends moveMessage after player has done his Turn
function sendMessage(yAfter, xAfter, yBefore, xBefore, enemyInCheck) {
    var moveMessage = {
        type: "chesspieceMove",
        yBefore: yBefore,
        xBefore: xBefore,
        yAfter: yAfter,
        xAfter: xAfter,
        enemyInCheck: enemyInCheck,
    };
    gameWS.send(JSON.stringify(moveMessage));
}
// CHeck if a player is Checkmate after he done his Turn.
function amICheckmate(boardstate, playerColor) {
    for (var i = 0; i < 8; i++) {
        for (var j = 0; j < 8; j++) {
            //Check if its a Chesspiece
            if (boardstate[i][j] != "") {
                //Check if Chesspiece is the same Color as the Player
                if (boardstate[i][j].color == playerColor) {
                    //Check if the Chesspiece is any kind of King
                    if (
                        boardstate[i][j].name == "whiteKing" ||
                        boardstate[i][j].name == "blackKing"
                    ) {
                        //Check if King is in Check after own Turn
                        //TODO: end Game.
                        if (boardstate[i][j].inCheck == true) {
                            console.log(`You Lost the Game: ${playerColor}`);
                            gameWS.send(
                                JSON.stringify({
                                    type: "gameOver",
                                    loser: playerColor,
                                    winner:
                                        playerColor === "white"
                                            ? "black"
                                            : "white",
                                })
                            );
                        }
                    }
                }
            }
        }
    }
}
