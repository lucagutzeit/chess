const NUMBER_OF_ROWS = 8;
const NUMBER_OF_COLUMNS = 8;

const FIELD_COLOR_DARK = "#000000";
const FIELD_COLOR_LIGHT = "#FFFFFF";

/* const PIECE_PAWN = 0,
    PIECE_CASTLE = 1,
    PIECE_KNIGHT = 2,
    PIECE_BISHOP = 3,
    PIECE_QUEEN = 4,
    PIECE_KING = 5; */

/* const IN_PLAY = true; */

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
            for (j = 0; j < NUMBER_OF_COLUMNS; j++) {
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
 * @returns {JSON}
 * TODO: Get board state from server
 */
function getBoardState() {
    var positionJSON = $.getJson("defaultBoardState.json");

    return positionJSON;
} //getBoardState()
