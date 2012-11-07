/******************************************************************************
 FILE: finstmt-ball-button.as
 AUTHOR: Rebecca Marcil
 DATE: Nov.1, 2002
 VERSION: 1.1
 DESCRIPTION: Placed on the _root.ball and _root["MC" + i] timeline of
 			  finstmt.fla. These are actions for the button.
******************************************************************************/

// ------------------------------------------------------------------------
// Action: on press
// Description: Update booleans when the ball is pressed.
// ------------------------------------------------------------------------
on (press) {
   _root._G_lastDraggedNum = num;
   _root._G_lastDraggedCol = column;
   _root._G_lastDraggedRowLanded = rowNumLanded;

   if (pause == false){
      oldX = this._x;
	  oldY = this._y;
	  dragging = true;
	  falling = false;

	  if ( (falling == false) && (dragging == true) ) {
	     _root.CheckBallFalling();
	  }
	}
}
//----------------------------------------------------
// Action: on press, release, dragOver, and dragOut
// Description: Make the ball standout when it is pressed
//----------------------------------------------------
on (press, release, dragOver, dragOut) {
   if (pause == false) {
      var depth = 600;
	  this.swapDepths(depth);
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

      if ( this.hitTest(_root.balance) ) {
	  	 this._visible = false;

	     if ( (this.answer1 == "Balance Sheet") || (this.answer2 == "Balance Sheet") ){
				PlayRight("balance", this._name, "Balance Sheet", _root._G_levelNumber);
				 GrowTargetForNextStage();

         }
	     else { PlayWrong("balance", this._name, _root._G_levelNumber); }
	     Refresh();
	  }
  	  else if ( this.hitTest(_root.income) ) {
	  	 this._visible = false;

	     if ( (this.answer1 == "Income Statement") || (this.answer2 == "Income Statement") ) {
			if (this.bonus == false) { PlayRight("income", this._name, "Income Statement", _root._G_levelNumber); }
			else {
				PlayRight("income", this._name, "Income Statement", _root._G_levelNumber);
				PlayBonusStage();
			}
		 }
		 else { PlayWrong("income", this._name, _root._G_levelNumber); }
		 Refresh();
      }
	  else if ( this.hitTest(_root.equity) ) {
	  	 this._visible = false;

	     if ( (_root._G_levelNumber <= 4) &&
			( (this.answer1 == "Statement of Owner's Equity") || (this.answer2 == "Statement of Owner's Equity") ) ) {
			if (this.bonus == false) { PlayRight("equity", this._name, "Statement of Owner's Equity", _root._G_levelNumber); }
			else {
				PlayRight("equity", this._name, "Statement of Owner's Equity", _root._G_levelNumber);
				PlayBonusStage();
			}
		 }
		 else if ( (_root._G_levelNumber < 4) &&
			     ( (this.answer1 == "Statement of Retained Earnings") || (this.answer2 == "Statement of Retained Earnings") ) ) {
		    if (this.bonus == false) { PlayRight("equity", this._name, "Statement of Retained Earnings", _root._G_levelNumber); }
			else {
				PlayRight("equity", this._name, "Statement of Owner's Equity", _root._G_levelNumber);
				PlayBonusStage();
			}
		 }
		 else { PlayWrong("equity", this._name, _root._G_levelNumber); }
		 Refresh();
      }
	  else if ( _root.earnings.hitTest(_root._xmouse, _root._ymouse, false) ) {
	     this._visible = false;

	     if ( (this.answer1 == "Statement of Retained Earnings") || (this.answer2 == "Statement of Retained Earnings") ) {
			if (this.bonus == false) { PlayRight("earnings", this._name, "Statement of Retained Earnings", _root._G_levelNumber); }
			else {
				PlayRight("earnings", this._name, "Statement of Retained Earnings", _root._G_levelNumber);
				PlayBonusStage();
			}
		 }
		 else { PlayWrong("earnings", this._name, _root._G_levelNumber); }
		 Refresh();
      }
	  dragging = false;
	  falling = true;
	  _root.ResetThis(this);
   }
}