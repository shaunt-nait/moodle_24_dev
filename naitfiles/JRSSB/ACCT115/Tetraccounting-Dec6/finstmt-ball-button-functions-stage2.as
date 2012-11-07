/******************************************************************************
 FILE: finstmt-ball-button-functions-stage2.as
 AUTHOR: Rebecca Marcil
 DATE: Nov.1, 2002
 VERSION: 1.1
 DESCRIPTION: Placed in the _root.ball timeline of stage 2 of finstmt.fla.
 	The following functions are used by _root.ball
	when once it has been dropped into the target and determined correct
	or not correct.
******************************************************************************/

//----------------------------------------------------
// Function: GetTargetName
// Description: Get the target/hole instance name given an answer and levelNumber
// Output: instance name of target/hole - string
//----------------------------------------------------
function GetTargetName(answer, levelNumber) {
   if (answer == "Asset") {
   	  return "balance";
   }
   else if (answer == "Liability") {
      return "income";
   }
   else if (answer == "S/H Equity") {
   	 return "equity";
   }
}
//----------------------------------------------------
// Function: GetTargetArrowName
// Description: Get the instance name of the arrow MC residing on top of each target/hole.
// Output: instance name of arrow MC - string
//----------------------------------------------------
function GetTargetArrowName(answer, levelNumber) {
   if (answer == "Asset") {
   	  return "assetTargetArrow";
   }
   else if (answer == "Liability") {
      return "liabilityTargetArrow";
   }
   else if (answer == "Shareholder's Equity") {
   	 return "equityTargetArrow";

   }
}
//----------------------------------------------------
// Function: PlayRight
// Description: Update the score count, and change the score bar when a ball
// 				falls in the correct target.
// Input: targetDroppedInto - string, refers to a target name.
// Output: _G_scoreCount and scoreBar are updated.
// Note: There is only one possible answer
//----------------------------------------------------
function PlayRight(targetDroppedInto) {

	_root._G_correctAnswer = true;

   _root[targetDroppedInto].gotoAndPlay("right");
   _root[targetDroppedInto + "Score"].scoreDiff = "+" + _root._G_scoreArray[_root._G_levelNumber -1];
   _root[targetDroppedInto + "Score"].gotoAndPlay("right");

   //trace("level: " + _root._G_levelNumber + "scoreDiff: " + _root[targetDroppedInto + "Score"].scoreDiff + " scoreArray: " + _root._G_scoreArray[_root._G_levelNumber -1]);

	_root._G_totalCorrectAnswers++;
   //add to the score
   _root._G_scoreCount += _root._G_scoreArray[_root._G_levelNumber -1];
   _root.Stage2ChangeScoreBar();
}
//----------------------------------------------------
// Function: PlayWrong
// Description: Update the score count, and change the score bar when a ball
// 				falls in the wrong target.
// Input: targetDroppedInto - string, refers to a target name.
//		ballName - string, instance name of the ball
// 		levelNumber - integer, level of game
// Output: score animation is played, _G_scoreCount and scoreBar are updated.
//----------------------------------------------------
function PlayWrong(targetDroppedInto, ballName, levelNumber) {
   var targetArrowName;
   // display the wrong target

	_root._G_correctAnswer = false;

	_root[targetDroppedInto].gotoAndPlay("wrong");
	_root[targetDroppedInto + "Score"].scoreDiff = "-" + _root._G_scoreArray[_root._G_levelNumber -1] / 2;
	_root[targetDroppedInto + "Score"].gotoAndPlay("wrong");

	// display the correct target
   if (_root[ballName].subAnswer != " ") {
      targetArrowName = GetTargetArrowName(_root[ballName].subAnswer, _root._G_levelNumber);
	  _root[targetArrowName].gotoAndPlay("show arrow");

   }
   	_root._G_totalWrongAnswers++;
   // reduce the score
	_root._G_scoreCount -= _root._G_scoreArray[_root._G_levelNumber -1] / 2;
	_root.Stage2ChangeScoreBar();
}
//----------------------------------------------------
// Function: PlayBonusRight
// Description: Update the score count, and change the score bar when a bonus ball
// 				falls in the correct target.
// Input: targetDroppedInto - string, refers to a target instance name.
// Output: _G_scoreCount and scoreBar are updated.
//----------------------------------------------------
function PlayBonusRight(targetDroppedInto) {

   _root[targetDroppedInto].gotoAndPlay("bonus-right");
   _root[targetDroppedInto + "Score"].scoreDiff = "+" + _root._G_scoreArray[_root._G_levelNumber -1] * 2;
   _root[targetDroppedInto + "Score"].gotoAndPlay("bonus");

	_root._G_totalCorrectAnswers++;
   //add to the score
   _root._G_scoreCount += _root._G_scoreArray[_root._G_levelNumber -1] * 2;
   _root.Stage2ChangeScoreBar();
}
//----------------------------------------------------
// Function: PlayBonusStage
// Description: Update all info on this stage first, get rid of this stage, and then load
//		up the bonus stage
// Input: MC: movieclip
// Pre-condition: a bonus ball was dropped into a target and it was correct.
//----------------------------------------------------
function PlayBonusStage(MC) {

   /*_root._G_correctAnswer = true;

   _root._G_totalCorrectAnswers++;
   _root.Stage2ChangeScoreBar();
   _root[MC].removeMovieClip();
   _root._G_stage2Done = true;
   _root.timeDisplay.gotoAndPlay("Stop");
   _root.blackForeground.gotoAndPlay("black out");
*/
	loadMovieNum("bonus-stage.swf", 3);
}
