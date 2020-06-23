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
class Pawn extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
        this.hasMoved = false;
    }

    setMoves(boardstate, playerColor) {
        moveLogic(this, boardstate, playerColor);
    }
}
class Rook extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
        this.hasMoved = false;
    }

    setMoves(boardstate, playerColor) {
        moveLogic(this, boardstate, playerColor);
    }
}
class Knight extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
    }

    setMoves(boardstate, playerColor) {
        moveLogic(this, boardstate, playerColor);
    }
}
class Bishop extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
    }

    setMoves(boardstate, playerColor) {
        moveLogic(this, boardstate, playerColor);
    }
}
class Queen extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
    }

    setMoves(boardstate, playerColor) {
        moveLogic(this, boardstate, playerColor);
    }
}
class King extends Chesspiece {
    //constructor
    constructor(row, column, color, name) {
        super(row, column, color, name);
        this.hasMoved = false;
        this.inCheck = false;
    }

    setMoves(boardstate, playerColor) {
        moveLogic(this, boardstate, playerColor);
    }
}
