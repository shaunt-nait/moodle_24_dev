/******************************************************************************
 FILE: finstmt-ball-functions.as
 AUTHOR: Rebecca Marcil
 DATE: Nov.1, 2002
 VERSION: 1.1
 DESCRIPTION: Placed on the _root timeline of finstmt.fla. This file holds all the
 			  functions that are used by _root["ball"].
******************************************************************************/

//----------------------------------------------------
// Function: MoveThis
// Description: Move the ball
// Input: MC: movieclip;
//----------------------------------------------------
function MoveThis(MC){
   MC._x = _xmouse;
   MC._y = _ymouse;
}
//----------------------------------------------------
// Function: ResetThis
// Description: Reset the x and y position of the ball
// Input: MC: movieclip;
//----------------------------------------------------
function ResetThis(MC) {
	MC._x = MC.oldX;
	MC._y = MC.oldY;
}
//----------------------------------------------------
// Function: DuplicateBalls
// Description: duplicate all the balls
// Input: MC: movieclip;
//----------------------------------------------------
function DuplicateBalls(MC) {
	var txtArray;
	if (_G_levelNumber == 1) {
		txtArray = _G_txtArray1;
		finStmtTotalTopics = _G_LVL1FINSTMTTOTALTOPICS;
	}
	else if (_G_levelNumber == 2) {
		txtArray = _G_txtArray2;
		finStmtTotalTopics = _G_LVL2FINSTMTTOTALTOPICS;
	}
	else if (_G_levelNumber == 3) {
		txtArray = _G_txtArray3;
		finStmtTotalTopics = _G_LVL3FINSTMTTOTALTOPICS;
	}
	else if (_G_levelNumber == 4) {
		txtArray = _G_txtArray4;
		finStmtTotalTopics = _G_LVL4FINSTMTTOTALTOPICS;
	}
	var ballTrack = 0, ranNum, ranBonus;

	if  (_G_ballIndex >= _G_numOfMC) { _G_numOfMC += _G_NUMBEROFMC;}

	//trace("numOfMC in duplication: " + _G_numOfMC);
	for ( _G_ballIndex ; _G_ballIndex < _G_numOfMC; _G_ballIndex++) {

		duplicateMovieClip(MC, "ball" + _G_ballIndex, _G_depth++);

		ranNum = random(_G_NUMOFCOLUMNS);
		_root["ball" + _G_ballIndex]._x = _G_positionMatrix[0][ranNum].x;
		_root["ball" + _G_ballIndex]._y = _G_positionMatrix[0][ranNum].y;
		_root["ball" + _G_ballIndex].column = ranNum;
		_root["ball" + _G_ballIndex].rowNumLanded = 0;

		// recalculate ranNum; if eq 0, non-bonus; if eq 1, bonus ball
		ranNum = random(2);
		if (ranNum == 0) {
			_root["ball" + _G_ballIndex].gotoAndStop(_G_levelNumber);
			_root["ball" + _G_ballIndex].bonus = false;
			_root["ball" + _G_ballIndex].ballShape = _G_levelNumber;
			ballTrack++;
		}
		else {
			// at least 16 blue balls must be generated before a "bonus" ball is generated
			if (ballTrack < 15) {
			   _root["ball" + _G_ballIndex].gotoAndStop(_G_levelNumber);
			   _root["ball" + _G_ballIndex].bonus = false;
			   _root["ball" + _G_ballIndex].ballShape = _G_levelNumber;
			   ballTrack++;
			}
			else {
				if ( (ranNum == 0) || (ranNum == 1) || (ranNum == 2) || (ranNum == 3) ){
			 	   ranBonus = random(4) + 5;
			 	   _root["ball" + _G_ballIndex].gotoAndStop(ranBonus);
				   _root["ball" + _G_ballIndex].ballShape = ranBonus;
				 }
				 else {
			 	   _root["ball" + _G_ballIndex].gotoAndStop(ranNum + 1);
				   _root["ball" + _G_ballIndex].ballShape = ranNum + 1;
				 }
				 _root["ball" + i].bonus = true;
		 		 ballTrack = 0;
			}
		}
		ranNum = random(finStmtTotalTopics);

		_root["ball" + _G_ballIndex]._visible = false;	  // don't reveal the ball yet
		_root["ball" + _G_ballIndex].pause = false;
		_root["ball" + _G_ballIndex].num = _G_ballIndex;
		_root["ball" + _G_ballIndex].falling = true;
		_root["ball" + _G_ballIndex].acctName = txtArray[ranNum]["acctName"];
		_root["ball" + _G_ballIndex].answer1 = txtArray[ranNum]["answer1"];
		_root["ball" + _G_ballIndex].answer2 = txtArray[ranNum]["answer2"];
		_root["ball" + _G_ballIndex].subAnswer = txtArray[ranNum]["subAnswer"];
		trace("subanswers: " + _root["ball" + _G_ballIndex].subAnswer);
	}
}
//----------------------------------------------------
// Function: RefreshPositions
// Description:  Refreshes the positions of the balls on the screen, especially if the gamer
// 				 has pulled a ball from the stack and placed it in the target.
// Input: MC: movieclip;
//----------------------------------------------------
function RefreshPositions(MC) {
	_G_positionMatrix[_root[MC].rowNumLanded][_root[MC].column].empty = false;

	for (var i = 0; i <= _G_starter; i++) {
   	   if  ( (_root["ball" + i].column == _root[MC].column) && (_root["ball" + i].rowNumLanded == _root[MC].rowNumLanded - 1) ){
		  	 _root["ball" + i].rowNumLanded++;
			 _root["ball" + i]._y = _G_positionMatrix[_root["ball" + i].rowNumLanded][_root[MC].column].y;
			 _G_positionMatrix[_root["ball" + i].rowNumLanded][_root[MC].column].empty = true;
			 _G_positionMatrix[_root["ball" + i].rowNumLanded - 1][_root[MC].column].empty = false;
			 _root[MC].rowNumLanded--;
	   }
    }
}
//----------------------------------------------------
// Function: CheckPosition
// Description: Make sure the ball lands in the correct position.
// Input: MC: movieclip;
//----------------------------------------------------
function CheckPosition(MC) {
	var gameOver = false;

	for (var row = 1; row < _G_NUMOFROWS; row++) {
		if (_G_positionMatrix[row][_root[MC].column].empty == true) { break; }
	}

	if (row == 1) { return true; }
	else { row--; }

	if (_root[MC]._y > _G_positionMatrix[row][_root[MC].column].y) {
	   if (_root[MC].bonus == true) {
	   	  _root[MC]._y = _G_positionMatrix[row][_root[MC].column].y;
		  _root[MC].falling = false;
		  RemoveValFromFallingArray(_root[MC].num);

		  if (_root[MC].ballShape == 5) { _root[MC].gotoAndPlay("heart-fade"); }
		  else if (_root[MC].ballShape == 6) { _root[MC].gotoAndPlay("club-fade"); }
		  else if (_root[MC].ballShape == 7) { _root[MC].gotoAndPlay("diamond-fade");	}
		  else if (_root[MC].ballShape == 8) { _root[MC].gotoAndPlay("spade-fade"); }

		  RefreshPositions(MC);
		  CheckBallFalling();
	   }
	   else {
	   	   _root[MC]._y = _G_positionMatrix[row][_root[MC].column].y;
	   	   _G_positionMatrix[row][_root[MC].column].empty = true;
	   	   _root[MC].rowNumLanded = row;
		   _root[MC].falling = false;

		   RemoveValFromFallingArray(_root[MC].num);
	   	   CheckBallFalling();
	   }
	}
	return gameOver;
}
//----------------------------------------------------
// Function: CheckBallFalling
// Description: Check whether there is currently a ball falling or not. If there
// 				is not, then drop another ball.
//----------------------------------------------------
function CheckBallFalling() {
	if ( (_root["ball" + _G_starter].falling == true) && (_root["ball" + _G_starter].dragging == false) ) {
	   return;
	}
	else {
		 for (var i = 0; i < 2; i++) {
		 	if (_G_fallingArray[i].num != "") {
			   if ( (_root["ball" + _G_fallingArray[i].num].falling == true) && (_root["ball" + _G_fallingArray[i].num].dragging == false) ) {
			 	  return;
			   }
			}
		 }
	}
	_G_starter++;
	AddValToFallingArray(_G_starter);

	if ( (_G_starter >= _G_numOfMC) && (_G_levelNumber < 4) ) {
		gotoAndPlay("Start");
	}
	else if ( (_G_starter >= _G_numOfMC) && (_G_levelNumber == 4) ) {
		gotoAndPlay("Level 4");
	}
	else if (_G_levelNumber > 4) {
	   gameOverTxt.gotoAndStop("done");
	   gotoAndStop("Game Over");
	   timeDisplay.gotoAndPlay ("Stop");
	   RemoveBallMC();
	}
}
//----------------------------------------------------
// Function: RemoveBallMC
// Description: Remove all the duplicated ball movies that have been created.
//----------------------------------------------------
function RemoveBallMC(){
	for (var i = 0; i < _G_numOfMC; i++) {
		   _root["ball" + i].removeMovieClip();
	}
}
//----------------------------------------------------
// Function: PauseBallMC
// Description: Pause all the duplicated ball movies.
//----------------------------------------------------
function PauseBallMC() {
	for (var i = 0; i <= _G_starter; i++) {
		this["ball" + i].pause = true;
	}
}