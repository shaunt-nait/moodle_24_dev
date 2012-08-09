<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get Course Information
* @param int $client
* @param string $sesskey
* @param string $info
* @param int $courseid
* @return  getGroupingsReturn
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_groupings_byname($lr->getClient(),$lr->getSessionKey(),'',0);
print_r($res);
print($res->getGroupings());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
