/******************************************************************************
 FILE: drcr-ball-functions.as
 AUTHOR: Rebecca Marcil
 DATE: Nov.1, 2002
 VERSION: 1.1
 DESCRIPTION: Placed in the _root.ball timeline and _root["MC" + i] of drcr.fla
 			  and finstmt.fla. The following functions are used by _root.ball
			  when once it has been dropped into the target and determined correct
			  or not correct.
******************************************************************************/

//----------------------------------------------------
// Function: GetTargetName
// Description: Get the name of the target/hole given the answer and level number
// Input: answer - string
//		levelNumber - integer
// Output: name of target - a string
//----------------------------------------------------
function GetTargetName(answer, levelNumber) {
   if (answer == "Balance Sheet") {
   	  return "balance";
   }
   else if (answer == "Income Statement") {
      return "income";
   }
   else if (answer == "Statement of Owner's Equity") {
   	 return "equity";
   }
   else if (answer == "Statement of Retained Earnings") {
   	 if (levelNumber == 4) {
	 	return "earnings";
	 }
   	 else {
	    return "equity";
	 }
   }
}
//----------------------------------------------------
// Function: GetTargetArrowName
// Description: get the name of the arrow movie clip that displays on a target/hole
//		given an answer and level number.
// Input: answer - string
//		levelNumber - integer
// Output: name of arrow MC - string
//----------------------------------------------------
function GetTargetArrowName(answer, levelNumber) {
   if (answer == "Balance Sheet") {
   	  return "balanceTargetArrow";
   }
   else if (answer == "Income Statement") {
      return "incomeTargetArrow";
   }
   else if (answer == "Statement of Owner's Equity") {
   	 return "equityTargetArrow";
   }
   else if (answer == "Statement of Retained Earnings") {
   	 if (levelNumber == 4) {
	 	return "earningsTargetArrow";
	 }
   	 else {
	    return "equityTargetArrow";
	 }
   }
}
//----------------------------------------------------
// Function: PlayRight
// Description: Update the score count, and change the score bar when a ball
// 				falls in the correct target.
// Input: targetDroppedInto - string, refers to a target name.
//		ballName - string, instance name of the ball
//		answerChecking - string, the answer for the account ball that just dropped into the target
// 		levelNumber - integer, level of game
// Output: _G_scoreCount and scoreBar are updated.
//----------------------------------------------------
function PlayRight(targetDroppedInto, ballName, answerChecking, levelNumber) {
   	var targetName;

   // checks the first answer to see if it is the answer we're looking for
   // play the target with the answer we're looking for
   if (_root[ballName].answer1 == answerChecking) {
   	  targetName = GetTargetName(answerChecking, levelNumber);
	  _root[targetName].gotoAndPlay("right");
	  if (targetName == targetDroppedInto) {
	  	  if (targetDroppedInto != "balance") {
			  _root[targetName + "Score"].scoreDiff = "+" + _root._G_scoreArray[levelNumber -1];
		  	  _root[targetName + "Score"].gotoAndPlay("right");
		  }
	  }
   }
   else if (_root[ballName].answer1 != " ") {
   	  // play the second target with the correct answer
      targetName = GetTargetName(_root[ballName].answer1, levelNumber);
	  _root[targetName].gotoAndPlay("right");

	  if (targetName == "balance") {
	  	 _root.balanceSubanswer.subanswer = _root[ballName].subAnswer;
		 _root.balanceSubanswer.gotoAndPlay("display");
	  }
   }
   // checks the second answer to see if it is the answer we're looking for
   // play the target with the answer we're looking for
   if (_root[ballName].answer2 == answerChecking) {
   	  targetName = GetTargetName(answerChecking, levelNumber);
	  _root[targetName].gotoAndPlay("right");
	  if (targetName == targetDroppedInto) {
	  	  if (targetDroppedInto != "balance") {
			  _root[targetName + "Score"].scoreDiff = "+" + _root._G_scoreArray[levelNumber -1];
		  	  _root[targetName + "Score"].gotoAndPlay("right");
		  }
	  }
   }
   else if (_root[ballName].answer2 != " ") {
      targetName = GetTargetName(_root[ballName].answer2, levelNumber);
	  _root[targetName].gotoAndPlay("right");

  	  if (targetName == "balance") {
	  	 _root.balanceSubanswer.subanswer = _root[ballName].subAnswer;
		 _root.balanceSubanswer.gotoAndPlay("display");
	  }
   }
   // update all this information if the target is not "balance"
   // otherwise, leave it alone because it will updated after it has gone through
   //	stage 2 of financial statements
   if (targetDroppedInto != "balance") {
	   _root._G_totalCorrectAnswers++;
   		//add to the score
   		_root._G_scoreCount += _root._G_scoreArray[levelNumber -1];
   		_root.ChangeScoreBar();
   }

}
//----------------------------------------------------
// Function: PlayWrong
// Description: Update the score count, and change the score bar when a ball
// 				falls in the wrong target.
// Input: targetDroppedInto - string, refers to a target name.
//		ballName - string, instance name of the ball
// 		levelNumber - integer, level of game
// Output: _G_scoreCount and scoreBar are updated.
//----------------------------------------------------
function PlayWrong(targetDroppedInto, ballName, levelNumber) {
   	var targetArrowName;

	MC._visible = false;
	_root[targetDroppedInto].gotoAndPlay("wrong");
	_root[targetDroppedInto + "Score"].scoreDiff = "-" + _root._G_scoreArray[levelNumber -1] / 2;
	_root[targetDroppedInto + "Score"].gotoAndPlay("wrong");

	// play the first target with the answer we're looking for
   if (_root[ballName].answer1 != " ") {
	  if (_root[ballName].answer1 == "Balance Sheet") {
	  	 _root.balanceSubanswer.subanswer = _root[ballName].subAnswer;
		 _root.balanceSubanswer.gotoAndPlay("display");
	  }
      targetArrowName = GetTargetArrowName(_root[ballName].answer1, levelNumber);
	  _root[targetArrowName].gotoAndPlay("show arrow");

   }
   // checks the second answer to see if it is the answer we're looking for
   // play the target with the answer we're looking for
   if (_root[ballName].answer2 != " ") {
	  if (_root[ballName].answer2 == "Balance Sheet") {
	  	 _root.balanceSubanswer.subanswer = _root[ballName].subAnswer;
		 _root.balanceSubanswer.gotoAndPlay("display");
	  }
      targetArrowName = GetTargetArrowName(_root[ballName].answer2, levelNumber);
	  _root[targetArrowName].gotoAndPlay("show arrow");
   }

	_root._G_totalWrongAnswers++;
   // reduce the score
	_root._G_scoreCount -= _root._G_scoreArray[levelNumber -1] / 2;
	_root.ChangeScoreBar();
}
//----------------------------------------------------
// Function: PlayBonusRight
// Description: Update the score count, and change the score bar when a bonus ball
// 				falls in the correct target.
// Input: targetDroppedInto - string, refers to a target name.
//		ballName - string, instance name of the ball
// 		answerChecking - string, answer of account ball
// Output: _G_scoreCount and scoreBar are updated.
//----------------------------------------------------
function PlayBonusRight(targetDroppedInto, ballName, answerChecking) {

	  // checks the first answer to see if it is the answer we're looking for
   // play the target with the answer we're looking for
   if (_root[ballName].answer1 == answerChecking) {
   	  targetName = GetTargetName(answerChecking, levelNumber);
	  _root[targetName].gotoAndPlay("bonus-right");
	  if (targetName == targetDroppedInto) {
	  	  if (targetDroppedInto != "balance") {
			  _root[targetName + "Score"].scoreDiff = "+" + _root._G_scoreArray[_root._G_levelNumber -1] * 2;
		  	  _root[targetName + "Score"].gotoAndPlay("bonus");
		  }
	  }
   }
   else if (_root[ballName].answer1 != " ") {
   	  // play the second target with the correct answer
      targetName = GetTargetName(_root[ballName].answer1, levelNumber);
	  _root[targetName].gotoAndPlay("right");

	  if (targetName == "balance") {
	  	 _root.balanceSubanswer.subanswer = _root[ballName].subAnswer;
		 _root.balanceSubanswer.gotoAndPlay("display");
	  }
   }
   // checks the second answer to see if it is the answer we're looking for
   // play the target with the answer we're looking for
   if (_root[ballName].answer2 == answerChecking) {
   	  targetName = GetTargetName(answerChecking, levelNumber);
	  _root[targetName].gotoAndPlay("bonus-right");
	  if (targetName == targetDroppedInto) {
	  	  if (targetDroppedInto != "balance") {
			  _root[targetName + "Score"].scoreDiff = "+" + _root._G_scoreArray[_root._G_levelNumber -1] * 2;
		  	  _root[targetName + "Score"].gotoAndPlay("bonus");
		  }
	  }
   }
   else if (_root[ballName].answer2 != " ") {
      targetName = GetTargetName(_root[ballName].answer2, levelNumber);
	  _root[targetName].gotoAndPlay("right");

  	  if (targetName == "balance") {
	  	 _root.balanceSubanswer.subanswer = _root[ballName].subAnswer;
		 _root.balanceSubanswer.gotoAndPlay("display");
	  }
   }
   // update all this information if the target is not "balance"
   // otherwise, leave it alone because it will updated after it has gone through
   //	stage 2 of financial statements
	if (targetDroppedInto != "balance") {
		_root._G_totalCorrectAnswers++;
   		//add to the score
		_root._G_scoreCount += _root._G_scoreArray[_root._G_levelNumber -1] * 2;
   		_root.ChangeScoreBar();
	}
}
//----------------------------------------------------
// Function: Refresh
// Description: Remove the ball, clear its position, and check to see if another
// 				ball is falling or not.
//----------------------------------------------------
function Refresh() {
	_root.RemoveValFromFallingArray(this.num);
	_root.RefreshPositions(this._name);
	this.removeMovieClip();
	_root.CheckBallFalling();
}
//----------------------------------------------------
// Function: GrowTargetForNextStage
// Description:  Pause everything, play the animation showing the target/hole growing.
//----------------------------------------------------
function GrowTargetForNextStage() {
   _root._G_balanceSheetAcctName = this.acctName;
   _root._G_balanceSheetBallSubAnswer = this.subAnswer;
   _root._G_balanceSheetBallShape = this.ballShape;

   for (var i = 0; i <= _parent._G_starter; i++) {
      _parent["ball" + i].pause = true;
   }
   _root.timeDisplay.gotoAndPlay ("Stop");
   _root.balance.gotoAndPlay("tube grow");
}
//----------------------------------------------------
// Function: PlayBonusStage
// Description: Pause everything and load the bonus stage.
//----------------------------------------------------
function PlayBonusStage() {
   for (var i = 0; i <= _root._G_starter; i++) {
      _root["ball" + i].pause = true;
   }
   _root.timeDisplay.gotoAndPlay ("Stop");
   _root.blackForeground.gotoAndPlay("black out");


	loadMovieNum("bonus-stage.swf", 3);
}