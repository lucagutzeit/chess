//TODO: attribut des Typs Skin einfügen und Skin klasse schreiben welche die src als attribut speichert
var FIELD_COLOR_BLACK = "#785027";
var FIELD_COLOR_WHITE = "#FFFFFF";
var NUMBER_OF_ROWS = 8;
var NUMBER_OF_COLUMNS = 8;
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
        setMovesOfChesspieces(this.boardstate);
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
    //end
}

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
 *
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
    var board = new Board();
    board.drawBoard();
    board.initializeBoardstate();

    var canvas = $("#chess")[0];
    canvas.addEventListener("click", function () {
        clickEvaluation(event, board.boardstate);
    });
    board.drawBoardstate();
});
