/******************************************************************************
 FILE: speed.as
 AUTHOR: Rebecca Marcil
 DATE: August 28, 2002
 VERSION: 1.0
 DESCRIPTION: This file is placed in the _root timeline of drcr.fla and 
 			  finstmt.fla.																		   
******************************************************************************/

//----------------------------------------------------
// Function: CreateSpeedArray
// Description: Change the rate that the ball will be dropping
// Pre-Condition: There has to be five speed levels. 
//----------------------------------------------------
function CreateSpeedArray() {

	var speedArray = new Array( _G_MAXSPEEDLVL );
	speedArray[0] = 3; 
	speedArray[1] = 6; 
	speedArray[2] = 10; 
	speedArray[3] = 14; 
	speedArray[4] = 19; 				
	return speedArray;	
}
//----------------------------------------------------
// Function: ChangeSpeed
// Description: Change the rate that the ball will be dropping
// Input: speedLvl - a number, from 1 to 5
// Output: dy - the _y rate that the ball will be dropping
//----------------------------------------------------
function ChangeSpeed(speedLvl) {
	var dy;
	var speedArray = CreateSpeedArray(_G_MAXSPEEDLVL);

	if ( (speedLvl <= _G_MAXSPEEDLVL) && (speedLvl > 0) ){
	    dy = speedArray[speedLvl - 1];		
	}
	else if (speedLvl <= 0) {
		dy = speedArray[0];
	}
	else {
		dy = speedArray[_G_MAXSPEEDLVL - 1];
	}		
	return dy;			
}