<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Add and/or remove users from a course
* @param int $client
* @param string $sesskey
* @param string $cohortid
* @param string $cohortidfield
* @param string $courseid
* @param string $courseidfield
* @param string $roleid
* @param string $roleidfield
* @param boolean $addcohorttocourse
* @return  affectRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->modifyCourseCohortLink($lr->getClient(),$lr->getSessionKey(),'','','','','','',false);
print_r($res);
print($res->getError());
print($res->getStatus());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
