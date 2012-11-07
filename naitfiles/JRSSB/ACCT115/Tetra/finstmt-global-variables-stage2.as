/******************************************************************************
 FILE: global-variables.as
 AUTHOR: Rebecca Marcil
 DATE: Nov.1, 2002
 VERSION: 1.1
 DESCRIPTION: This file is used in _root timeline of finstmt-stage2.fla.
******************************************************************************/

//----------------------------------------------------
// global variable declarations
//
// _G_LVL1DRCRTOTALTOPICS: integer, obtained from level 1; it is the total account names for drcr in level 1
// _G_LVL2DRCRTOTALTOPICS: integer, obtained from level 1; it is the total account names for drcr in level 2
// _G_LVL3DRCRTOTALTOPICS: integer, obtained from level 1; it is the total account names for drcr in level 3
// _G_LVL4DRCRTOTALTOPICS: integer, obtained from level 1; it is the total account names for drcr in level 4
// _G_LVL1FINSTMTTOTALTOPICS: integer, obtained from level 1; it is the total account names for finstmt in level 1
// _G_LVL2FINSTMTTOTALTOPICS: integer, obtained from level 1; it is the total account names for finstmt in level 2
// _G_LVL3FINSTMTTOTALTOPICS: integer, obtained from level 1; it is the total account names for finstmt in level 3
// _G_LVL4FINSTMTTOTALTOPICS: integer, obtained from level 1; it is the total account names for finstmt in level 4

// _G_MAXGAMELVL: integer; maximum # of game levels
// _G_MAXSCOREBARPIXELS: integer; maximum length of score bar in pixels

// _G_topic: string, topic of the game
// _G_newGame: boolean
// _G_tubeDone: boolean
// _G_ballDropped: boolean
// _G_stage2Done: boolean

// _G_timer: string, taken from level 1
// _G_timeUp: boolean, timer's up
// _G_timerCurrentWidth: integer, width of timer
// _G_timeNow: current time before ball bounces around

// _G_correctAnswer: boolean, is the ball dropped into the target/hole correct or not
// _G_scoreArray: array of integers, stores the scores for all levels
// _G_scoreCount:an integer; current total score; it is equal to zero when the game starts

// _G_levelNumber: integer; current level of game
// _G_totalCorrectAnswers: total number of correct answers
// _G_totalWrongAnswers: total number of wrong answers

// _G_bounceUp: boolean, is ball bouncing up or down
// _G_bounceLeft: boolean, is ball bouncing left or right

// _G_ballColorForShape1: hex value of the main ball color for level 1
// _G_ballColorForShape2: hex value of the main ball color for level 2
// _G_ballColorForShape3: hex value of the main ball color for level 3
// _G_ballColorForShape4: hex value of the main ball color for level 4
// _G_ballColorForShape5: hex value of the main bonus ball color (heart)
// _G_ballColorForShape6: hex value of the main bonus ball color (club)
// _G_ballColorForShape7: hex value of the main bonus ball color (diamond)
// _G_ballColorForShape8: hex value of the main bonus ball color (spade)
//----------------------------------------------------

var _G_LVL1DRCRTOTALTOPICS = _level1._G_LVL1DRCRTOTALTOPICS;
var _G_LVL2DRCRTOTALTOPICS = _level1._G_LVL2DRCRTOTALTOPICS;
var _G_LVL3DRCRTOTALTOPICS = _level1._G_LVL3DRCRTOTALTOPICS;
var _G_LVL4DRCRTOTALTOPICS = _level1._G_LVL4DRCRTOTALTOPICS;

var _G_LVL1FINSTMTTOTALTOPICS = _level1._G_LVL1FINSTMTTOTALTOPICS;
var _G_LVL2FINSTMTTOTALTOPICS = _level1._G_LVL2FINSTMTTOTALTOPICS;
var _G_LVL3FINSTMTTOTALTOPICS = _level1._G_LVL3FINSTMTTOTALTOPICS;
var _G_LVL4FINSTMTTOTALTOPICS = _level1._G_LVL4FINSTMTTOTALTOPICS;

var _G_MAXGAMELVL = 4;
var _G_MAXSCOREBARPIXELS = 230;

var _G_topic = _level1._G_topic;
var _G_newGame = false;

var _G_tubeDone = false;
var _G_ballDropped = false;
var _G_stage2Done = false;

var _G_levelNumber = _level1._G_levelNumber;
//var _G_MCDepth = 510;

var _G_timer = _level1._G_timer;
var _G_timeUp = false;
var _G_timerCurrentWidth = "";
var _G_timeNow = _level1._G_timeNow;

var _G_correctAnswer = false;

var _G_scoreCount = _level1._G_scoreCount;
var _G_scoreArray = "";

var _G_totalCorrectAnswers = _level1._G_totalCorrectAnswers;
var _G_totalWrongAnswers = _level1._G_totalWrongAnswers;

var _G_bounceUp = false;
var _G_bounceLeft = false;

var _G_ballColorForShape1 = 0x8CCFE7;
var _G_ballColorForShape2 = 0x9CD3B5;
var _G_ballColorForShape3 = 0xFFC78C;
var _G_ballColorForShape4 = 0xCE9ACE;
// bonus ball shapes start here
var _G_ballColorForShape5 = 0xFFC3BD;
var _G_ballColorForShape6 = 0xADEB9C;
var _G_ballColorForShape7 = 0xFFD784;
var _G_ballColorForShape8 = 0xF7BEDE;