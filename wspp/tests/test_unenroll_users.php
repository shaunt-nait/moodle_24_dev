<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Unenroll Users in a Course
* @param int $client
* @param string $sesskey
* @param string[] $usernames
* @param int $roleid
* @param string $cidnumber
* @return  unenrollUsersOutput
*/

$lr=$client->login(LOGIN,PASSWORD);
$usernames=array();
$res=$client->unenroll_users($lr->getClient(),$lr->getSessionKey(),$usernames,0,'');
print_r($res);
print($res->getUsers());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
