const NUMBER_OF_ROWS = 8;
const NUMBER_OF_COLUMNS = 8;

const FIELD_COLOR_DARK = "#000000";
const FIELD_COLOR_LIGHT = "#FFFFFF";

const PIECE_PAWN = 0,
    PIECE_CASTLE = 1,
    PIECE_KNIGHT = 2,
    PIECE_BISHOP = 3,
    PIECE_QUEEN = 4,
    PIECE_KING = 5;

const IN_PLAY = true,


$(document).ready(function () {
    drawBoard();
});

/**
 * Draws the chess board, by calculating the size of one field depending on the
 * height of the canvas.
 */
function drawBoard() {
    var i = 0,
        j = 0,
        canvas = $("#chess")[0];

    // Check if canvas exists and is supported.
    if (canvas && canvas.getContext) {
        // Row
        for (i = 0; i < NUMBER_OF_ROWS; i++) {
            // Column
            for (i = 0; i < NUMBER_OF_COLUMNS; i++) {
                drawField(i, j);
            }
        }
    }
} // drawBoard()

/**
 * Draws a field at the given position on the board
 * @param {*} rowCount
 * @param {*} columnCount
 */
function drawField(rowCount, columnCount) {
    var canvas = $("#chess")[0],
        boardTopOffset = 50,
        squareSize = Math.floor(
            canvas.height - (2 * boardTopOffset) / NUMBER_OF_ROWS
        ),
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
} // drawField()

/**
 * Calculates the color of a field by its position.
 * @param {Integer} rowCount Row of the field.
 * @param {Integer} columnCount Column of the field.
 * TODO: Choose color by user setting (predertemined skin or custom color)
 */
function getFieldColor(rowCount, columnCount) {
    return (rowCount + columnCount) % 2 === 0
        ? FIELD_COLOR_LIGHT
        : FIELD_COLOR_DARK;
} //getField()

/**
 *
 * @param {JSON} positions positions of all pieces
 */
function drawPieces(positions, piecesPNG) {} //drawPieces()

/**
 *
 * @returns {JSON}
 * TODO: Get board state from server
 */
function getBoardState() {
    var positionJSON = {
        white: [
            {
                piece: PIECE_CASTLE,
                row: 0,
                col: 0,
                status: IN_PLAY,
            },
            {
                piece: PIECE_ROUKE,
                row: 0,
                col: 1,
                status: IN_PLAY,
            },
            {
                piece: PIECE_BISHOP,
                row: 0,
                col: 2,
                status: IN_PLAY,
            },
            {
                piece: PIECE_KING,
                row: 0,
                col: 3,
                status: IN_PLAY,
            },
            {
                piece: PIECE_QUEEN,
                row: 0,
                col: 4,
                status: IN_PLAY,
            },
            {
                piece: PIECE_BISHOP,
                row: 0,
                col: 5,
                status: IN_PLAY,
            },
            {
                piece: PIECE_ROUKE,
                row: 0,
                col: 6,
                status: IN_PLAY,
            },
            {
                piece: PIECE_CASTLE,
                row: 0,
                col: 7,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 1,
                col: 0,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 1,
                col: 1,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 1,
                col: 2,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 1,
                col: 3,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 1,
                col: 4,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 1,
                col: 5,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 1,
                col: 6,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 1,
                col: 7,
                status: IN_PLAY,
            },
        ],
        black: [
            {
                piece: PIECE_CASTLE,
                row: 7,
                col: 0,
                status: IN_PLAY,
            },
            {
                piece: PIECE_ROUKE,
                row: 7,
                col: 1,
                status: IN_PLAY,
            },
            {
                piece: PIECE_BISHOP,
                row: 7,
                col: 2,
                status: IN_PLAY,
            },
            {
                piece: PIECE_KING,
                row: 7,
                col: 3,
                status: IN_PLAY,
            },
            {
                piece: PIECE_QUEEN,
                row: 7,
                col: 4,
                status: IN_PLAY,
            },
            {
                piece: PIECE_BISHOP,
                row: 7,
                col: 5,
                status: IN_PLAY,
            },
            {
                piece: PIECE_ROUKE,
                row: 7,
                col: 6,
                status: IN_PLAY,
            },
            {
                piece: PIECE_CASTLE,
                row: 7,
                col: 7,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 6,
                col: 0,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 6,
                col: 1,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 6,
                col: 2,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 6,
                col: 3,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 6,
                col: 4,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 6,
                col: 5,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 6,
                col: 6,
                status: IN_PLAY,
            },
            {
                piece: PIECE_PAWN,
                row: 6,
                col: 7,
                status: IN_PLAY,
            },
        ],
    };

    return positionJSON;
} //getBoardState()