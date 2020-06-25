//TODO: attribut des Typs Skin einfügen und Skin klasse schreiben welche die src als attribut speichert
var FIELD_COLOR_BLACK = "#785027";
var FIELD_COLOR_WHITE = "#FFFFFF";
var NUMBER_OF_ROWS = 8;
var NUMBER_OF_COLUMNS = 8;
var PLAYER_COLOR = false;
var MY_TURN = false;
var IM_CHECKMATE = false;
var TURN_COUNT = null;
var ONLY_ONCE_HELP = false;

// saves the ImageData for resetting clickEvaluation
var IMGDATA_BEFORE_HIGHLIGHTING = false;

//websockets
var wsUri = "ws://127.0.0.1:9090/game";
var gameWS = new WebSocket(wsUri, "game");

class Board {
    // Constructor
    constructor() {
        this.numberOfRows = 8;
        this.numberOfColumns = 8;

        // two dimensional Array as a coordinate System to work with.
        // for basic functionalities nesseccary
        // boardstate[x][y] = boardstate{zeilen][spalten]
        this.boardstate = [
            ["", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
            ["", "", "", "", "", "", "", ""],
        ];
    }

    // Methods

    /**
     * Draws the chess board, by calculating the size of one field depending on the
     * height of the canvas.
     */
    drawBoard() {
        var i = 0,
            j = 0,
            canvas = $("#chess")[0];

        // Check if canvas exists and is supported.
        if (canvas && canvas.getContext) {
            // Row
            for (i = 0; i < this.numberOfRows; i++) {
                // Column
                for (j = 0; j < this.numberOfColumns; j++) {
                    drawField(i, j);
                }
            }
        }
    }

    /**
     * Initializes the boardstate Array
     *
     * @returns
     * TODO:
     */
    initializeBoardstate() {
        for (var i = 0; i < 8; i++) {
            for (var j = 0; j < 8; j++) {
                if (i === 0) {
                    switch (j) {
                        // rooks
                        case 0:
                        case 7:
                            this.boardstate[i][j] = new Rook(
                                i,
                                j,
                                "black",
                                "blackRook"
                            );
                            break;
                        // knights
                        case 1:
                        case 6:
                            this.boardstate[i][j] = new Knight(
                                i,
                                j,
                                "black",
                                "blackKnight"
                            );
                            break;
                        // bishops
                        case 2:
                        case 5:
                            this.boardstate[i][j] = new Bishop(
                                i,
                                j,
                                "black",
                                "blackBishop"
                            );
                            break;
                        // Queen
                        case 3:
                            this.boardstate[i][j] = new Queen(
                                i,
                                j,
                                "black",
                                "blackQueen"
                            );
                            break;
                        // King
                        case 4:
                            this.boardstate[i][j] = new King(
                                i,
                                j,
                                "black",
                                "blackKing"
                            );
                            break;

                        default:
                            break;
                    }
                } else if (i === 1) {
                    this.boardstate[i][j] = new Pawn(
                        i,
                        j,
                        "black",
                        "blackPawn"
                    );
                } else if (i > 1 && i < 6) {
                    this.boardstate[i][j] = "";
                } else if (i === 6) {
                    this.boardstate[i][j] = new Pawn(
                        i,
                        j,
                        "white",
                        "whitePawn"
                    );
                } else if (i === 7) {
                    switch (j) {
                        // rooks
                        case 0:
                        case 7:
                            this.boardstate[i][j] = new Rook(
                                i,
                                j,
                                "white",
                                "whiteRook"
                            );
                            break;
                        // knights
                        case 1:
                        case 6:
                            this.boardstate[i][j] = new Knight(
                                i,
                                j,
                                "white",
                                "whiteKnight"
                            );
                            break;
                        // bishops
                        case 2:
                        case 5:
                            this.boardstate[i][j] = new Bishop(
                                i,
                                j,
                                "white",
                                "whiteBishop"
                            );
                            break;
                        // Queen
                        case 3:
                            this.boardstate[i][j] = new Queen(
                                i,
                                j,
                                "white",
                                "whiteQueen"
                            );
                            break;
                        // King
                        case 4:
                            this.boardstate[i][j] = new King(
                                i,
                                j,
                                "white",
                                "whiteKing"
                            );
                            break;

                        default:
                            break;
                    }
                }
            }
        }
    }

    /**
     * Prints the complete Boardstate
     *
     * @returns
     * TODO: create Textures for black and white Pieces and include their path.
     */
    drawBoardstate() {
        var canvas = $("#chess")[0];

        for (var i = 0; i < 8; i++) {
            for (var j = 0; j < 8; j++) {
                if (this.boardstate[i][j] != "") {
                    switch (this.boardstate[i][j].name) {
                        //white
                        case "whitePawn":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;
                        case "whiteRook":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;
                        case "whiteKnight":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;
                        case "whiteBishop":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;
                        case "whiteQueen":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;
                        case "whiteKing":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;

                        //black
                        case "blackPawn":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;
                        case "blackRook":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;
                        case "blackKnight":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;
                        case "blackBishop":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;
                        case "blackQueen":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;
                        case "blackKing":
                            drawPiece(
                                this.boardstate[i][j],
                                (j * canvas.width) / 8,
                                (i * canvas.height) / 8
                            );
                            break;

                        default:
                            break;
                    }
                }
            }
        }
    }
}
//initializes/updates the Moves-Array from all Chesspieces
function setMovesOfChesspieces(boardstate) {
    for (var i = 0; i < 8; i++) {
        for (var j = 0; j < 8; j++) {
            if (boardstate[i][j] != "") {
                boardstate[i][j].setMoves(boardstate);
            }
        }
    }
    for (var i = 0; i < 8; i++) {
        for (var j = 0; j < 8; j++) {
            if (
                boardstate[i][j].name == "whiteKing" ||
                boardstate[i][j].name == "blackKing"
            ) {
                isKingInCheck(boardstate[i][j], boardstate);
            }
        }
    }
}
//resets the Moves-Array from all Chesspieces
function resetMovesOfChesspieces(boardstate) {
    for (var i = 0; i < 8; i++) {
        for (var j = 0; j < 8; j++) {
            if (boardstate[i][j] != "") {
                boardstate[i][j].moves = [];
            }
        }
    }
}
/**
 * Draws a piece onto the chessboard
 * @returns
 * TODO:
 */
function drawPiece(chesspiece, coordX, coordY) {
    var img = new Image();
    var canvas = $("#chess")[0];
    var ctx = canvas.getContext("2d");

    switch (chesspiece.name) {
        // Pawn
        case "whitePawn": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\BauerWeiss-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        case "blackPawn": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\BauerSchwarz-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        // Rook
        case "whiteRook": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\TurmWeiss-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        case "blackRook": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\TurmSchwarz-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        // Knight
        case "whiteKnight": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\SpringerWeiss-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        case "blackKnight": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\SpringerSchwarz-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        // Bishop
        case "whiteBishop": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\LauferWeiss-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        case "blackBishop": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\LauferSchwarz-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        // Queen
        case "whiteQueen": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\QueenWeiss-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        case "blackQueen": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\QueenSchwarz-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        // King
        case "whiteKing": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\KingWeiss-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }
        case "blackKing": {
            img = new Image();
            img.onload = function () {
                ctx.drawImage(
                    img,
                    coordX,
                    coordY,
                    canvas.width / 8,
                    canvas.height / 8
                );
            };
            img.src = "..\\resources\\skins\\beton\\KingSchwarz1-01.png";
            //img.crossOrigin = "anonymous";
            break;
        }

        // default
        default:
            break;
    }
}
/**
 * Calculates the color of a field by its position.
 * @param {Integer} rowCount Row of the field.
 * @param {Integer} columnCount Column of the field.
 * TODO: Choose color by user setting (predertemined skin or custom color)
 */
function getFieldColor(rowCount, columnCount) {
    return (rowCount + columnCount) % 2 === 0
        ? FIELD_COLOR_WHITE
        : FIELD_COLOR_BLACK;
}
/**
 * Draws a field at the given position on the board
 * @param {*} rowCount
 * @param {*} columnCount
 */
function drawField(rowCount, columnCount) {
    var canvas = $("#chess")[0],
        squareSize = Math.floor(canvas.height / NUMBER_OF_ROWS),
        context;

    // Check if canvas exists and is supported.
    if (canvas && canvas.getContext) {
        context = canvas.getContext("2d");

        // Draw Field.
        context.fillStyle = getFieldColor(rowCount, columnCount);
        context.fillRect(
            columnCount * squareSize,
            rowCount * squareSize,
            squareSize,
            squareSize
        );
    }
}

$(document).ready(function () {
    //initializes the Board
    var board = new Board();
    //draws the Board and all Pieces
    //initializes all relevant variables
    board.drawBoard();
    board.initializeBoardstate();

    var canvas = $("#chess")[0];
    var ctx = canvas.getContext("2d");
    var height = canvas.height;
    var width = canvas.width;
    // adds an Event Listener for Evaluation of Clicks on the Chessboard
    canvas.addEventListener("click", function () {
        clickEvaluation(event, board.boardstate, PLAYER_COLOR);
    });
    board.drawBoardstate();
    // evaluates a message from the Server
    gameWS.onmessage = function (ev) {
        var response = JSON.parse(ev.data);

        switch (response.type) {
            // On Start of the game initializes MY_TURN
            case "gameStart": {
                PLAYER_COLOR = response.playerColor;
                if (PLAYER_COLOR === "white") {
                    MY_TURN = true;
                }
                setMovesOfChesspieces(board.boardstate);
                //displays Player Color
                document.getElementById("color").append(PLAYER_COLOR);
                //game Start message
                document
                    .getElementById("secondRow")
                    .append("Game has Started!");
                //initializes TURN_COUNT
                TURN_COUNT = 1;
                document.getElementById("turncount").innerHTML =
                    "Your Turn is Turn nr. #" + TURN_COUNT;
                break;
            }
            // After Enemy moves his Chesspiece
            case "chesspieceMove": {
                TURN_COUNT++;
                if (ONLY_ONCE_HELP === false && PLAYER_COLOR == "black") {
                    TURN_COUNT--;
                    ONLY_ONCE_HELP = true;
                } else {
                    document.getElementById("secondRow").innerHTML = "";
                }
                document.getElementById("turncount").innerHTML =
                    "Your Turn is Turn nr. #" + TURN_COUNT;
                // gets Coords for Chesspiece move
                var yBefore = response.yBefore,
                    xBefore = response.xBefore,
                    yAfter = response.yAfter,
                    xAfter = response.xAfter,
                    // gets if own King is in danger
                    kingName =
                        PLAYER_COLOR === "black" ? "blackKing" : "whiteKing";
                board.boardstate.forEach((element) => {
                    var king = element.find(
                        (element) => element.name === kingName
                    );
                    king != undefined
                        ? (king.inCheck = response.inCheck)
                        : null;
                });
                //moves Chesspiece
                moveChesspiece(
                    board.boardstate,
                    yAfter,
                    xAfter,
                    yBefore,
                    xBefore
                );
                MY_TURN = true;
                break;
            }
            // when game Ends
            // remove eventListener and add Redirection after click on the Chessboard
            case "gameOver": {
                canvas.removeEventListener("click", function () {
                    clickEvaluation(event, board.boardstate, PLAYER_COLOR);
                });
                canvas.addEventListener("click", function () {
                    location.replace("http://localhost/chess/src/landing.php");
                });
                if (response.winner === PLAYER_COLOR) {
                    MY_TURN = false;
                    var img = new Image();
                    img.onload = () => {
                        ctx.drawImage(img, 0, 0, width, height);
                    };
                    img.src = "..\\resources\\Victory.png";
                } else {
                    MY_TURN = false;
                    var img = new Image();
                    img.onload = () => {
                        ctx.drawImage(img, 0, 0, width, height);
                    };
                    img.src = "..\\resources\\Defeat.png";
                }
                break;
            }
            /*            case "validate":
                var urlParams = new URLSearchParams(window.location.search);
                gameWS.send(
                    JSON.stringify({
                        type: "id",
                        name: document.getElementById("username").innerHTML,
                        gameId: urlParams.get("id"),
                    })
                );
                break; */
        }
    };
    //sends identification message to backend when websocket is opened
    //contains Username and gameId
    gameWS.onopen = function () {
        var urlParams = new URLSearchParams(window.location.search);
        gameWS.send(
            JSON.stringify({
                type: "id",
                name: document.getElementById("username").innerHTML,
                gameId: urlParams.get("id"),
            })
        );
    };
});
