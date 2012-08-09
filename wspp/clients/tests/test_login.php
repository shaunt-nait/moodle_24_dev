<?php
require_once ('../MoodleWS.php');

$moodle=new MoodleWS();
//require_once ('../auth.php');
/**test code for MoodleWS Client Login
* @param string $username
* @param string $password
* @return loginReturn
*/
$res=$moodle->login('moodle_ws','ws');
//print_r($res);
$client = $res->getClient();
$sesskey = $res->getSessionkey();

$moodle->exec_copy_content($client, $sesskey, 7, 8);


?>
