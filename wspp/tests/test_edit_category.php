<?php
require_once ('../classes/MoodleWS.php');

$client=new MoodleWS();
require_once ('../auth.php');
/**test code for MoodleWS: Add/ Update a category.
* @param integer $client
* @param string $sesskey
* @param categoryDatum $category
* @return  categoryRecord
*/

$lr=$client->login(LOGIN,PASSWORD);
$category= new categoryDatum();
$category->setAction('');
$category->setId(0);
$category->setName('');
$category->setDescription('');
$category->setParent(0);
$category->setSortorder(0);
$category->setCoursecount(0);
$category->setVisible(0);
$category->setTimemodified(0);
$category->setDepth(0);
$category->setPath('');
$res=$client->edit_category($lr->getClient(),$lr->getSessionKey(),$category);
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
