/******************************************************************************
 FILE: finstmt-ball-button-stage2.as
 AUTHOR: Rebecca Marcil
 DATE: Nov.1, 2002
 VERSION: 1.1
 DESCRIPTION: Placed on the _root.ball timeline of
 			  finstmt.fla. These are actions for the button.
******************************************************************************/

// ------------------------------------------------------------------------
// Action: on press
// Description: Update booleans when the ball is pressed.
// ------------------------------------------------------------------------
on (press) {

   if (pause == false){
	  dragging = true;
	  falling = false;
	  bouncing = false;
   }

}

//----------------------------------------------------
// Action: on release, releaseOutside
// Description: When the ball is released, check if it is in the target. If it
// 				is, do the appropriate animation and functions. If not, spring
//				back to original spot.
//----------------------------------------------------
on (release, releaseOutside) {
   // only do the following if the ball movieclips aren't paused.
   if (pause == false) {

   	  	 if ( this.hitTest(_root.asset) ) {

		 	trace("this.subAnswer: " + this.subAnswer + " this.bonus: " + this.bonus);
	  	 	this._visible = false;

			if (this.subAnswer == "Asset") {
			   if (this.bonus == false) { PlayRight("asset"); }
			   else {
				   PlayRight("asset");
				   PlayBonusStage(); }
		 	}
		 	else { PlayWrong("asset", this._name, _root._G_levelNumber); }

			this.removeMovieClip();
		 	_root._G_stage2Done = true;
		 	_root.timeDisplay.gotoAndPlay("Stop");

	  	 }
	  	 else if ( this.hitTest(_root.liability) ) {
		 	trace("this.subAnswer: " + this.subAnswer + " this.bonus: " + this.bonus);
			this._visible = false;

	  	 	if (this.subAnswer == "Liability") {
			   if (this.bonus == false) { PlayRight("liability"); }
			   else {
				   PlayRight("liability");
				   PlayBonusStage(); }
		    }
		 	else { PlayWrong("liability", this._name, _root._G_levelNumber);	}

			this.removeMovieClip();
			_root._G_stage2Done = true;
			_root.timeDisplay.gotoAndPlay("Stop");

	  	 }
	  	 else if ( this.hitTest(_root.equity) ) {
		 	trace("this.subAnswer: " + this.subAnswer + " this.bonus: " + this.bonus);
			this._visible = false;

		 	if (this.subAnswer == "Shareholder's Equity") {
			   if (this.bonus == false) { PlayRight("equity"); }
			   else {
				   PlayRight("equity");
				   PlayBonusStage(); }
			}
		 	else { PlayWrong("equity", this._name, _root._G_levelNumber); }

			this.removeMovieClip();
		 	_root._G_stage2Done = true;
		 	_root.timeDisplay.gotoAndPlay("Stop");
	     }
	  	 dragging = false;
	  	 falling = true;
	  	 _root.DropBall(this);
   }
}