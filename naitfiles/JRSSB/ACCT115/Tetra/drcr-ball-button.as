/******************************************************************************
 FILE: drcr-ball-button.as
 AUTHOR: Rebecca Marcil
 DATE: August 20, 2002
 VERSION: 1.0
 DESCRIPTION: Placed in the button of _root.ball timeline of drcr.fla. These are
 			  actions for the button.
******************************************************************************/

// ------------------------------------------------------------------------
// Action: on press
// Description: Update booleans when the ball is pressed
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
	  if ( (falling == false) && (dragging == true) ) { _parent.CheckBallFalling(); }
	}
}
// ------------------------------------------------------------------------
// Action: on press, release, dragOver, and dragOut
// Description: Make the ball standout when it is pressed
// ------------------------------------------------------------------------
on (press, release, dragOver, dragOut) {
    if (pause == false) {
	   var depth = 500;
	   this.swapDepths(depth);
	}
}
// ------------------------------------------------------------------------
// Action: on release, releaseOutside
// Description: When the ball is released, check if it is in the target. If it
// 				is, do the appropriate animation and functions. If not, spring
//				back to original spot.
// ------------------------------------------------------------------------
on (release, releaseOutside) {
    if (pause == false) {
	   // if the ball is dropped on the debit target
	   if ( this.hitTest(_root.debit) ) {
	   	  if (this.answer == "debit") {
			 this._visible = false;
			 if (this.bonus == false) { PlayRight("debit"); }
			 else { PlayBonusRight("debit");	}
		  }
		  else { PlayWrong("debit");	}
		  Refresh();
	   }
	   else if ( this.hitTest(_root.credit) ) {
	   // if the ball is dropped on credit target
		  if (this.answer == "credit") {
		  this._visible = false;
		  if (this.bonus == false) { PlayRight("credit"); }
		  else { PlayBonusRight("credit"); }
	   }
	   else { PlayWrong("credit");	}
		  Refresh();
	   }
	   dragging = false;
	   falling = true;
	   _root.ResetThis(this);
   }
}