class Chesspiece {
	
	if (this.constructor === AbstractClass){
		throw new Error('Cannot instanciate abstract class');
	}
	var name;
	var color;
	var row;
	var column;
}
class Pawn extends Chesspiece {
	var moves;
	//constructor 
	constructor(row,column,color){
		this.color = color;
		this.name = "Pawn";
		this.row = row;
		this.column = column:
		this.moves = [];
	}
	setColor(color){
		this.color = color;
	}
	//TODO: implement logic
	setMoves(board){
		var boardstate = board.getBoardstate();
	}
}
class Rook extends Chesspiece {
	var moves;
	//constructor 
	constructor(row,column,color){
		this.color = "color";
		this.name = "Rook";
		this.row = row;
		this.column = column:
		this.moves = [];
	}
	setColor(color){
			this.color = color;
	}
	//TODO: implement logic
	setMoves(board){
		var boardstate = board.getBoardstate();
	}
}
class Knight extends Chesspiece {
	var moves;
	//constructor 
	constructor(row,column){
		this.color = "color";
		this.name = "Knight";
		this.row = row;
		this.column = column:
		this.moves = [];
	}
	setColor(color){
			this.color = color;
	}
	//TODO: implement logic
	setMoves(board){
		var boardstate = board.getBoardstate();
	}
}
class Bishop extends Chesspiece {
	var moves;
	//constructor 
	constructor(row,column){
		this.color = "color";
		this.name = "Bishop";
		this.row = row;
		this.column = column:
		this.moves = [];
	}
	setColor(color){
			this.color = color;
	}
	//TODO: implement logic
	setMoves(board){
		var boardstate = board.getBoardstate();
	}
}
class Queen extends Chesspiece {
	var moves;
	//constructor 
	constructor(row,column){
		this.color = "color";
		this.name = "Queen";
		this.row = row;
		this.column = column:
		this.moves = [];
	}
	setColor(color){
			this.color = color;
	}
	//TODO: implement logic
	setMoves(board){
		var boardstate = board.getBoardstate();
	}
}
class King extends Chesspiece {
	var moves;
	//constructor 
	constructor(row,column){
		this.color = "color";
		this.name = "King";
		this.row = row;
		this.column = column:
		this.moves = [];
	}
	setColor(color){
			this.color = color;
	}
	//TODO: implement logic
	setMoves(board){
		var boardstate = board.getBoardstate();
	}
}