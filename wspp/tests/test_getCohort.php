<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get a cohort record for specified id and field
* @param int $client
* @param string $sesskey
* @param string $cohortid
* @param string $cohortidfield
* @return  cohortRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->getCohort($lr->getClient(),$lr->getSessionKey(),'','');
print_r($res);
print($res->getError());
print($res->getId());
print($res->getContextid());
print($res->getName());
print($res->getDescription());
print($res->getIdnumber());
print($res->getComponent());
print($res->getTimecreated());
print($res->getTimemodified());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
