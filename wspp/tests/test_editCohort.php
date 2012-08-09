<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Add, Edit or delete a cohort
* @param int $client
* @param string $sesskey
* @param cohortDatum $cohort
* @return  editedRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$cohort= new cohortDatum();
$cohort->setAction('');
$cohort->setId(0);
$cohort->setCategoryid(0);
$cohort->setName('');
$cohort->setDescription('');
$cohort->setComponent('');
$cohort->setIdnumber('');
$res=$client->editCohort($lr->getClient(),$lr->getSessionKey(),$cohort);
print_r($res);
print($res->getId());
print($res->getError());
print($res->getStatus());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
