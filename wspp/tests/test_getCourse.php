<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get a course record for specified id and field
* @param int $client
* @param string $sesskey
* @param string $courseid
* @param string $courseidfield
* @return  courseRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->getCourse($lr->getClient(),$lr->getSessionKey(),'','');
print_r($res);
print($res->getError());
print($res->getId());
print($res->getCategory());
print($res->getSortorder());
print($res->getFullname());
print($res->getShortname());
print($res->getIdnumber());
print($res->getSummary());
print($res->getFormat());
print($res->getShowgrades());
print($res->getNewsitems());
print($res->getNumsections());
print($res->getMarker());
print($res->getMaxbytes());
print($res->getVisible());
print($res->getHiddensections());
print($res->getGroupmode());
print($res->getGroupmodeforce());
print($res->getLang());
print($res->getTheme());
print($res->getTimecreated());
print($res->getTimemodified());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
