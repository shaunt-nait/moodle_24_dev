<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get Course Information
* @param int $client
* @param string $sesskey
* @param string $info
* @param int $courseid
* @return  getCohortsReturn
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_cohorts_byname($lr->getClient(),$lr->getSessionKey(),'',0);
print_r($res);
print($res->getCohorts());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
