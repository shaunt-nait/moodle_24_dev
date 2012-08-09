<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get users having a role in a course
* @param int $client
* @param string $sesskey
* @param string $idcourse
* @param string $idfield
* @param string $idrole
* @param string $idrolefield
* @return  getUsersReturn
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_users_bycourse($lr->getClient(),$lr->getSessionKey(),'','','','');
print_r($res);
print($res->getUsers());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
