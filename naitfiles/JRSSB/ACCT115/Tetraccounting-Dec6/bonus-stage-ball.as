/******************************************************************************
 FILE: bonus-stage-ball.as
 AUTHOR: Rebecca Marcil
 DATE: Nov.1, 2002
 VERSION: 1.1
 DESCRIPTION: Placed on the _root.ball timeline of bonus-stage.fla.
 	These are actions for the ball movie.
******************************************************************************/

// ------------------------------------------------------------------------
// Action: onClipEvent(load)
// Description: Update booleans when the ball is pressed.
// ------------------------------------------------------------------------
onClipEvent(load) {
  mySpeed = Math.randomBetween(20,50);
  myRotation = Math.randomBetween(20,40);
  hit = false;
  extraScore = 1;
}

// ------------------------------------------------------------------------
// Action: onClipEvent(enterFrame)
// Description: Update booleans when the ball is pressed.
// ------------------------------------------------------------------------
onClipEvent(enterFrame) {
	if (this.hitTest(_root.tack) && (hit == false)) {
		this.gotoAndPlay("burst");
		_root._G_bonusScore += extraScore;
		hit = true;
	}
	else {
	 	_parent._visible = true;
 		_parent._y += mySpeed;
  		_parent._rotation += myRotation;
	}

  	if (_parent._y > 284.5) {
    	_parent.removeMovieClip();
  	}

}



