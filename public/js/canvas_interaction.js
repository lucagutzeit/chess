/**
 *
 *
 *
 *
 * TODO: Highlighting, moveChesspiece, 
 */
var CHESSPIECE_SELECTED = false;
var IMGDATA_BEFORE_HIGHLIGHTING = false;
var SELECTED_X = false;
var SELECTED_Y = false;
var CURRENTLY_MOVING = false;

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
	var canvas = $("#chess")[0];
	var mouseCoordX = 0;
	var mouseCoordY = 0;
	mouseCoordX = event.clientX;
	mouseCoordY = event.clientY;
	var coordX = 0;
	var coordY = 0;
	coordX = Math.floor(mouseCoordX/(canvas.width/8));
	coordY = Math.floor(mouseCoordY/(canvas.height/8));
	if(CHESSPIECE_SELECTED != false && CURRENTLY_MOVING == false){
		if(SELECTED_X == coordX && SELECTED_X == coordY){
			resetHighlighting();
			CHESSPIECE_SELECTED = false;
			SELECTED_Y = false;
			SELECTED_X = false;
		}
		else if (boardstate[SELECTED_Y][SELECTED_X].color == boardstate[coordY][coordX].color){
			resetHighlighting();
			CHESSPIECE_SELECTED = true;
			SELECTED_Y = coordY;
			SELECTED_X = coordX;
			highlightChesspiece(boardstate[coordY][coordX]);
			
		} 
		else if (SELECTED_Y != false && SELECTED_X != false){
			for(var element of boardstate[SELECTED_Y][SELECTED_X].moves){
				if(element[1] == coordY && element[0] == coordX){
					resetHighlighting();
					CURRENTLY_MOVING = true;
					moveChesspiece(boardstate,coordY,coordX);
					CHESSPIECE_SELECTED = false;
					SELECTED_Y = false;
					SELECTED_X = false;
					IMGDATA_BEFORE_HIGHLIGHTING = false;
				} else {
					resetHighlighting();
					CHESSPIECE_SELECTED = false;
					SELECTED_Y = false;
					SELECTED_X = false; 
				}
			}
		}
	}
}
//TODO Implement
function moveChesspiece(boardstate,yAfter,xAfter){
	var canvas = $("#chess")[0];
	var ctx = canvas.getContext("2d");
	//moves Chesspiece
	boardstate[yAfter][xAfter] = boardstate[SELECTED_Y][SELECTED_X];
	boardstate[SELECTED_Y][SELECTED_X] = "";
	//Resets Fields on Board and draws Chesspiece at right place
	drawField(SELECTED_Y,SELECTED_X);
	drawField(yAfter,xAfter);
	drawPiece(boardstate[yAfter][xAfter],xAfter*canvas.height/8,yAfter*canvas.width/8);
	CURRENTLY_MOVING = false;
	setMovesOfChesspieces(boardstate);
	console.log(boardstate);
}