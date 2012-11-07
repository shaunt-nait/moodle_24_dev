/******************************************************************************
 FILE: global-variables.as
 AUTHOR: Rebecca Marcil
 DATE: Oct. 28, 2002
 VERSION: 1.1
 DESCRIPTION: This file is used in _root timeline of drcr.fla and finstmt.fla.
******************************************************************************/

//----------------------------------------------------
// global variable declarations
//
// _G_LVL1DRCRTOTALTOPICS: integer; total number of account names in level 1 of debits and credits
// _G_LVL2DRCRTOTALTOPICS: integer; total number of account names in level 2 of debits and credits
// _G_LVL3DRCRTOTALTOPICS: integer; total number of account names in level 3 of debits and credits
// _G_LVL4DRCRTOTALTOPICS: integer; total number of account names for all three levels of debits and credits

// _G_LVL1FINSTMTTOTALTOPICS: integer; total number of account names in level 1 of financial statements
// _G_LVL2FINSTMTTOTALTOPICS: integer; total number of account names in level 2 of financial statements
// _G_LVL3FINSTMTTOTALTOPICS: integer; total number of account names in level 3 of financial statements
// _G_LVL4FINSTMTTOTALTOPICS: integer; total number of account names for all three levels of financial statements

// _G_NUMOFCOLUMNS: integer; # of columns in the position matrix
// _G_NUMOFROWS: integer; # of rows in the position matrix
// _G_MAXGAMELVL: integer; maximum # of game levels
// _G_MAXSPEEDLVL: integer; maximum # of speed levels
// _G_NUMBEROFMC: integer; # of movie clips to duplicate
// _G_MAXSCOREBARPIXELS: integer; maximum length of score bar in pixels

// _G_ballIndex: integer; index used when duplicating the balls
// _G_depth: integer; depth of the ball; used when duplicating the balls
// _G_dy: an integer; the actual speed that the balls are dropping at
// _G_levelNumber: integer; current level of game
// _G_MCDepth: integer; movie clip depth
// _G_newLevel: a boolean; true indicates the start of a new level
// _G_newGame: boolean; true indicates the start of a new game
// _G_numOfMC: integer; number of movie clips
// _G_speedLvl: an integer; the current speed level
// _G_scoreCount: an integer; current total score; it is equal to zero when the game starts
// _G_starter: an integer;  the index of the ball that is just dropping
// _G_timer: a string; stores the value of the timer so that it can be referred to in the "Scores" frame

// _G_scoreArray: one-D array; stores the score increment for each level
// _G_fallingArray: one-D array; stores the index of the balls that are falling
// _G_positionMatrix: two-D array; stores the positions of the balls in drcr or finstmt
// _G_txtArray1: a 2D array; stores the account names of level 1
// _G_txtArray2: a 2D array; stores the account names of level 2
// _G_txtArray3: a 2D array; stores the account names of level 3
// _G_txtArray4: a 2D array; stores the account names of all three levels

// _G_lastDraggedNum: integer; number of the ball that was last dragged
// _G_lastDraggedCol: integer; column that the last dragged ball was falling in
// _G_lastDraggedRowLanded: integer: row that the last dragged ball landed in

// _G_balanceSheetAcctName: string, account name of ball
// _G_balanceSheetBallSubAnswer: string, subanswer of ball (asset, liability or equity)
// _G_balanceSheetBallShape: integer, shape of the ball that was dropped (1-8)
// _G_tubeGrowthStopped: boolean, true of target growth stopped

// _G_totalCorrectAnswers: total number of correct answers
// _G_totalWrongAnswers: total number of wrong answers
//----------------------------------------------------

var _G_LVL1DRCRTOTALTOPICS = 189;
var _G_LVL2DRCRTOTALTOPICS = 42;
var _G_LVL3DRCRTOTALTOPICS = 117;
var _G_LVL4DRCRTOTALTOPICS = _G_LVL1DRCRTOTALTOPICS + _G_LVL2DRCRTOTALTOPICS + _G_LVL3DRCRTOTALTOPICS;

var _G_LVL1FINSTMTTOTALTOPICS = 65;
var _G_LVL2FINSTMTTOTALTOPICS = 28;
var _G_LVL3FINSTMTTOTALTOPICS = 42;
var _G_LVL4FINSTMTTOTALTOPICS = _G_LVL1FINSTMTTOTALTOPICS + _G_LVL2FINSTMTTOTALTOPICS + _G_LVL3FINSTMTTOTALTOPICS;

var _G_NUMOFCOLUMNS = 5;
var _G_NUMOFROWS = 6;

var _G_MAXGAMELVL = 4;
var _G_MAXSPEEDLVL = 5;
var _G_MINSPEEDLVL = 1;
var _G_NUMBEROFMC = 20;
var _G_MAXSCOREBARPIXELS = 230;

var _G_ballIndex = 0;
var _G_depth = 0;
var _G_dy = ChangeSpeed(speedLvl);
var _G_levelNumber = 1;
var _G_MCDepth = 510;
var _G_newLevel = true;
var _G_newGame = true;
var _G_numOfMC = _G_NUMBEROFMC;
var _G_speedLvl = GetMinSpeedLvl();
var _G_scoreCount = 0;
var _G_previousMaxScore = 0;
var _G_currentMaxScore = 0;
var _G_starter = 0;

var _G_timer = "00:00:00";
var _G_timeNow = 0;
var _G_topic = "DrCr";

var _G_scoreArray = "";
var _G_fallingArray = "";
var _G_positionMatrix = "";
var _G_txtArray1 = "";
var _G_txtArray2 = "";
var _G_txtArray3 = "";
var _G_txtArray4 = "";

var _G_lastDraggedNum = 0;
var _G_lastDraggedCol = 0;
var _G_lastDraggedRowLanded = 0;

var _G_balanceSheetAcctName = "";
var _G_balanceSheetBallSubAnswer = "";
var _G_balanceSheetBallShape = 0;
var _G_tubeGrowthStopped = false;

// for finstmts only at the moment
var _G_totalWrongAnswers = 0;
var _G_totalCorrectAnswers = 0;