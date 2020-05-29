
//TODO: attribut des Typs Skin einfügen und Skin klasse schreiben welche die src als attribut speichert
class Board {
	
// Constructor
	constructor(){
		this.numberOfRows = 8;
		this.numberOfColumns = 8;
		this.fieldColorBlack = "#000000";
		this.fieldColorWhite = "#FFFFFF";
		
		// two dimensional Array as a coordinate System to work with. 
		// for basic functionalities nesseccary
		// boardstate[x][y] = boardstate{zeilen][spalten]
		this.boardstate = 
	   [["","","","","","","",""],
		["","","","","","","",""],
		["","","","","","","",""],
		["","","","","","","",""],
		["","","","","","","",""],
		["","","","","","","",""],
		["","","","","","","",""],
		["","","","","","","",""]];
	}

// Methods

//getter for Boardstate
getBoardstate(){
	return this.boardstate;
}

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
			
		// default
		default: break;
	}
 }

/**
 * Initializes the boardstate Array
 *
 * @returns
 * TODO:
 */
initializeBoardstate(){
	for(var i = 0; i< 8; i++){
		for(var j = 0; j< 8; j++){
			if (i === 0){
				switch(j){
				// rooks
				case 0:
				case 7:
				this.boardstate[i][j] = "blackRook";
				break;
				// knights
				case 1:
				case 6:
				this.boardstate[i][j] = "blackKnight";
				break;
				// bishops
				case 2:
				case 5:
				this.boardstate[i][j] = "blackBishop";
				break;
				// Queen
				case 3:
				this.boardstate[i][j] = "blackQueen";
				break;
				// King
				case 4:
				this.boardstate[i][j] = "blackKing";
				break;
				
				default: break;
				}
			}
			else if (i === 1) {
				this.boardstate[i][j] = "blackPawn";
			}
			else if (i > 1 && i < 6) {
				this.boardstate[i][j] = "";
			}
			else if (i === 6) {
				this.boardstate[i][j] = "whitePawn";
			}
			else if (i === 7) {
				switch(j){
				// rooks
				case 0:
				case 7:
				this.boardstate[i][j] = "whiteRook";
				break;
				// knights
				case 1:
				case 6:
				this.boardstate[i][j] = "whiteKnight";
				break;
				// bishops
				case 2:
				case 5:
				this.boardstate[i][j] = "whiteBishop";
				break;
				// Queen
				case 3:
				this.boardstate[i][j] = "whiteQueen";
				break;
				// King
				case 4:
				this.boardstate[i][j] = "whiteKing";
				break;
				
				default: break;
				}
			}
		}
	}
}
/**
 * Prints the complete Boardstate
 *
 * @returns
 * TODO: create Textures for black and white Pieces and include their path.
 */
drawBoardstate(){
	
	var canvas = $("#chess")[0];
		
	for(var i = 0; i< 8; i++){
		for(var j = 0; j< 8; j++){
			switch(this.boardstate[i][j]){
				
				//white
				case "whitePawn" :
				this.drawPiece(1,j*canvas.width/8,i*canvas.height/8);
				break;
				case "whiteRook" :
				this.drawPiece(2,j*canvas.width/8,i*canvas.height/8);
				break;
				case "whiteKnight":
				this.drawPiece(3,j*canvas.width/8,i*canvas.height/8);
				break;
				case "whiteBishop":
				this.drawPiece(4,j*canvas.width/8,i*canvas.height/8);
				break;
				case "whiteQueen":
				this.drawPiece(5,j*canvas.width/8,i*canvas.height/8);
				break;
				case "whiteKing" :
				this.drawPiece(6,j*canvas.width/8,i*canvas.height/8);
				break;
				
				//black
				case "blackPawn":
				this.drawPiece(1,j*canvas.width/8,i*canvas.height/8);
				break;
				case "blackRook":
				this.drawPiece(2,j*canvas.width/8,i*canvas.height/8);
				break;
				case "blackKnight":
				this.drawPiece(3,j*canvas.width/8,i*canvas.height/8);
				break;
				case "blackBishop":
				this.drawPiece(4,j*canvas.width/8,i*canvas.height/8);
				break;
				case "blackQueen":
				this.drawPiece(5,j*canvas.width/8,i*canvas.height/8);
				break;
				case "blackKing":
				this.drawPiece(6,j*canvas.width/8,i*canvas.height/8);
				break;
				
				default : break;
			}
		}
	}
}
//end
}

$(document).ready(function () {
	var board = new Board();
	board.drawBoard();
	//board.drawPiece(1,0,0);
	board.initializeBoardstate();
	board.drawBoardstate();
	
});
