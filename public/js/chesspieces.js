class Chesspiece {
	
	constructor(row,column,color,name){
		this.row = row;
		this.column = column;
		this.color = color;
		this.name = name;
		// einträge im array moves nach schema [row,column] or [y-coordinate,x-coordinate]...
		this.moves = [];
	}

}
class Pawn extends Chesspiece {
	//constructor 
	constructor(row,column,color,name){
		super(row,column,color,name);
		this.hasMoved = false;
	}

	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}
class Rook extends Chesspiece {
	//constructor 
	constructor(row,column,color,name){
		super(row,column,color,name);
		this.hasMoved = false;
	}

	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}
class Knight extends Chesspiece {
	//constructor 
	constructor(row,column,color,name){
		super(row,column,color,name);
	}

	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}
class Bishop extends Chesspiece {
	//constructor 
	constructor(row,column,color,name){
		super(row,column,color,name);
	}
	
	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}
class Queen extends Chesspiece {
	//constructor 
		constructor(row,column,color,name){
		super(row,column,color,name);
	}
	
	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}
class King extends Chesspiece {
	//constructor 
	constructor(row,column,color,name){
		super(row,column,color,name);
		this.hasMoved = false;
	}
	
	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}