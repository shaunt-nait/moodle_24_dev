/******************************************************************************
 FILE: finstmt-scores.as
 AUTHOR: Rebecca Marcil
 DATE: Nov. 1, 2002
 VERSION: 1.1
 DESCRIPTION: This file stores all the scores information, and is used in the
 			  _root timeline of finstmt.fla only for the moment.
******************************************************************************/
//----------------------------------------------------
// global variables used by the functions in this file
//----------------------------------------------------
var _M_FinStmtLvl1MaxAnswers;
var _M_FinStmtLvl2MaxAnswers;
var _M_FinStmtLvl3MaxAnswers;
var _M_FinStmtLvl4MaxAnswers;

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
// Function: CalculateMaxAnswers
// Description: Calculate the answers that the user need to achieve at each level
// 		in order to go on to the next level.
// Pre-Condition: There must be 4 levels to the game.
//----------------------------------------------------
function CalculateMaxAnswers() {
    //calculating max answers for debits and credits
	//trace ("Calculating max score");
	for (var i = 1; i < 5; i++) {
		if (_root["_G_LVL" + i + "DRCRTOTALTOPICS"] <= 80) {
		   _root["_M_DrCrLvl" + i + "MaxAnswers"] = 50;
		}
		else {
		   _root["_M_DrCrLvl" + i + "MaxScore"] =  Math.floor(0.6 * _root["_G_LVL" + i + "DRCRTOTALTOPICS"]);
		}
	}
	for (var i = 1; i < 5; i++) {
		//trace ("lvli: " + _root["_G_LVL" + i + "FINSTMTTOTALTOPICS"]);
		if (_root["_G_LVL" + i + "FINSTMTTOTALTOPICS"] < 80) {
		   _root["_M_FinStmtLvl" + i + "MaxAnswers"] = 50;
		}
		else {
		   _root["_M_FinStmtLvl" + i + "MaxAnswers"] =  Math.floor(0.6 * _root["_G_LVL" + i + "FINSTMTTOTALTOPICS"]);
		}
	}
	//trace ("drcr1: " + _M_DrCrLvl1MaxAnswers + " drcr2: " + _M_DrCrLvl2MaxAnswers + " drcr3: " + _M_DrCrLvl3MaxAnswers + " drcr4: " + _M_DrCrLvl4MaxAnswers);
	//trace ("finstmt1: " + _M_FinStmtLvl1MaxAnswers + " finstmt2: " + _M_FinStmtLvl2MaxAnswers + " finstmt3: " + _M_FinStmtLvl3MaxAnswers + " finstmt4: " + _M_FinStmtLvl4MaxAnswers);
}
//----------------------------------------------------
// Function: GetMaxAnswers
// Description: Returns the minimum number of answers you need to achieve before proceeding
// 		to the next level. The "0.6" is the 60% of total number of account
//		names that the user needs to get correct in order to proceed to
//		go to the next level.
// Input: gameLvl: integer; current game level
// Pre-Condition: _G_scoreArray must be created already; _G_scoreArray must have
// 				  the same number of levels as being referred to.
//----------------------------------------------------
function GetMaxAnswers(gameLvl) {

	   if (gameLvl == 1) { return _M_FinStmtLvl1MaxAnswers; }
	   else if (gameLvl == 2) { return _M_FinStmtLvl2MaxAnswers; }
	   else if (gameLvl == 3) { return _M_FinStmtLvl3MaxAnswers; }
	   else if (gameLvl == 4) { return _M_FinStmtLvl4MaxAnswers; }
	   else { return 0; }
/*	}
	else if (_G_topic == "FinStmt") {
	   if (gameLvl == 1) { return _M_FinStmtLvl1MaxAnswers; }
	   else if (gameLvl == _M_FinStmtLvl2MaxAnswers) {
		   return 5;
	   		//+ _M_FinStmtLvl2MaxAnswers; }
		}
	   else if (gameLvl == 3) {
		   return _M_FinStmtLvl3MaxAnswers;
		   //+ _M_FinStmtLvl2MaxAnswers + _M_FinStmtLvl3MaxAnswers; }
	   }
	   else if (gameLvl == 4) {
		   return _M_FinStmtLvl4MaxAnswers;
		   //+ _M_FinStmtLvl2MaxAnswers + _M_FinStmtLvl3MaxAnswers + _M_FinStmtLvl4MaxAnswers; }
	   }
	   else { return 0; }
	}*/
}
//----------------------------------------------------
// Function: ChangeScoreBar
// Description: Update the score bar for stage 1 of finstmt.
//----------------------------------------------------
function ChangeScoreBar() {
	var width;
	var wrongAnswers = _G_totalWrongAnswers/2;

	trace ("correct: " + _G_totalCorrectAnswers + " wrong: " + _G_totalWrongAnswers);

	width = Math.floor( (_G_totalCorrectAnswers - wrongAnswers)/GetMaxAnswers(_G_levelNumber) * _G_MAXSCOREBARPIXELS );

	trace("width: " + width);

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
		 	scoreBar._width = _G_MAXSCOREBARPIXELS;
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
	   		_G_totalCorrectAnswers = 0
	   		_G_totalWrongAnswers = 0;

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
	trace ("width: " + scoreBar._width + " maxscore: " + GetMaxScore(_G_levelNumber));
}
//----------------------------------------------------
// Function: Stage2ChangeScoreBar
// Description: Update the score bar for stage 2 of finstmt.
//----------------------------------------------------
function Stage2ChangeScoreBar() {
	var width;
	var wrongAnswers = _G_totalWrongAnswers/2;

	trace ("correct: " + _G_totalCorrectAnswers + " wrong: " + _G_totalWrongAnswers);

	width = Math.floor( (_G_totalCorrectAnswers - wrongAnswers)/GetMaxAnswers(_G_levelNumber) * _G_MAXSCOREBARPIXELS );

	trace("width: " + width);

	// if the width > 0, then make the score bar movieclip's width = width.
	if ( (width < _G_MAXSCOREBARPIXELS ) && (width >= 0) ){
	   scoreBar._width = width;
	}
	else if (width < 0) {
	   // if the width is less than zero, make the score bar movieclip's width = 0.
	   scoreBar._width = 0;
	}
}