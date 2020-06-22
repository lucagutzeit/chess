/**
 * Highlighting, moveChesspiece,
 */

// saves the ImageData for resetting Highlighting
var IMGDATA_BEFORE_HIGHLIGHTING = false;

// saves the last Selected Chesspiece-coordinates
var SELECTEDARRAY = [false, false];
var SELECTEDARRAYHELPER = false;

// Handles highlighting
function highlighting(event, boardstate) {
    var canvas = $("#chess")[0];
    // saves the ImgData before any Highlighting or chesspiecemoves Appear
    if (IMGDATA_BEFORE_HIGHLIGHTING === false) {
        var ctx = canvas.getContext("2d");
        var height = canvas.height;
        var width = canvas.width;
        IMGDATA_BEFORE_HIGHLIGHTING = ctx.getImageData(0, 0, width, height);
    }

    // mouse Coordinates
    var mouseCoordX = 0;
    var mouseCoordY = 0;
    mouseCoordX = event.clientX;
    mouseCoordY = event.clientY;
    // converts mouse Coordinates into boardstate-coordinates
    var coordX = 0;
    var coordY = 0;
    coordX = Math.floor(mouseCoordX / (canvas.width / 8));
    coordY = Math.floor(mouseCoordY / (canvas.height / 8));

    //check if chesspiece is clicked
    if (boardstate[coordY][coordX] != "") {
        //check if another chesspiece is currently Selected
        if (SELECTEDARRAYHELPER != false) {
            //check if Chesspiece is clicked twice
            if (
                boardstate[coordY][coordX] ==
                boardstate[SELECTEDARRAY[0]][SELECTEDARRAY[1]]
            ) {
                resetHighlighting();
                SELECTEDARRAYHELPER = false;
                return;
            }
        }
        resetHighlighting();
        highlightChesspiece(boardstate[coordY][coordX]);
        SELECTEDARRAY = [coordY, coordX];
        SELECTEDARRAYHELPER = true;
    } else {
        resetHighlighting();
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
function resetHighlighting() {
    var canvas = $("#chess")[0];
    var ctx = canvas.getContext("2d");
    ctx.putImageData(IMGDATA_BEFORE_HIGHLIGHTING, 0, 0);
}
/**
 *	Check White/black player
 *	Block other player moves
 *	Maybe Drag Drop for moving
 *	Otherwhise check klicks
 *
 */

//TODO Implement
function moveChesspiece(boardstate, yAfter, xAfter, yBefore, xBefore) {
    //initialize some variables for later usage
    var canvas = $("#chess")[0];
    var ctx = canvas.getContext("2d");
    var height = canvas.height;
    var width = canvas.width;

    //resets Highlightings
    resetHighlighting();

    //moves Chesspiece
    boardstate[yAfter][xAfter] = boardstate[yBefore][xBefore];
    boardstate[yAfter][xAfter].row = yAfter;
    boardstate[yAfter][xAfter].column = xAfter;
    boardstate[yBefore][xBefore] = "";

    //Resets Fields on Board and draws Chesspiece at right place
    drawField(yBefore, xBefore);
    drawField(yAfter, xAfter);
    drawPiece(
        boardstate[yAfter][xAfter],
        (xAfter * canvas.height) / 8,
        (yAfter * canvas.width) / 8
    );

    //updates Chesspiece move array
    boardstate[xAfter][yAfter].setMoves(boardstate);

    //save new ImageData
    IMGDATA_BEFORE_HIGHLIGHTING = ctx.getImageData(0, 0, width, height);
}
