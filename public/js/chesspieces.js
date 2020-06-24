/**
 *	Chesspiece Class
 *	@params row int ,column int, color string, name string, moves array
 */
class Chesspiece {
    constructor(row, column, color, name) {
        this.row = row;
        this.column = column;
        this.color = color;
        this.name = name;
        // einträge im array moves nach schema [row,column] or [y-coordinate,x-coordinate]...
        this.moves = [];
    }
}
/**
 *	Pawn Chesspiece Class 
 *	extend Chesspiece Class
 *	@param hasMoved boolean
 */
class Pawn extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
        this.hasMoved = false;
    }

    setMoves(boardstate) {
        moveLogic(this, boardstate);
    }
}
/**
 *	Rook Chesspiece Class 
 *	extend Chesspiece Class
 *	@param hasMoved boolean
 */
class Rook extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
        this.hasMoved = false;
    }

    setMoves(boardstate) {
        moveLogic(this, boardstate);
    }
}
/**
 *	Knight Chesspiece Class 
 *	extend Chesspiece Class
 */
class Knight extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
    }

    setMoves(boardstate) {
        moveLogic(this, boardstate);
    }
}
/**
 *	Bishop Chesspiece Class 
 *	extend Chesspiece Class
 */
class Bishop extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
    }

    setMoves(boardstate) {
        moveLogic(this, boardstate, );
    }
}
/**
 *	Queen Chesspiece Class 
 *	extend Chesspiece Class
 */
class Queen extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
    }

    setMoves(boardstate) {
        moveLogic(this, boardstate, );
    }
}
/**
 *	King Chesspiece Class 
 *	extend Chesspiece Class
 *	@param hasMoved boolean
 *	@param inCheck boolean
 */
class King extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
        this.hasMoved = false;
        this.inCheck = false;
    }

    setMoves(boardstate) {
        moveLogic(this, boardstate);
    }
}
