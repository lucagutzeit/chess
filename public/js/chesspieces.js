class Chesspiece {
	
	constructor(row,column,color,name){
		this.row = row;
		this.column = column;
		this.color = color;
		this.name = name;
		this.moves = [];
	}

}
class Pawn extends Chesspiece {
	//constructor 
	constructor(row,column,color,name){
		super(row,column,color,name);
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
	//constructor 
	constructor(row,column,color,name){
		super(row,column,color,name);
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
	//constructor 
	constructor(row,column,color,name){
		super(row,column,color,name);
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
	//constructor 
	constructor(row,column,color,name){
		super(row,column,color,name);
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
	//constructor 
		constructor(row,column,color,name){
		super(row,column,color,name);
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
	//constructor 
	constructor(row,column,color,name){
		super(row,column,color,name);

	}
	setColor(color){
		this.color = color;
	}
	//TODO: implement logic
	setMoves(board){
		var boardstate = board.getBoardstate();
	}
}