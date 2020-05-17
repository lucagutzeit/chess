const NUMBER_OF_ROWS = 8;
const NUMBER_OF_COLUMNS = 8;

const FIELD_COLOR_DARK = "#000000";
const FIELD_COLOR_LIGHT = "#FFFFFF";

$(document).ready(function () {
  drawBoard();
});

/**
 * Draws the chess board, by calculating the size of one field depending on the
 * height of the canvas.
 */
function drawBoard() {
  var i = 0,
    canvas = $("#chess")[0];

  // Check for existance of canvas and support in the browser.
  if (canvas && canvas.getContext) {
    // Draw each row.
    for (i = 0; i < NUMBER_OF_ROWS; i++) {
      drawRow(i);
    }
  }
} // drawBoard()

/**
  // drawRow()

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
 *  Draw the given row of the chess board.
 * @param {Integer} rowCount Row to be drawn.
 */
function drawRow(rowCount) {
  var i = 0;

  for (i = 0; i < NUMBER_OF_COLUMNS; i++) {
    drawField(rowCount, i);
  }
}
