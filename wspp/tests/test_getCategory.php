<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get a category record for specified id and field
* @param int $client
* @param string $sesskey
* @param string $categoryid
* @param string $categoryidfield
* @return  categoryRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->getCategory($lr->getClient(),$lr->getSessionKey(),'','');
print_r($res);
print($res->getError());
print($res->getId());
print($res->getName());
print($res->getDescription());
print($res->getParent());
print($res->getSortorder());
print($res->getCoursecount());
print($res->getVisible());
print($res->getTimemodified());
print($res->getDepth());
print($res->getPath());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
