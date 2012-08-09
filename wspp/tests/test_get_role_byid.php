<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get one role defined in Moodle
* @param int $client
* @param string $sesskey
* @param string $value
* @return  getRolesReturn
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_role_byid($lr->getClient(),$lr->getSessionKey(),'');
print_r($res);
print($res->getRoles());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
