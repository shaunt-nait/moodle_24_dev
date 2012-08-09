<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Add and Enroll Users in a Course
* @param int $client
* @param string $sesskey
* @param addEnrollUsersInput $users
* @param int $roleid
* @param string $cidnumber
* @param string $enrolltype
* @return  addEnrollUsersOutput
*/

$lr=$client->login(LOGIN,PASSWORD);
$users= new addEnrollUsersInput();
$users->setUsers(array());
$res=$client->add_enroll_users($lr->getClient(),$lr->getSessionKey(),$users,0,'','');
print_r($res);
print($res->getUsers());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
