/******************************************************************************
 FILE: finstmt-positionMatrix.as
 AUTHOR: Rebecca Marcil
 DATE: August 22, 2002
 VERSION: 1.0
 DESCRIPTION: Placed on the _root timeline of finstmt.fla. Handles the positions 
 			  of the balls in debits and credits.																	   
******************************************************************************/

//----------------------------------------------------
// Function: CreatePositionArray
// Description: Create two-D array storing (x,y) positions that the ball will 
// 				start falling from, and initialize the array with predetermined values.
// Output: Return a 2D array.
//----------------------------------------------------
function CreatePositionArray() {
	var positionArray = new Array(_G_NUMOFROWS);

	// store starting positions
	for (var i = 0; i < _G_NUMOFCOLUMNS + 1; i++) {
		positionArray[i] = new Array(_G_NUMOFCOLUMNS);
	}
	for (i = 0; i < _G_NUMOFROWS + 1; i++) {
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
	positionArray[1][0]= { x: 25.8, y: 21.6, empty: false }	
	positionArray[1][1]= { x: 72.3, y: 23.6, empty: false }
	positionArray[1][2]= { x: 120.5, y: 23.3, empty: false }
	positionArray[1][3]= { x: 167.9, y: 24.4, empty: false }	
	positionArray[1][4]= { x: 215.3, y: 22.6, empty: false }	
	
	positionArray[2][0]= { x: 25.8, y: 66.8, empty: false }	
	positionArray[2][1]= { x: 72.3, y: 68.8, empty: false }
	positionArray[2][2]= { x: 120.5, y: 68.5, empty: false }
	positionArray[2][3]= { x: 167.9, y: 69.6, empty: false }	
	positionArray[2][4]= { x: 215.3, y: 67.8, empty: false }	

	positionArray[3][0]= { x: 25.8, y: 112.0, empty: false }	
	positionArray[3][1]= { x: 72.3, y: 114.0, empty: false }
	positionArray[3][2]= { x: 120.5, y: 113.7, empty: false }
	positionArray[3][3]= { x: 167.9, y: 114.8, empty: false }	
	positionArray[3][4]= { x: 215.3, y: 113.0, empty: false }	

	positionArray[4][0]= { x: 25.8, y: 157.2, empty: false }	
	positionArray[4][1]= { x: 72.3, y: 159.2, empty: false }
	positionArray[4][2]= { x: 120.5, y: 158.9, empty: false }
	positionArray[4][3]= { x: 167.9, y: 160.0, empty: false }	
	positionArray[4][4]= { x: 215.3, y: 158.2, empty: false }	

	// the three positions where empty=true is where the target resides
	positionArray[5][0]= { x: 25.8, y: 216.3, empty: true }
	positionArray[5][1]= { x: 72.3, y: 216.3, empty: true }
	positionArray[5][2]= { x: 120.5, y: 216.3, empty: true }
	positionArray[5][3]= { x: 167.9, y: 216.3, empty: true }
	positionArray[5][4]= { x: 215.3, y: 216.3, empty: true }

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
	// reset for the targets
	_G_positionMatrix[5][0].empty = true;	
	_G_positionMatrix[5][1].empty = true;
	_G_positionMatrix[5][2].empty = true;
	_G_positionMatrix[5][3].empty = true;
	_G_positionMatrix[5][4].empty = true;	
}