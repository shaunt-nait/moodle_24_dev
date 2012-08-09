<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Add and/or remove users from a cohort
* @param int $client
* @param string $sesskey
* @param string $cohortid
* @param string $cohortidfield
* @param userCohortEnrolmentItem[] $userEnrolments
* @return  affectRecord[]
*/

$lr=$client->login(LOGIN,PASSWORD);
$userEnrolments=array();
$res=$client->modifyUserCohortEnrolments($lr->getClient(),$lr->getSessionKey(),'','',$userEnrolments);
print_r($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
