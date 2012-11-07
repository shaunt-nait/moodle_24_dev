/******************************************************************************
 FILE: drcr-positionMatrix.as
 AUTHOR: Rebecca Marcil
 DATE: August 28, 2002
 VERSION: 1.0  
 DESCRIPTION: Placed in _root timeline. Handles the positions of the balls in 
 			  debits and credits.
******************************************************************************/

//----------------------------------------------------
// Function: CreatePositionArray
// Description: Create two-D array storing (x,y) positions that the ball will 
// 				start falling from, and initialize the array with predetermined 
//				values.
//----------------------------------------------------
function CreatePositionArray() {
	var positionArray = new Array(_G_NUMOFROWS);

	for (var i = 0; i < _G_NUMOFCOLUMNS + 1; i++) {
		positionArray[i] = new Array(_G_NUMOFCOLUMNS);
	}
	for (i = 0; i < (_G_NUMOFROWS + 1); i++) {
		for (var j = 0; j < _G_NUMOFCOLUMNS + 1; j++){
			positionArray[i][j] = new Object();
		}
	}
	// all row 0 are starting positions where the ball falls.
	positionArray[0][0]= { x: 25.8, y: 0, empty: false }
	positionArray[0][1]= { x: 72.3, y: 0, empty: false }
	positionArray[0][2]= { x: 120.5, y: 0, empty: false }
	positionArray[0][3]= { x: 167.9, y: 0, empty: false }	
	positionArray[0][4]= { x: 215.3, y: 0, empty: false }

	// game over when any of the balls hit these positions
	positionArray[1][0]= { x: 25.8, y: 35.5, empty: false }	
	positionArray[1][1]= { x: 72.3, y: 32.8, empty: false }
	positionArray[1][2]= { x: 120.5, y: 39.4, empty: false }
	positionArray[1][3]= { x: 167.9, y: 32.4, empty: false }	
	positionArray[1][4]= { x: 215.3, y: 35.5, empty: false }	
	
	positionArray[2][0]= { x: 25.8, y: 80.7, empty: false }	
	positionArray[2][1]= { x: 72.3, y: 78.0, empty: false }
	positionArray[2][2]= { x: 120.5, y: 84.6, empty: false }
	positionArray[2][3]= { x: 167.9, y: 77.6, empty: false }	
	positionArray[2][4]= { x: 215.3, y: 80.7, empty: false }	

	positionArray[3][0]= { x: 25.8, y: 125.9, empty: false }	
	positionArray[3][1]= { x: 72.3, y: 123.2, empty: false }
	positionArray[3][2]= { x: 120.5, y: 130.1, empty: false }
	positionArray[3][3]= { x: 167.9, y: 122.8, empty: false }	
	positionArray[3][4]= { x: 215.3, y: 125.9, empty: false }	

	positionArray[4][0]= { x: 25.8, y: 171.1, empty: false }	
	positionArray[4][1]= { x: 72.3, y: 168.4, empty: false }
	positionArray[4][2]= { x: 120.5, y: 175.3, empty: false }
	positionArray[4][3]= { x: 167.9, y: 168.0, empty: false }	
	positionArray[4][4]= { x: 215.3, y: 171.1, empty: false }	

	// the three positions where empty=true is where the target resides
	positionArray[5][0]= { x: 25.8, y: 216.3, empty: false }
	positionArray[5][1]= { x: 72.3, y: 216.3, empty: true }
	positionArray[5][2]= { x: 120.5, y: 216.3, empty: true }
	positionArray[5][3]= { x: 167.9, y: 216.3, empty: true }
	positionArray[5][4]= { x: 215.3, y: 216.3, empty: false }

	return positionArray;
}
//----------------------------------------------------
// Function: ClearPositionMatrix
// Description: Clear all the positions in the global position matrix.
//----------------------------------------------------
function ClearPositionMatrix() {
	for (var i = 0; i < (_G_NUMOFROWS + 1); i++) {
		for (var j = 0; j < _G_NUMOFCOLUMNS + 1; j++){
			_G_positionMatrix[i][j].empty = false;
		}
	}
	_G_positionMatrix[5][1].empty = true;
	_G_positionMatrix[5][2].empty = true;
	_G_positionMatrix[5][3].empty = true;
}