<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get users enrolled in course and specified role
* @param int $client
* @param string $sesskey
* @param string $courseid
* @param string $courseidfield
* @param string $roleid
* @param string $roleidfield
* @return  userRecord[]
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->getCourseUsers($lr->getClient(),$lr->getSessionKey(),'','','','');
print_r($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
