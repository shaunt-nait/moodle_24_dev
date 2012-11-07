/******************************************************************************
 FILE: finstmt-ball-functions-stage2.as
 AUTHOR: Rebecca Marcil
 DATE: Nov.1, 2002
 VERSION: 1.1
 DESCRIPTION: Placed on the _root timeline of finstmt-stage2.fla. This file holds all the
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
// Function: DropBallFromTube
// Description: handles the dropping of the ball from the tube animation
//----------------------------------------------------
function DropBallFromTube(MC) {

    if ( (_root._G_tubeDone == true) && (_root._G_ballDropped == false) ) {
	   MC._y += 6;
	   if (MC._y > 63) {
	   	  _root._G_ballDropped = true;
	   	  _root.timeDisplay.gotoAndPlay("Start");
	   	  _root.outsideTube._visible = false;
		  MC.falling = true;
		  MC.dy = 5;
	   }
	   //trace ("dropping ball from tube _x: " + MC._x + " _y: " + MC._y);
	}
}
//----------------------------------------------------
// Function: DropBall
// Description: After it is dropped from the tube, it is dropped vertically first
//----------------------------------------------------
function DropBall(MC) {
    if ((MC.falling == true) && (MC.bouncing == false) && (MC.dragging == false) ) {
	   MC._y += 6;
	   if (MC._y > 156) {
	   	  MC.falling = false;
		  MC.bouncing = true;
	   }
	   //trace ("dropping ball _x: " + MC._x + " _y: " + MC._y);
	}
}
//----------------------------------------------------
// Function: GetNewYValueToBeAdded
// Description: obtain a value to be added to the y-position of the ball.
//		This value can be either negative or positive.
//----------------------------------------------------
function GetNewYValueToBeAdded (yVal, yPosition) {

	if ( (yPosition < 165.5) && (yPosition > 62.5) && (_root._G_bounceUp == true) ) {
		return MakeNegativeValue(yVal);
	}
	else if ( (yPosition < 165.5) && (yPosition > 62.5) && (_root._G_bounceUp == false) ) {
		return MakePositiveValue(yVal);
	}
	else if (yPosition >= 165.5) {
		_root._G_bounceUp = true;
		return  MakeNegativeValue(yVal);

	}
	else if (yPosition <= 62.5) {
		_root._G_bounceUp = false;
		return MakePositiveValue(yVal);

	}
}
//----------------------------------------------------
// Function: GetNewXValueToBeAdded
// Description: obtain a value to be added to the x-position of the ball.
//		This value can be either negative or positive.
//----------------------------------------------------
function GetNewXValueToBeAdded(xVal, xPosition) {

	if ( (xPosition < 216.5) && (xPosition > 26.5) && (_root._G_bounceLeft == true) ) {
		return MakeNegativeValue(xVal);
	}
	else if ( (xPosition < 216.5) && (xPosition > 26.5) && (_root._G_bounceLeft == false) ) {
		return MakePositiveValue(xVal);
	}
	else if (xPosition >= 216.5) {
		_root._G_bounceLeft = true;
		return MakeNegativeValue(xVal);
	}
	else if (xPosition <= 26.5) {
		_root._G_bounceLeft = false;
		return MakePositiveValue(xVal);
	}
}
//----------------------------------------------------
// Function: MakePositiveValue
// Description: Make a given number into a positive number
//----------------------------------------------------
function MakePositiveValue(number) {
	if (number < 0) { return -number; }
	else { return number; }
}
//----------------------------------------------------
// Function: MakeNegativeValue
// Description: Make a given number into a negative number.
//----------------------------------------------------
function MakeNegativeValue(number) {
	if (number > 0) { return -number; }
	else { return number; }
}
//----------------------------------------------------
// Function: BounceBall
// Description: Bounce the ball around the screen.
//----------------------------------------------------
function BounceBall(MC) {
    if ((MC.falling == false) && (MC.bouncing == true) && (MC.dragging == false) ) {
		MC.x = GetNewXValueToBeAdded(MC.x, MC._x);
		MC.y =	GetNewYValueToBeAdded(MC.y, MC._y);
	   	MC._x += MC.x;
	  	MC._y += MC.y;
	   	//trace ("x: " + MC.x + " y: " + MC.y);
	   	//trace ("bouncing ball _x: " + MC._x + " _y: " + MC._y);
	}
}
//----------------------------------------------------
// Function: BallStatusCheck
// Description: Bounce the ball if the timer is greater than 1.0, otherwise, burst it.
//----------------------------------------------------
function BallStatusCheck(MC){
   if (_root.stage2-timer._width <= 1) {
   	  MC.gotoAndPlay("burst");
   }
}
//----------------------------------------------------
// Function: PauseBallMC
// Description: Pause all the duplicated ball movies.
//----------------------------------------------------
function PauseBallMC() {
	this["ball" + i].pause = true;
}