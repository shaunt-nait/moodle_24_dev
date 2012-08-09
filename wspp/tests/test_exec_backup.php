<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Execute backup of a course
* @param int $client
* @param string $sesskey
* @param int $courseid
* @param backupPreferences $prefs
* @return  string
*/

$lr=$client->login(LOGIN,PASSWORD);
$prefs= new backupPreferences();
$prefs->setMetacourse(false);
$prefs->setUsers(false);
$prefs->setLogs(false);
$prefs->setUser_files(false);
$prefs->setCourse_files(false);
$prefs->setSite_files(false);
$prefs->setMessages(false);
$res=$client->exec_backup($lr->getClient(),$lr->getSessionKey(),0,$prefs);
print($res);
$client->logout($lr->getClient(),$lr->getSessionKey());

?>
