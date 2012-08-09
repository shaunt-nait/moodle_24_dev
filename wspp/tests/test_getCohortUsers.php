<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get users enrolled in cohort
* @param int $client
* @param string $sesskey
* @param string $cohortid
* @param string $cohortidfield
* @return  userRecord[]
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->getCohortUsers($lr->getClient(),$lr->getSessionKey(),'','');
print_r($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
