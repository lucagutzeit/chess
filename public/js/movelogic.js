/**
 * uses methods to fill an array with legit moves
 *
 * @returns
 * TODO:
 */
function moveLogic(chesspiece, boardstate) {
    switch (chesspiece.name) {
        case "whitePawn":
            getWhitePawnMoves(chesspiece, boardstate);
            break;
        case "blackPawn":
            getBlackPawnMoves(chesspiece, boardstate);
            break;
        case "whiteRook":
        case "blackRook":
            getRookMoves(chesspiece, boardstate);
            break;
        case "whiteKnight":
        case "blackKnight":
            getKnightMoves(chesspiece, boardstate);
            break;
        case "whiteBishop":
        case "blackBishop":
            getBishopMoves(chesspiece, boardstate);
            break;
        case "whiteQueen":
        case "blackQueen":
            getQueenMoves(chesspiece, boardstate);
            break;
        case "whiteKing":
        case "blackKing":
            getKingMoves(chesspiece, boardstate);
            break;
        default:
            break;
    }
}

function getBlackPawnMoves(chesspiece, boardstate) {
    var row = chesspiece.row;
    var column = chesspiece.column;
    var counter = 0;

    var leftHelp = 0;
    var rightHelp = 0;
    var bottomHelp = 0;
    //check Edges
    //left
    if (column == 0) {
        leftHelp = 1;
    }
    //right
    if (column == 7) {
        rightHelp = 1;
    }
    //top
    if (row == 7) {
        bottomHelp = 1;
    }
    //TODO Bauernumwandlung
    if (bottomHelp == 0) {
        if (boardstate[row + 1][column] == "") {
            chesspiece.moves[counter] = [row + 1, column];
            counter++;
        }
		if (chesspiece.hasMoved === false){
			if(boardstate[row + 2][column] == ""){
				chesspiece.moves[counter] = [row + 2, column];
				counter++;
			}
		}
        if (rightHelp == 0 && boardstate[row + 1][column + 1] != "") {
            if (boardstate[row + 1][column + 1].color == "white") {
                chesspiece.moves[counter] = [row + 1, column + 1];
                counter++;
            }
        }
        if (leftHelp == 0 && boardstate[row + 1][column - 1] != "") {
            if (boardstate[row + 1][column - 1].color == "white") {
                chesspiece.moves[counter] = [row + 1, column - 1];
                counter++;
            }
        }
    }
}
function getWhitePawnMoves(chesspiece, boardstate) {
    var row = chesspiece.row;
    var column = chesspiece.column;
    var counter = 0;

    var leftHelp = 0;
    var rightHelp = 0;
    var topHelp = 0;

    //check Edges
    //left
    if (column == 0) {
        leftHelp = 1;
    }
    //right
    if (column == 7) {
        rightHelp = 1;
    }
    //bottom
    if (row == 0) {
        topHelp = 1;
    }
    //TODO Bauernumwandlung
    if (topHelp == 0) {
        if (boardstate[row - 1][column] == "") {
            chesspiece.moves[counter] = [row - 1, column];
            counter++;
        }
		if (chesspiece.hasMoved === false){
			if(boardstate[row - 2][column] == ""){
				chesspiece.moves[counter] = [row - 2, column];
				counter++;
			}
		}
        if (rightHelp == 0 && boardstate[row - 1][column + 1] != "") {
            if (boardstate[row - 1][column + 1].color == "black") {
                chesspiece.moves[counter] = [row - 1, column + 1];
                counter++;
            }
        }
        if (leftHelp == 0 && boardstate[row - 1][column - 1] != "") {
            if (boardstate[row - 1][column - 1].color == "black") {
                chesspiece.moves[counter] = [row - 1, column - 1];
                counter++;
            }
        }
    }
}
function getRookMoves(chesspiece,boardstate){
	var row = chesspiece.row;
	var column = chesspiece.column;
	var counter = 0;
	
	//now the real Logic Shedizzle
	
	var leftHelp = 0;
	var rightHelp = 0;
	var topHelp = 0;
	var bottomHelp = 0;
	
	//initially checking where our chesspiece is placed
	//if placed at a edge of our Field do:
	
	//top edge
	if(row == 0){
		topHelp = 1;
	}
	//bottom edge
	if(row == 7){
		bottomHelp = 1;
	}
	//left edge
	if(column == 0){
		leftHelp = 1;
	}
	//right edge
	if(column == 7){
		rightHelp = 1;
	}
	for(var i = 1; i < 8; i++){
		//left
		//check if its free space
		if(leftHelp == 0 && boardstate[row][column - i] == ""){
			chesspiece.moves[counter] = [row, column - i];
			counter++;
		}
		// check if Piece on the Board is an enemy
		else if (leftHelp == 0 && boardstate[row][column - i].color != chesspiece.color){
			chesspiece.moves[counter] = [row, column - i];
			counter++;
			leftHelp = 1;
		} else if (leftHelp == 0){
			leftHelp = 1;
		}
		//check for Edges
		if(column - i == 0){
			leftHelp = 1;
		}
		//right
		//check if its free Space
		if(rightHelp == 0 && boardstate[row][column + i] == ""){
			chesspiece.moves[counter] = [row, column + i];
			counter++;
		}
		//check if Piece on the board is an enemy
		else if (rightHelp == 0 && boardstate[row][column + i].color != chesspiece.color){
			chesspiece.moves[counter] = [row, column + i];
			counter++;
			rightHelp = 1;
		} else if (rightHelp == 0){
			rightHelp = 1;
		}
		//check for Edges
		if(column + i == 7){
			rightHelp = 1;
		}
		//top
		//check if its free Space
		if(topHelp == 0 && boardstate[row - i][column] == ""){
			chesspiece.moves[counter] = [row - i, column];
			counter++;
		}
		//check if Piece on the board is an enemy
		else if(topHelp == 0 && boardstate[row - i][column].color != chesspiece.color){
			chesspiece.moves[counter] = [row - i, column];
			counter++;
			topHelp = 1;
		} else if (topHelp == 0){
			topHelp = 1;
		}
		//check for Edges
		if(row - i == 0){
			topHelp = 1;
		}
		//bottom
		//check if its free Space
		if(bottomHelp == 0 && boardstate[row + i][column] == ""){
			chesspiece.moves[counter] = [row + i, column];
			counter++;
		}
		//check if Piece on the board is an enemy
		else if(bottomHelp == 0 && boardstate[row + i][column].color != chesspiece.color){
			chesspiece.moves[counter] = [row + i, column];
			counter++;
			bottomHelp = 1;
		} else if (bottomHelp == 0){
			bottomHelp = 1;
		}
		//check for Edges
		if( row + i == 7){
			bottomHelp = 1;
		}
		
	}
}
function getBishopMoves(chesspiece,boardstate){
	var row = chesspiece.row;
	var column = chesspiece.column;
	var counter = 0;
	
	//now the real Logic Shedizzle
	
	var leftTopHelp = 0;
	var rightTopHelp = 0;
	var leftBottomHelp = 0;
	var rightBottomHelp = 0;
	
	//initially checking where our chesspiece is placed
	//if placed at a edge of our Field do:
	
	//leftTop edge
	if(column ==  0 || row == 0){
		leftTopHelp = 1;
	}
	//rightTop edge
	if(column == 7 || row == 0){
		rightTopHelp = 1;
	}
	//leftBottom edge
	if(column == 0 || row == 7){
		leftBottomHelp = 1;
	}
	//rightBottom edge
	if(column == 7 || row == 7){
		rightBottomHelp = 1;
	}
	
	for(var i = 1; i < 8; i++){
		//leftTop
		//check if its free space
		if(leftTopHelp == 0 && boardstate[row-i][column-i] == ""){
			chesspiece.moves[counter] = [row-i,column-i];
			counter++;
		}
		// check if Piece on the Board is an enemy
		else if (leftTopHelp == 0 && boardstate[row-i][column-i].color != chesspiece.color){
			chesspiece.moves[counter] = [row-i, column-i];
			counter++;
			leftTopHelp = 1;
		} else if (leftTopHelp == 0){
			leftTopHelp = 1;
		}
		//check for Edges
		if(column-i ==  0 || row-i == 0){
				leftTopHelp = 1;
			}
		//rightTop
			if(rightTopHelp == 0 && boardstate[row-i][column+i] == ""){
			chesspiece.moves[counter] = [row-i,column+i];
			counter++;
		}
		// check if Piece on the Board is an enemy
		else if (rightTopHelp == 0 && boardstate[row-i][column+i].color != chesspiece.color){
			chesspiece.moves[counter] = [row-i, column+i];
			counter++;
			rightTopHelp = 1;
		} else if (rightTopHelp == 0){
			rightTopHelp = 1;
		}
		//check for Edges
		if(column+i ==  7 || row-i == 0){
				rightTopHelp = 1;
			}
		//leftBottom
			if(leftBottomHelp == 0 && boardstate[row+i][column-i] == ""){
			chesspiece.moves[counter] = [row+i,column-i];
			counter++;
		}
		// check if Piece on the Board is an enemy
		else if (leftBottomHelp == 0 && boardstate[row+i][column-i].color != chesspiece.color){
			chesspiece.moves[counter] = [row+i, column-i];
			counter++;
			leftBottomHelp = 1;
		} else if (leftBottomHelp == 0){
			leftBottomHelp = 1;
		}
		//check for Edges
		if(row+i == 7 || column-i == 0){
				leftBottomHelp = 1;
			}
		//rightBottom
			if(rightBottomHelp == 0 && boardstate[row+i][column+i] == ""){
			chesspiece.moves[counter] = [row+i,column+i];
			counter++;
		}
		// check if Piece on the Board is an enemy
		else if (rightBottomHelp == 0 && boardstate[row+i][column+i].color != chesspiece.color){
			chesspiece.moves[counter] = [row+i, column+i];
			counter++;
			rightBottomHelp = 1;
		} else if (rightBottomHelp == 0){
			rightBottomHelp = 1;
		}
		//check for Edges
		if(row+i == 7 || column+i == 7){
				rightBottomHelp = 1;
		}
		
	}
}
function getKnightMoves(chesspiece, boardstate) {
    var row = chesspiece.row;
    var column = chesspiece.column;
    var counter = 0;

    // helpers

    var topHelp = 0;
    var twiceTopHelp = 0;
    var bottomHelp = 0;
    var twiceBottomHelp = 0;
    var leftHelp = 0;
    var twiceLeftHelp = 0;
    var rightHelp = 0;
    var twiceRightHelp = 0;

    // check edges
    if (row == 0) {
        topHelp = 1;
        twiceTopHelp = 1;
    }
    if (row == 1) {
        twiceTopHelp = 1;
    }
    if (row == 6) {
        twiceBottomHelp = 1;
    }
    if (row == 7) {
        bottomHelp = 1;
        twiceBottomHelp = 1;
    }
    if (column == 0) {
        leftHelp = 1;
        twiceLeftHelp = 1;
    }
    if (column == 1) {
        twiceLeftHelp = 1;
    }
    if (column == 6) {
        twiceRightHelp = 1;
    }
    if (column == 7) {
        rightHelp = 1;
        twiceRightHelp = 1;
    }

    // twiceTop right
    // check for free space
    if (
        twiceTopHelp == 0 &&
        rightHelp == 0 &&
        boardstate[row - 2][column + 1] == ""
    ) {
        chesspiece.moves[counter] = [row - 2, column + 1];
        counter++;
    }
    // check if piece is an Enemy
    else if (
        twiceTopHelp == 0 &&
        rightHelp == 0 &&
        boardstate[row - 2][column + 1].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row - 2, column + 1];
        counter++;
    }
    // twiceRight top
    // check for free space
    if (
        twiceRightHelp == 0 &&
        topHelp == 0 &&
        boardstate[row - 1][column + 2] == ""
    ) {
        chesspiece.moves[counter] = [row - 1, column + 2];
        counter++;
    }
    // check if piece is an Enemy
    else if (
        twiceRightHelp == 0 &&
        topHelp == 0 &&
        boardstate[row - 1][column + 2].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row - 1, column + 2];
        counter++;
    }
    // twiceRight bottom
    // check for free space
    if (
        twiceRightHelp == 0 &&
        bottomHelp == 0 &&
        boardstate[row + 1][column + 2] == ""
    ) {
        chesspiece.moves[counter] = [row + 1, column + 2];
        counter++;
    }
    // check if piece is an Enemy
    else if (
        twiceRightHelp == 0 &&
        bottomHelp == 7 &&
        boardstate[row + 1][column + 2].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row + 1, column + 2];
        counter++;
    }
    // twiceBottom right
    // check for free Space
    if (
        twiceBottomHelp == 0 &&
        rightHelp == 0 &&
        boardstate[row + 2][column + 1] == ""
    ) {
        chesspiece.moves[counter] = [row + 2, column + 1];
        counter++;
    }
    // check if piece is an Enemy
    else if (
        twiceBottomHelp == 0 &&
        rightHelp == 0 &&
        boardstate[row + 2][column + 1].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row + 2, column + 1];
        counter++;
    }
    // twiceBottom left
    // check for free space
    if (
        twiceBottomHelp == 0 &&
        leftHelp == 0 &&
        boardstate[row + 2][column - 1] == ""
    ) {
        chesspiece.moves[counter] = [row + 2, column - 1];
        counter++;
    }
    // check if piece is an Enemy
    else if (
        twiceBottomHelp == 0 &&
        leftHelp == 0 &&
        boardstate[row + 2][column - 1].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row + 2, column - 1];
        counter++;
    }
    // twiceLeft bottom
    // check for free space
    if (
        twiceLeftHelp == 0 &&
        bottomHelp == 0 &&
        boardstate[row + 1][column - 2] == ""
    ) {
        chesspiece.moves[counter] = [row + 1, column - 2];
        counter++;
    }
    // check if piece is an Enemy
    else if (
        twiceLeftHelp == 0 &&
        bottomHelp == 0 &&
        boardstate[row + 1][column - 2].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row + 1, column - 2];
        counter++;
    }
    // twiceLeft top
    // check for free space
    if (
        twiceLeftHelp == 0 &&
        topHelp == 0 &&
        boardstate[row - 1][column - 2] == ""
    ) {
        chesspiece.moves[counter] = [row - 1, column - 2];
        counter++;
    }
    // check if piece is an Enemy
    else if (
        twiceLeftHelp == 0 &&
        topHelp == 0 &&
        boardstate[row - 1][column - 2].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row - 1, column - 2];
        counter++;
    }
    // twiceTop left
    // check for free space
    if (
        twiceTopHelp == 0 &&
        leftHelp == 0 &&
        boardstate[row - 2][column - 1] == ""
    ) {
        chesspiece.moves[counter] = [row - 2, column - 1];
        counter++;
    }
    // check if piece is an Enemy
    else if (
        twiceTopHelp == 0 &&
        leftHelp == 0 &&
        boardstate[row - 2][column - 1].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row - 2, column - 1];
        counter++;
    }
}
function getQueenMoves(chesspiece, boardstate) {
    // be a good IT student and recycle code
    getRookMoves(chesspiece, boardstate);
    var tempMoves = chesspiece.moves;
    chesspiece.moves = [];
    // twice if u can =P
    getBishopMoves(chesspiece, boardstate);
    var tempMoves2 = chesspiece.moves;
    // make a nice new array with both bishop and rook moves
    chesspiece.moves = tempMoves.concat(tempMoves2);
}
function getKingMoves(chesspiece, boardstate) {
    var row = chesspiece.row;
    var column = chesspiece.column;
    var counter = 0;

    //helper
    var leftHelp = 0;
    var rightHelp = 0;
    var topHelp = 0;
    var bottomHelp = 0;
    var leftTopHelp = 0;
    var rightTopHelp = 0;
    var leftBottomHelp = 0;
    var rightBottomHelp = 0;

    //initially checking where our chesspiece is placed
    //if placed at a edge of our Field do:

    //top edge
    if (row == 0) {
        topHelp = 1;
    }
    //bottom edge
    if (row == 7) {
        bottomHelp = 1;
    }
    //left edge
    if (column == 0) {
        leftHelp = 1;
    }
    //right edge
    if (column == 7) {
        rightHelp = 1;
    }
    //leftTop edge
    if (column == 0 || row == 0) {
        leftTopHelp = 1;
    }
    //rightTop edge
    if (column == 7 || row == 0) {
        rightTopHelp = 1;
    }
    //leftBottom edge
    if (column == 0 || row == 7) {
        leftBottomHelp = 1;
    }
    //rightBottom edge
    if (column == 7 || row == 7) {
        rightBottomHelp = 1;
    }

    //logic copied from bishop and rook but slightly adjusted

    //left
    //check if its free space
    if (leftHelp == 0 && boardstate[row][column - 1] == "") {
        chesspiece.moves[counter] = [row, column - 1];
        counter++;
    }
    // check if Piece on the Board is an enemy
    else if (
        leftHelp == 0 &&
        boardstate[row][column - 1].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row, column - 1];
        counter++;
    }
    //right
    //check if its free Space
    if (rightHelp == 0 && boardstate[row][column + 1] == "") {
        chesspiece.moves[counter] = [row, column + 1];
        counter++;
    }
    //check if Piece on the board is an enemy
    else if (
        rightHelp == 0 &&
        boardstate[row][column + 1].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row, column + 1];
        counter++;
    }
    //top
    //check if its free Space
    if (topHelp == 0 && boardstate[row - 1][column] == "") {
        chesspiece.moves[counter] = [row - 1, column];
        counter++;
    }
    //check if Piece on the board is an enemy
    else if (
        topHelp == 0 &&
        boardstate[row - 1][column].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row - 1, column];
        counter++;
    }
    //bottom
    //check if its free Space
    if (bottomHelp == 0 && boardstate[row + 1][column] == "") {
        chesspiece.moves[counter] = [row + 1, column];
        counter++;
    }
    //check if Piece on the board is an enemy
    else if (
        bottomHelp == 0 &&
        boardstate[row + 1][column].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row + 1, column];
        counter++;
    }
    //leftTop
    //check if its free space
    if (leftTopHelp == 0 && boardstate[row - 1][column - 1] == "") {
        chesspiece.moves[counter] = [row - 1, column - 1];
        counter++;
    }
    // check if Piece on the Board is an enemy
    else if (
        leftTopHelp == 0 &&
        boardstate[row - 1][column - 1].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row - 1, column - 1];
        counter++;
    }
    //rightTop
    if (rightTopHelp == 0 && boardstate[row - 1][column + 1] == "") {
        chesspiece.moves[counter] = [row - 1, column + 1];
        counter++;
    }
    // check if Piece on the Board is an enemy
    else if (
        rightTopHelp == 0 &&
        boardstate[row - 1][column + 1].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row - 1, column + 1];
        counter++;
    }
    //leftBottom
    if (leftBottomHelp == 0 && boardstate[row + 1][column - 1] == "") {
        chesspiece.moves[counter] = [row + 1, column - 1];
        counter++;
    }
    // check if Piece on the Board is an enemy
    else if (
        leftBottomHelp == 0 &&
        boardstate[row + 1][column - 1].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row + 1, column - 1];
        counter++;
    }
    //rightBottom
    if (rightBottomHelp == 0 && boardstate[row + 1][column + 1] == "") {
        chesspiece.moves[counter] = [row + 1, column + 1];
        counter++;
    }
    // check if Piece on the Board is an enemy
    else if (
        rightBottomHelp == 0 &&
        boardstate[row + 1][column + 1].color != chesspiece.color
    ) {
        chesspiece.moves[counter] = [row + 1, column + 1];
        counter++;
    }
}
