<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Add, Edit or delete a course
* @param int $client
* @param string $sesskey
* @param courseDatum $course
* @return  editedRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$course= new courseDatum();
$course->setAction('');
$course->setId(0);
$course->setCategory(0);
$course->setSortorder(0);
$course->setFullname('');
$course->setShortname('');
$course->setIdnumber('');
$course->setSummary('');
$course->setFormat('');
$course->setShowgrades(0);
$course->setNewsitems(0);
$course->setNumsections(0);
$course->setMarker(0);
$course->setMaxbytes(0);
$course->setVisible(0);
$course->setHiddensections(0);
$course->setGroupmode(0);
$course->setGroupmodeforce(0);
$course->setLang('');
$course->setTheme('');
$course->setTimecreated(0);
$course->setTimemodified(0);
$res=$client->editCourse($lr->getClient(),$lr->getSessionKey(),$course);
print_r($res);
print($res->getId());
print($res->getError());
print($res->getStatus());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
