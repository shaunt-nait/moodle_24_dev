<?php
require_once ('../MoodleWS.php');

$moodle=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: add on course
* @param integer $client
* @param string $sesskey
* @param groupingDatum $grouping
* @return editGroupingsOutput
*/

$lr=$moodle->login(LOGIN,PASSWORD);
$grouping= new groupingDatum();
//grouping->setAction('');
//$grouping->setId(0);
$grouping->setCourseid(4);
$grouping->setName('grouping a virer');
$grouping->setDescription('groupement 1 a virer');
$res=$moodle->add_grouping($lr->getClient(),$lr->getSessionKey(),$grouping);
print_r($res);
print($res->getGroupings());

$moodle->logout($lr->getClient(),$lr->getSessionKey());

?>
