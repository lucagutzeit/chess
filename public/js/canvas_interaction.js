/**
 * Highlighting, moveChesspiece,
 */

// saves the ImageData for resetting Highlighting
var IMGDATA_BEFORE_HIGHLIGHTING = false;

// saves the last Selected Chesspiece-coordinates
var CURRENTLY_SELECTED_FIELD = [];


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
        if (CURRENTLY_SELECTED_FIELD.length != 0) {
            //check if Chesspiece is clicked twice
            if (
                boardstate[coordY][coordX] ==
                boardstate[CURRENTLY_SELECTED_FIELD[0]][CURRENTLY_SELECTED_FIELD[1]]
            ) {
                resetHighlighting();
                CURRENTLY_SELECTED_FIELD = [];
                return;
            }else if(
				boardstate[coordY][coordX].color !=
                boardstate[CURRENTLY_SELECTED_FIELD[0]][CURRENTLY_SELECTED_FIELD[1]].color
				){
				var moves = boardstate[CURRENTLY_SELECTED_FIELD[0]][CURRENTLY_SELECTED_FIELD[1]].moves;
				if(moves.find((element) => element[0] === coordY && (element[1]) === coordX) != undefined){
					moveChesspiece(boardstate,coordY,coordX,CURRENTLY_SELECTED_FIELD[0],CURRENTLY_SELECTED_FIELD[1]);
					CURRENTLY_SELECTED_FIELD = [];
					return;
				}
			}
        }
        resetHighlighting();
        highlightChesspiece(boardstate[coordY][coordX]);
        CURRENTLY_SELECTED_FIELD = [coordY, coordX];
    } else if(CURRENTLY_SELECTED_FIELD.length != 0){
		var moves = boardstate[CURRENTLY_SELECTED_FIELD[0]][CURRENTLY_SELECTED_FIELD[1]].moves;
			if(moves.find((element) => element[0] === coordY && (element[1]) === coordX) != undefined){
				moveChesspiece(boardstate,coordY,coordX,CURRENTLY_SELECTED_FIELD[0],CURRENTLY_SELECTED_FIELD[1]);
				CURRENTLY_SELECTED_FIELD = [];
			}
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
// Resets all Highlighting
function resetHighlighting() {
    var canvas = $("#chess")[0];
    var ctx = canvas.getContext("2d");
    ctx.putImageData(IMGDATA_BEFORE_HIGHLIGHTING, 0, 0);
}

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
	switch(boardstate[yAfter][xAfter].name){
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
}
