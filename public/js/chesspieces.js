class Chesspiece {
	
	constructor(row,column,color,name){
		this.row = row;
		this.column = column;
		this.color = color;
		this.name = name;
		// einträge im array moves nach schema [row,column],[row2,column2]...
		this.moves = [];
	}

}
class Pawn extends Chesspiece {
	//constructor 
	constructor(row,column,color,name,boardstate){
		super(row,column,color,name);
		this.setMoves(boardstate);
	}

	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}
class Rook extends Chesspiece {
	//constructor 
	constructor(row,column,color,name,boardstate){
		super(row,column,color,name);
		this.setMoves(boardstate);
	}

	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}
class Knight extends Chesspiece {
	//constructor 
	constructor(row,column,color,name,boardstate){
		super(row,column,color,name,boardstate);
	}

	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}
class Bishop extends Chesspiece {
	//constructor 
	constructor(row,column,color,name,boardstate){
		super(row,column,color,name);
		this.setMoves(boardstate);
	}
	
	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}
class Queen extends Chesspiece {
	//constructor 
		constructor(row,column,color,name,boardstate){
		super(row,column,color,name);
		this.setMoves(boardstate);
	}
	
	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}
class King extends Chesspiece {
	//constructor 
	constructor(row,column,color,name,boardstate){
		super(row,column,color,name);
		this.setMoves(boardstate);
	}
	
	setMoves(boardstate){
		moveLogic(this,boardstate);
	}
}