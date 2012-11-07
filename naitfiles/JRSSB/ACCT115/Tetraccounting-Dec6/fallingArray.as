/******************************************************************************
 FILE: fallingArray.as
 AUTHOR: Rebecca Marcil
 DATE: August 19, 2002
 VERSION: 1.0  
 DESCRIPTION: Contains the functions that handle the falling objects.
******************************************************************************/

//----------------------------------------------------
// Function: CreateFallingArray
// Description: Create the 1D array that will store the falling objects.
//----------------------------------------------------
function CreateFallingArray() {
	var fallingArray = new Array(2);

	for (var i = 0; i < 2; i++) {
		fallingArray[i] = new Object();
	}
	for (var i = 0; i < 2; i++) {
		fallingArray[i].num = "";
	}	
	return fallingArray;
}
//----------------------------------------------------
// Function: RemoveValFromFallingArray
// Description: check whether there is currently a ball falling or not
// Pre-Condition: _G_fallingArray has to be created already.
//----------------------------------------------------
function RemoveValFromFallingArray(MCNum) {

	if ( MCNum == _G_fallingArray[0].num) {
		_G_fallingArray[0].num = ""; 
	}
	else if (MCNum == _G_fallingArray[1].num) { 
		_G_fallingArray[1].num = ""; 
	}
}
//----------------------------------------------------
// Function: AddValToFallingArray
// Description: Check whether there is currently a ball falling or not
// Pre-Condition: _G_fallingArray has to be created already.
//----------------------------------------------------
function AddValToFallingArray(MCNum){
	trace ("adding number: " + MCNum + " [0]: "  + _G_fallingArray[0].num + " [1]: " + _G_fallingArray[1].num);
	if ( _G_fallingArray[0].num == "") { 
		_G_fallingArray[0].num = MCNum;	
	}
	else if (_G_fallingArray[1].num == "") { 
		_G_fallingArray[1].num = MCNum; 
	}
}
//----------------------------------------------------
// Function: ClearFallingArray
// Description: Reset the values in _G_fallingArray.
//----------------------------------------------------
function ClearFallingArray() {
	_G_fallingArray[0].num = "";		 
	_G_fallingArray[1].num = "";	
}