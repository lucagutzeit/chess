/**
 *
 *
 *
 *
 * TODO: Highlighting, moveChesspiece, 
 */

function highlighting(event,boardstate){
	var canvas = $("#chess")[0];
	
	var mouseCoordX = 0;
	var mouseCoordY = 0;
	mouseCoordX = event.clientX;
	mouseCoordY = event.clientY;
	
	
	
	var coordX = 0;
	var coordY = 0;
	coordX = Math.floor(mouseCoordX/(canvas.width/8));
	coordY = Math.floor(mouseCoordY/(canvas.height/8));
	
	if(boardstate[coordY][coordX] != ""){
		highlightChesspiece(boardstate[coordY][coordX]);
	}
}
//TODO: Implement
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