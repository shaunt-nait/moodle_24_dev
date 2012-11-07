/******************************************************************************
 FILE: high-scores.as
 AUTHOR: Rebecca Marcil
 DATE: Aug.28, 2002
 VERSION: 1.0
 DESCRIPTION: This file contains the functions used by high-scores.fla. It is
 			  placed in the _root timeline.																			   
******************************************************************************/

//----------------------------------------------------
// global variable declarations
//----------------------------------------------------
var _G_scoreString = "";
var _G_records = "0"; 	


//----------------------------------------------------
// Description: Get the index of the first occurence of a given character in a given string.
// Input: ch: the character that you want to check the index of
// 		  longString: the string that you want to check the index of "ch"
// Output: 1. returns -1 if "ch" cannot be found in "longString", or
// 		   2. returns the index ( >= 0) of "ch" in "longString"
//----------------------------------------------------
function GetCharIndex(ch, longString) {
	var i = 0, index = -1;
		 
	while (i < longString.length) {
		if (longString.charAt(i) == ch) {
			index = i;
			break;
		}
		else { i++;	}		 
	}
	return index;
}
//----------------------------------------------------
// Description: Gets the "name" part of the given string
// Input: longString: a concatenated string consisting of name, score, time, and date
// 		  that are separated by a "*". 
// 		  Example: longString = name*score*time*date
// Output: a string - the "name" part of "longString"
//----------------------------------------------------
function GetName(longString) {
	var tmpString;
	var index = GetCharIndex("*", longString);

	// index >= 0 means that the "*" is found in the string
	if (index >= 0) { tmpString = longString.substring(0, index); }
	else { tmpString = longString; }
	
	return tmpString;
}
//----------------------------------------------------
// Description: Gets the "score" part of the given string
// Input: longString: a concatenated string consisting of name, score, time, and date
// 		  that are separated by a "*". 
// 		  Example: longString = name*score*time*date
// Output: a string - the "score" part of "longString"
//----------------------------------------------------
function GetScore(longString) {
    var tmpString1, tmpString, index2;
	var index1 = GetCharIndex("*", longString);

	// index1 >= 0 means that the "*" is found in the string
	if (index1 >= 0) {
	   tmpString1 = longString.substring(index1 + 1, longString.length);
	}
	else { tmpString1 = longString; }

	index2 = GetCharIndex("*", tmpString1);
	if (index2 >= 0) {	
	   tmpString = tmpString1.substring(0, index2);
	}
	else { tmpString = tmpString1; } 
	
	return tmpString;
}
//----------------------------------------------------
// Description: Gets the "time" part of the given string
// Input: longString: a concatenated string consisting of name, score, time, and date
// 		  that are separated by a "*". 
// 		  Example: longString = name*score*time*date
// Output: a string - the "time" part of "longString"
//----------------------------------------------------
function GetTime(longString) {
	var tmpString1, tmpString, tmpString2, index2, index3;
	var index1 = GetCharIndex("*", longString);

	// index1 >= 0 means that the "*" is found in the string	
	if (index1 >= 0) {
	   tmpString1 = longString.substring(index1 + 1, longString.length);
	}
	else { tmpString1 = longString;	}
		 	 
	index2 = GetCharIndex("*", tmpString1);
	if (index2 >= 0) {
	   tmpString2 = tmpString1.substring(index2 + 1, tmpString1.length);
	}
	else { tmpString2 = tmpString1;	}
		 
	index3 = GetCharIndex("*", tmpString2);
	if (index3 >= 0) {	
	   tmpString = tmpString2.substring(0, index3);
	}
	else { tmpString = tmpString2; }

	return tmpString;
}
//----------------------------------------------------
// Description: Gets the "date" part of the given string
// Input: longString: a concatenated string consisting of name, score, time, and date
// 		  that are separated by a "*". 
// 		  Example: longString = name*score*time*date
// Output: a string - the "date" part of "longString"
//----------------------------------------------------
function GetDate(longString) {
	var tmpString1, tmpString2, tmpString, index2, index3;
	var index1 = GetCharIndex("*", longString);

	if (index1 >= 0 ) {
	   tmpString1 = longString.substring(index1 + 1, longString.length);
	}
	else { tmpString1 = longString;	}
		 
	index2 = GetCharIndex("*", tmpString1);
	if (index2 >= 0 ) {
	   tmpString2 = tmpString1.substring(index2 + 1, tmpString1.length);
	}
	else { tmpString2 = tmpString1;	}

	index3 = GetCharIndex("*", tmpString2);
	if (index3 >= 0 ) {
	   tmpString = tmpString2.substring(index3 + 1, tmpString2.length);
	}
	else { tmpString = tmpString2; }

	return tmpString;		
}
//----------------------------------------------------
// Description: Breaks the "longString" into substrings. Breaks the substrings further into
//		name, score, time, and date and store them appropriately into the 
//		two D array.
// example: longString = name*score*time*date&name*score*time*date&
// 			substring = name*score*time*date
// Input: none
// Output: returns a 2D array that contains the top ten scores: name, score, time, and date
//----------------------------------------------------
function StoreArrayOfString() {
	var i = 0, charIndex, tmpString, tmpString1, numOfMembers = 5;
	var stringArray = new Array(_G_records);
	
	for (i = 0; i < _G_records; i++) {
		stringArray[i] = new Array(numOfMembers);		
	}

	for (i = 0; i < _G_records; i++) {
		// look for first index of "&"
		if (i == 0) {		
			charIndex = GetCharIndex("&", _G_scoreString);

			if (charIndex >= 0 ) {
			   // tmpString should contain name, score, time, and date
			   tmpString = _G_scoreString.substring(0, charIndex);  
			}
			else { tmpString = _G_scoreString; }

			// could make the index, name, score, time, and date into an object() also		
			stringArray[i]["index"] = charIndex;
			stringArray[i]["name"] = GetName(tmpString);
			stringArray[i]["score"] = GetScore(tmpString);
			stringArray[i]["time"] = GetTime(tmpString);
			stringArray[i]["date"] = GetDate(tmpString);
		} 
		else {					  			 
			tmpString = _G_scoreString.substring( stringArray[i - 1]["index"] + 1, _G_scoreString.length);
			charIndex = GetCharIndex("&", tmpString);		// find the first index of "&" in tmpString

			if (charIndex >= 0 ){			
			   // tmpString1 should contain name, score, time, and date
			   tmpString1 = tmpString.substring(0, charIndex); 
			}
			else { tmpString1 = tmpString; }

			stringArray[i]["index"] = charIndex + Number(stringArray[i - 1]["index"]) + 1;
			stringArray[i]["name"] = GetName(tmpString1);
			stringArray[i]["score"] = GetScore(tmpString1);
			stringArray[i]["time"] = GetTime(tmpString1);
			stringArray[i]["date"] = GetDate(tmpString1);
		}
	}
	return stringArray;		
}
//----------------------------------------------------
// Description: Remove all the duplicated movies storing the top ten high scores.
// Input: none
// Output: all the high scores movieclips are removed
//----------------------------------------------------
function RemoveScoreMC(){
    var i;
	for (i = 0; i < _G_records; i++) {
		removeMovieClip(_root["score" + i]);
	}
}

