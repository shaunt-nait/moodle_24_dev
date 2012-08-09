<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get a list of available formats.
* @param integer $client
* @param string $sesskey
* @return  getFormatsOutput
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->get_formats($lr->getClient(),$lr->getSessionKey());
print_r($res);
print($res->getFormats());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
