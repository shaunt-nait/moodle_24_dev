<?php
require_once ('../MoodleWS.php');

$moodle=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Get All Labels
* @param integer $client
* @param string $sesskey
* @param string $fieldname
* @param string $fieldvalue
* @return getAllLabelsReturn
*/

$lr=$moodle->login(LOGIN,PASSWORD);
$res=$moodle->get_all_labels($lr->getClient(),$lr->getSessionKey(),'','');
print_r($res);
print($res->getLabels());

$moodle->logout($lr->getClient(),$lr->getSessionKey());

?>
