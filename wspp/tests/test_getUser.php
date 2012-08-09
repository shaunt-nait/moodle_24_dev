<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get a user record for specified id and field
* @param int $client
* @param string $sesskey
* @param string $userid
* @param string $useridfield
* @return  userRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->getUser($lr->getClient(),$lr->getSessionKey(),'','');
print_r($res);
print($res->getError());
print($res->getId());
print($res->getConfirmed());
print($res->getPolicyagreed());
print($res->getDeleted());
print($res->getUsername());
print($res->getAuth());
print($res->getPassword());
print($res->getIdnumber());
print($res->getFirstname());
print($res->getLastname());
print($res->getEmail());
print($res->getEmailstop());
print($res->getIcq());
print($res->getSkype());
print($res->getYahoo());
print($res->getAim());
print($res->getMsn());
print($res->getPhone1());
print($res->getPhone2());
print($res->getInstitution());
print($res->getDepartment());
print($res->getAddress());
print($res->getCity());
print($res->getCountry());
print($res->getLang());
print($res->getTimezone());
print($res->getLastip());
print($res->getTheme());
print($res->getDescription());
print($res->getMnethostid());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
