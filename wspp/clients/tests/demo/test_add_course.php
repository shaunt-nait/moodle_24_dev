<?php
require_once ('../MoodleWS.php');

$moodle=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: add on course
* @param integer $client
* @param string $sesskey
* @param courseDatum $course
* @return editCoursesOutput
*/

$lr=$moodle->login(LOGIN,PASSWORD);
$course= new courseDatum();
//$course->setAction('');
//$course->setId(0);
$course->setCategory(3);
//$course->setSortorder(0);
//$course->setPassword('');
$course->setFullname('java 102_old');
$course->setShortname('java102_old');
$course->setIdnumber('pp005');
$course->setSummary('resumé');
//$course->setFormat('');
//$course->setShowgrades(0);
//$course->setNewsitems(0);
//$course->setTeacher('');
//$course->setTeachers('');
//$course->setStudent('');
//$course->setStudents('');
//$course->setGuest(0);
/*
$course->setStartdate(0);
$course->setEnrolperiod(0);
$course->setMarker(0);
$course->setMaxbytes(0);
$course->setVisible(0);
$course->setHiddensections(0);
$course->setGroupmode(0);
$course->setGroupmodeforce(0);
$course->setLang('');
$course->setTheme('');
$course->setCost('');
$course->setMetacourse(0);
*/
$res=$moodle->add_course($lr->getClient(),$lr->getSessionKey(),$course);
print_r($res);
print($res->getCourses());

$moodle->logout($lr->getClient(),$lr->getSessionKey());

?>
