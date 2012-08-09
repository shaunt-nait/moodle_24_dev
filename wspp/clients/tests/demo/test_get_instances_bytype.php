<?php
require_once ('../MoodleWS.php');

$moodle=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get resources in courses
* @param integer $client
* @param string $sesskey
* @param (getCoursesInput) array of string $courseids
* @param string $idfield
* @param string $type
* @return getResourcesReturn
*/

$lr=$moodle->login(LOGIN,PASSWORD);
$courseids=array(1,2,3,4);
$res=$moodle->get_instances_bytype($lr->getClient(),$lr->getSessionKey(),$courseids,'id','forum');
print_r($res);
print($res->getResources());

$moodle->logout($lr->getClient(),$lr->getSessionKey());

?>
