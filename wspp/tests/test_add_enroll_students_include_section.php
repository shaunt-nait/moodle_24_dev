<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Add and Enroll Users in a Course
* @param int $client
* @param string $sesskey
* @param UNKNOWN $students
* @param string $cidnumber
* @return  UNKNOWN
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->add_enroll_students_include_section($lr->getClient(),$lr->getSessionKey(),NULL,'');
print($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
