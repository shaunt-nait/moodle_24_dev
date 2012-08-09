<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get user groups in all Moodle site
* @param int $client
* @param string $sesskey
* @param string $uid
* @param string $idfield
* @return  getCohortsReturn
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_my_cohorts($lr->getClient(),$lr->getSessionKey(),'','');
print_r($res);
print($res->getCohorts());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
