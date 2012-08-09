<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Affect a wiki to section
* @param int $client
* @param string $sesskey
* @param int $wikiid
* @param int $sectionid
* @param int $groupmode
* @param int $visible
* @return  affectRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$res=$client->affect_wiki_to_section($lr->getClient(),$lr->getSessionKey(),0,0,0,0);
print_r($res);
print($res->getError());
print($res->getStatus());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
