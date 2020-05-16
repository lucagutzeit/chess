const NUMBER_OF_ROWS = 8;
const NUMBER_OF_COLUMNS = 8;

const FIELD_COLOR_DARK = "#000000";
const FIELD_COLOR_LIGHT = "#FFFFFF";

/* global fieldsize */
fieldSize = 0;

$(document).ready(function () {
  drawBoard();
});

/**
 *
 */
function drawBoard() {
  var i = 0,
    canvas = $("#chess")[0];

  if (canvas && canvas.getContext) {
    // Calculate the precise field size
    fieldSize = Math.floor(canvas.height / NUMBER_OF_ROWS);

    for (i = 0; i < NUMBER_OF_ROWS; i++) {
      drawRow(i);
    }
  }
}

function drawRow(rowCount) {
  var i = 0;

  for (i = 0; i < NUMBER_OF_COLUMNS; i++) {
    drawField(rowCount, i);
  }
}

function drawField(rowCount, columnCount) {
  var canvas = $("#chess")[0];
  if (canvas && canvas.getContext) {
    let context = canvas.getContext("2d");

    context.fillStyle = getFieldColor(rowCount, columnCount);
    context.fillRect(
      columnCount * fieldSize,
      rowCount * fieldSize,
      fieldSize,
      fieldSize
    );
  }
}

function getFieldColor(rowCount, columnCount) {
  var black = "#000000",
    white = "#FFFFFF";

  if (rowCount % 2 === 0) {
    return columnCount % 2 === 0 ? FIELD_COLOR_LIGHT : FIELD_COLOR_DARK;
  } else {
    return columnCount % 2 === 0 ? FIELD_COLOR_DARK : FIELD_COLOR_DARK;
  }
}
