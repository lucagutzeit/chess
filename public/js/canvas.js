
class Board {
	
// Constructor
	constructor(){
		this.numberOfRows = 8;
		this.numberOfColumns = 8;
		this.fieldColorBlack = "#000000";
		this.fieldColorWhite = "#FFFFFF";
		
		// two dimensional Array as a coordinate System to work with. 
		// for basic functionalities nesseccary
		this.coordinates = 
	   [[0,0,0,0,0,0,0,0]
		[0,0,0,0,0,0,0,0]
		[0,0,0,0,0,0,0,0]
		[0,0,0,0,0,0,0,0]
		[0,0,0,0,0,0,0,0]
		[0,0,0,0,0,0,0,0]
		[0,0,0,0,0,0,0,0]
		[0,0,0,0,0,0,0,0]];
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
                this.drawField(i, j);
			}
		}
	}
}
/**
 * Draws a field at the given position on the board
 * @param {*} rowCount
 * @param {*} columnCount
 */
drawField(rowCount, columnCount) {
    var canvas = $("#chess")[0],
        squareSize = Math.floor(canvas.height / this.numberOfRows),
        context;

    // Check if canvas exists and is supported.
    if (canvas && canvas.getContext) {
        context = canvas.getContext("2d");

        // Draw Field.
        context.fillStyle = this.getFieldColor(rowCount, columnCount);
        context.fillRect(
            columnCount * squareSize,
            rowCount * squareSize,
            squareSize,
            squareSize
        );
    }
}
/**
 * Calculates the color of a field by its position.
 * @param {Integer} rowCount Row of the field.
 * @param {Integer} columnCount Column of the field.
 * TODO: Choose color by user setting (predertemined skin or custom color)
 */
getFieldColor(rowCount, columnCount) {
    return (rowCount + columnCount) % 2 === 0
        ? this.fieldColorWhite
        : this.fieldColorBlack;
}
/**
 * Draws a piece onto the chessboard
 *
 * @returns
 * TODO:
 */
drawPiece(chesspiece,coordX,coordY){
	
	var canvas = $("#chess")[0];
	var ctx = canvas.getContext("2d");
	
	switch(chesspiece){
		
		// Pawn
		case 1:{
			var img = new Image();
			img.onload = function(){
				ctx.drawImage(img,coordX,coordY,canvas.width/8,canvas.height/8);
			};
			img.src = '..\\resources\\skins\\test\\pawn.png';
			break;
			}
		
		// Rook
		case 2:{
			var img = new Image();
			img.onload = function(){
				ctx.drawImage(img,coordX,coordY,canvas.width/8,canvas.height/8);
			};
			img.src = '..\\resources\\skins\\test\\rook.png';
			break;
			}
		
		// Knight
		case 3:{
			var img = new Image();
			img.onload = function(){
				ctx.drawImage(img,coordX,coordY,canvas.width/8,canvas.height/8);
			};
			img.src = '..\\resources\\skins\\test\\knight.png';
			break;
			}	
		
		// Bishop
		case 4:{
			var img = new Image();
			img.onload = function(){
				ctx.drawImage(img,coordX,coordY,canvas.width/8,canvas.height/8);
			};
			img.src = '..\\resources\\skins\\test\\bishop.png';
			break;
			}
		
		// Queen
		case 5:{
			var img = new Image();
			img.onload = function(){
				ctx.drawImage(img,coordX,coordY,canvas.width/8,canvas.height/8);
			};
			img.src = '..\\resources\\skins\\test\\queen.png';
			break;
			}
		
		// King
		case 6:{
			var img = new Image();
			img.onload = function(){
				ctx.drawImage(img,coordX,coordY,canvas.width/8,canvas.height/8);
			};
			img.src = '..\\resources\\skins\\test\\king.png';
			break;
			}
	}
 }

//end
}

$(document).ready(function () {
	var board = new Board();
	board.drawBoard();
	board.drawPiece(1,0,0);
});
