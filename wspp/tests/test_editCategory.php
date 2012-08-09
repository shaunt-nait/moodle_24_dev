<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Add, Edit or delete a category
* @param int $client
* @param string $sesskey
* @param categoryDatum $category
* @return  editedRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$category= new categoryDatum();
$category->setAction('');
$category->setId(0);
$category->setName('');
$category->setDescription('');
$category->setParent(0);
$category->setSortorder(0);
$category->setVisible(0);
$category->setDepth(0);
$category->setPath('');
$category->setTheme('');
$res=$client->editCategory($lr->getClient(),$lr->getSessionKey(),$category);
print_r($res);
print($res->getId());
print($res->getError());
print($res->getStatus());

$client->logout($lr->getClient(),$lr->getSessionKey());

?>
