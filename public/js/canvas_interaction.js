/**
 *
 *
 *
 *
 * TODO: Highlighting, moveChesspiece, 
 */
var IMGDATA_BEFORE_HIGHLIGHTING = false;

function highlighting(event,boardstate){
	var canvas = $("#chess")[0];
	if(IMGDATA_BEFORE_HIGHLIGHTING === false){
		var ctx = canvas.getContext("2d");
		var height = canvas.height;
		var width = canvas.width;
		IMGDATA_BEFORE_HIGHLIGHTING = ctx.getImageData(0,0,width,height);
	}
	
	var mouseCoordX = 0;
	var mouseCoordY = 0;
	mouseCoordX = event.clientX;
	mouseCoordY = event.clientY;
	
	var coordX = 0;
	var coordY = 0;
	coordX = Math.floor(mouseCoordX/(canvas.width/8));
	coordY = Math.floor(mouseCoordY/(canvas.height/8));
	
	if(boardstate[coordY][coordX] != ""){
		// Just triggers if no chesspiece is Selected or the clicked Chesspiece is the Same color than the previous Selected one
		if(CHESSPIECE_SELECTED == false){
			highlightChesspiece(boardstate[coordY][coordX]);
			CHESSPIECE_SELECTED = true;
			SELECTED_X = coordX;
			SELECTED_Y = coordY;
		}
	}
}
// Highlights the chosen Chesspiece
function highlightChesspiece(chesspiece){
	var canvas = $("#chess")[0];
	var ctx = canvas.getContext("2d");
	
	for(var element of chesspiece.moves){
		ctx.beginPath();
		ctx.lineWidth = "6";
		ctx.strokeStyle = "purple";
		ctx.rect(element[1]*canvas.height/8, element[0]*canvas.width/8, canvas.width/8, canvas.height/8);
		ctx.stroke();
	}
}
function resetHighlighting(){
	var canvas = $("#chess")[0];
	var ctx = canvas.getContext("2d");
	ctx.putImageData(IMGDATA_BEFORE_HIGHLIGHTING,0,0);
}
function checkIfChesspieceShouldMove(event,boardstate){
}
//TODO Implement
function moveChesspiece(boardstate,yAfter,xAfter,yBefore,xBefore){
	var canvas = $("#chess")[0];
	var ctx = canvas.getContext("2d");
	//moves Chesspiece
	boardstate[yAfter][xAfter] = boardstate[yBefore][xBefore];
	boardstate[yAfter][xAfter].row = yAfter;
	boardstate[yAfter][xAfter].column = xAfter;
	boardstate[yBefore][xBefore] = "";
	//Resets Fields on Board and draws Chesspiece at right place
	drawField(yBefore,xBefore);
	drawField(yAfter,xAfter);
	drawPiece(boardstate[yAfter][xAfter],xAfter*canvas.height/8,yAfter*canvas.width/8);
	boardstate[xAfter][yAfter].setMoves(boardstate);
	//highlightChesspiece(boardstate[xAfter][yAfter]);
	//console.log(boardstate[yAfter][xAfter].moves);
	//console.log(boardstate);
}