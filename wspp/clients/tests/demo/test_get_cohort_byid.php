<?php
require_once ('../MoodleWS.php');

$moodle=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get Course Information
* @param integer $client
* @param string $sesskey
* @param string $info
* @param integer $courseid
* @return getCohortsReturn
*/

$lr=$moodle->login(LOGIN,PASSWORD);
$res=$moodle->get_cohort_byid($lr->getClient(),$lr->getSessionKey(),'2',0);
print_r($res);
print($res->getCohorts());

$moodle->logout($lr->getClient(),$lr->getSessionKey());

?>
