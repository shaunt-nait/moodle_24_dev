<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: unAffect a user to group
* @param int $client
* @param string $sesskey
* @param int $userid
* @param int $groupid
* @return  affectRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->remove_user_from_cohort($lr->getClient(),$lr->getSessionKey(),0,0);
print_r($res);
print($res->getError());
print($res->getStatus());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
