
/******************************************************************************
 FILE: scores.as
 AUTHOR: Rebecca Marcil
 DATE: August 28, 2002
 VERSION: 1.0
 DESCRIPTION: This file stores all the scores information, and is used in the
 			  _root timeline of drcr.fla and finstmt.fla.
******************************************************************************/
//----------------------------------------------------
// global variables used by the functions in this file
//----------------------------------------------------
var _M_DrCrLvl1MaxScore;
var _M_DrCrLvl2MaxScore;
var _M_DrCrLvl3MaxScore;
var _M_DrCrLvl4MaxScore;
var _M_FinStmtLvl1MaxScore;
var _M_FinStmtLvl2MaxScore;
var _M_FinStmtLvl3MaxScore;
var _M_FinStmtLvl4MaxScore;

//----------------------------------------------------
// Function: CreateScoreArray
// Description: Creates the array that stores the scores increments for each level.
// Input: none
// Post-Condition: Returns the array of scores.
//----------------------------------------------------
function CreateScoreArray() {

	var scoreArray = new Array(_G_MAXGAMELVL);
	var score = 2;

	for (var i = 0; i < _G_MAXGAMELVL; i++) {
		scoreArray[i] = score;
		score += 2;
	}
	return scoreArray;
}
//----------------------------------------------------
// Function: CalculateMaxScore
// Description: Calculate the scores that the user need to achieve at each level
// 				in order to go on to the next level.
// Pre-Condition: There must be 4 levels to the game.
//----------------------------------------------------
function CalculateMaxScore() {
    //calculating max score for debits and credits
	//trace ("Calculating max score");
	for (var i = 1; i < 5; i++) {
		if (_root["_G_LVL" + i + "DRCRTOTALTOPICS"] < 25) {
		   _root["_M_DrCrLvl" + i + "MaxScore"] = 25 * _G_scoreArray[i - 1];
		}
		else if (_root["_G_LVL" + i + "DRCRTOTALTOPICS"] < 50) {
		   _root["_M_DrCrLvl" + i + "MaxScore"] = 50 * _G_scoreArray[i - 1];
		}
		else if (_root["_G_LVL" + i + "DRCRTOTALTOPICS"] < 75) {
		   _root["_M_DrCrLvl" + i + "MaxScore"] = 50 * _G_scoreArray[i - 1];
		}
		else {
		   _root["_M_DrCrLvl" + i + "MaxScore"] =  Math.floor(0.6 * _root["_G_LVL" + i + "DRCRTOTALTOPICS"]) * _G_scoreArray[i - 1];
		}
	}
	for (var i = 1; i < 5; i++) {
		//trace ("lvli: " + _root["_G_LVL" + i + "FINSTMTTOTALTOPICS"]);
		if (_root["_G_LVL" + i + "FINSTMTTOTALTOPICS"] < 25) {
		   _root["_M_FinStmtLvl" + i + "MaxScore"] = 25 * _G_scoreArray[i - 1];
		}
		else if (_root["_G_LVL" + i + "FINSTMTTOTALTOPICS"] < 50) {
		   _root["_M_FinStmtLvl" + i + "MaxScore"] = 50 * _G_scoreArray[i - 1];
		}
		else if (_root["_G_LVL" + i + "FINSTMTTOTALTOPICS"] < 75) {
		   _root["_M_FinStmtLvl" + i + "MaxScore"] = 50 * _G_scoreArray[i - 1];
		}
		else {
		   _root["_M_FinStmtLvl" + i + "MaxScore"] =  Math.floor(0.6 * _root["_G_LVL" + i + "FINSTMTTOTALTOPICS"]) * _G_scoreArray[i - 1];
		}
	}

	//trace ("drcr1: " + _M_DrCrLvl1MaxScore + " drcr2: " + _M_DrCrLvl2MaxScore + " drcr3: " + _M_DrCrLvl3MaxScore + " drcr4: " + _M_DrCrLvl4MaxScore);
	//trace ("finstmt1: " + _M_FinStmtLvl1MaxScore + " finstmt2: " + _M_FinStmtLvl2MaxScore + " finstmt3: " + _M_FinStmtLvl3MaxScore + " finstmt4: " + _M_FinStmtLvl4MaxScore);
}
//----------------------------------------------------
// Function: GetMaxScore
// Description: Returns the minimum score you need to achieve before proceeding
// 				to the next level. The "0.6" is the 60% of total number of account
//				names that the user needs to get correct in order to proceed to
//				go to the next level.
// Input: gameLvl: integer; current game level
// Pre-Condition: _G_scoreArray must be created already; _G_scoreArray must have
// 				  the same number of levels as being referred to.
//----------------------------------------------------
function GetMaxScore(gameLvl) {
    //trace ("lvl: " + gameLvl);
	//trace ("topic in lvl: " + _G_topic);
    if ( (_G_topic == "DrCr") && (_G_newGame == true) ) {
	   if (gameLvl == 1) { return _M_DrCrLvl1MaxScore; }
	   else if (gameLvl == 2) { return _M_DrCrLvl2MaxScore; }
	   else if (gameLvl == 3) { return _M_DrCrLvl3MaxScore; }
	   else if (gameLvl == 4) { return _M_DrCrLvl4MaxScore; }
	   else { return 0; }

	}
	else if (_G_topic == "DrCr") {
	   if (gameLvl == 1) { return _M_DrCrLvl1MaxScore; }
	   else if (gameLvl == 2) { return _M_DrCrLvl1MaxScore + _M_DrCrLvl2MaxScore; }
	   else if (gameLvl == 3) { return _M_DrCrLvl1MaxScore + _M_DrCrLvl2MaxScore + _M_DrCrLvl3MaxScore; }
	   else if (gameLvl == 4) { return _M_DrCrLvl1MaxScore + _M_DrCrLvl2MaxScore + _M_DrCrLvl3MaxScore + _M_DrCrLvl3MaxScore; }
   	   else { return 0; }
	}
    else if ( (_G_topic == "FinStmt") && (_G_newGame == true) ) {
	   if (gameLvl == 1) { return _M_FinStmtLvl1MaxScore; }
	   else if (gameLvl == 2) { return _M_FinStmtLvl2MaxScore; }
	   else if (gameLvl == 3) { return _M_FinStmtLvl3MaxScore; }
	   else if (gameLvl == 4) { return _M_FinStmtLvl4MaxScore; }
	   else { return 0; }
	}
	else if (_G_topic == "FinStmt") {
	   if (gameLvl == 1) { return _M_FinStmtLvl1MaxScore; }
	   else if (gameLvl == 2) { return _M_FinStmtLvl1MaxScore + _M_FinStmtLvl2MaxScore; }
	   else if (gameLvl == 3) { return _M_FinStmtLvl1MaxScore + _M_FinStmtLvl2MaxScore + _M_FinStmtLvl3MaxScore; }
	   else if (gameLvl == 4) { return _M_FinStmtLvl1MaxScore + _M_FinStmtLvl2MaxScore + _M_FinStmtLvl3MaxScore + _M_FinStmtLvl4MaxScore; }
	   else { return 0; }
	}
}
//----------------------------------------------------
// Function: ChangeScoreBar
// Description: Update the score bar
// Input: none
//----------------------------------------------------
function ChangeScoreBar() {
	var width;

	//trace ("current max: " + _G_currentMaxScore + " previous max: " + _G_previousMaxScore);

	// calculate the width of the bar
	if ((_G_levelNumber == 1) || (_G_newGame == true) ){
	   width = Math.floor( _G_scoreCount/_G_currentMaxScore * _G_MAXSCOREBARPIXELS );
	   _G_newGame = false;
	   //trace ("level 1 width: " + width);
	}
	else {
	   width = Math.floor( (_G_scoreCount - _G_previousMaxScore)/(_G_currentMaxScore - _G_previousMaxScore) * _G_MAXSCOREBARPIXELS );
	   //trace ("width in other levels: " + width);
	}

	// if the width > 0, then make the score bar movieclip's width = width.
	if ( (width < _G_MAXSCOREBARPIXELS ) && (width >= 0) ){
	   scoreBar._width = width;
	}
	else if (width < 0) {
	   // if the width is less than zero, make the score bar movieclip's width = 0.
	   scoreBar._width = 0;
	}
	else {
	   //trace ("level number: " + _G_levelNumber);
	   if (_G_levelNumber == 4) {
		 	RemoveBallMC();
		 	gotoAndStop("Game Over");
			gameOverTxt.gotoAndStop("done");
	   		timeDisplay.gotoAndPlay ("Stop");
	   }
	   else {
	   		// it's a new level
	   		RemoveBallMC();
	   		_G_numOfMC = _G_NUMBEROFMC;
	  		scoreBar._width = _G_MAXSCOREBARPIXELS;
	   		_G_levelNumber++;
	   		_G_previousMaxScore = GetMaxScore(_G_levelNumber - 1);
	   		_G_currentMaxScore = GetMaxScore(_G_levelNumber);
	   		_G_depth = 0;
	   		_G_ballIndex = 0;
	   		_G_starter = 0;
	   		ClearFallingArray();
	   		ClearPositionMatrix();
	   		_G_newLevel = true;
	   		scoreBar._width = 0;
			if (_G_levelNumber < 4) { gotoAndPlay("Start");	}
			else { gotoAndPlay("Level 4"); }
	   }
	}
	//trace ("width: " + scoreBar._width + " maxscore: " + GetMaxScore(_G_levelNumber));
}
