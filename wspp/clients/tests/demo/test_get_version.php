<?php
require_once ('../MoodleWS.php');

$moodle=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: get current version
* @param integer $client
* @param string $sesskey
* @return string
*/

$lr=$moodle->login(LOGIN,PASSWORD);
$res=$moodle->get_version($lr->getClient(),$lr->getSessionKey());
print($res);
$moodle->logout($lr->getClient(),$lr->getSessionKey());

?>
