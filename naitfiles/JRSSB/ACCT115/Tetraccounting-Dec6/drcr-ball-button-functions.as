/******************************************************************************
 FILE: drcr-ball-functions.as
 AUTHOR: Rebecca Marcil
 DATE: Aug. 20, 2002
 VERSION: 1.0 
 DESCRIPTION: Placed in the _root.ball timeline and _root["MC" + i] of drcr.fla 
 			  and finstmt.fla. The following functions are used by _root.ball
			  when once it has been dropped into the target and determined correct
			  or not correct.
******************************************************************************/ 
 
//----------------------------------------------------
// Function: PlayRight
// Description: Update the score count, and change the score bar when a ball 
// 				falls in the correct target.
// Input: name: string, refers to a target name.
// Output: score animation is played, _G_scoreCount and scoreBar are updated.
//----------------------------------------------------
function PlayRight(name) {
   _root[name].addToScore = "+" + _root._G_scoreArray[_root._G_levelNumber -1];
   _root[name].gotoAndPlay("right");
   _root._G_scoreCount += _root._G_scoreArray[_root._G_levelNumber -1];
   _root.ChangeScoreBar();
}
//----------------------------------------------------
// Function: PlayWrong
// Description: Update the score count, and change the score bar when a ball 
// 				falls in the wrong target.
// Input: name: string, refers to a target name.
// Output: score animation is played, _G_scoreCount and scoreBar are updated.
//----------------------------------------------------
function PlayWrong(name) {
	MC._visible = false; 
	_root[name].addToScore = "-" + _root._G_scoreArray[_root._G_levelNumber -1] / 2;
	_root[name].gotoAndPlay("wrong");		
	_root._G_scoreCount -= _root._G_scoreArray[_root._G_levelNumber -1] / 2;
	_root.ChangeScoreBar();
}
//----------------------------------------------------
// Function: PlayBonusRight
// Description: Update the score count, and change the score bar when a bonus ball 
// 				falls in the correct target.
// Input: name: string, refers to a target name.
// Output: score animation is played, _G_scoreCount and scoreBar are updated.
//----------------------------------------------------
function PlayBonusRight(name) {
    _root[name].addToScore = "+" + _root._G_scoreArray[_root._G_levelNumber -1] * 2;
	_root[name].gotoAndPlay("bonus-right");
	_root._G_scoreCount += _root._G_scoreArray[_root._G_levelNumber -1] * 2;
	_root.ChangeScoreBar();	
}
//----------------------------------------------------
// Function: Refresh
// Description: Remove the ball, clear its position, and check to see if another 
// 				ball is falling or not.
// Input: none
//----------------------------------------------------
function Refresh() {
	_root.RemoveValFromFallingArray(this.num);
	_root.RefreshPositions(this._name);	
	this.removeMovieClip();
	_root.CheckBallFalling();
}