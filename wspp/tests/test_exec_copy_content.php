<?php
require_once ('../classes/MoodleWS.php');

/*
require_once('../../config.php');
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');

$bc = new backup_controller(backup::TYPE_1COURSE, 7, backup::FORMAT_MOODLE,
                            backup::INTERACTIVE_NO, backup::MODE_GENERAL, 7);
		
		$filename = 'forcopycontent_7_to_7_'.time().'.mbz';
		$bc->get_plan()->get_setting('filename')->set_value($filename);
		$bc->get_plan()->get_setting('users')->set_value(0);
		$bc->save_controller();
	    $bc->execute_plan();

$file = $DB->get_record('files', array('filename'=> $filename));
$fb = get_file_browser();
$fileinfo = $fb->get_file_info(get_context_instance_by_id($file->contextid), $file->component, $file->filearea, $file->itemid, $file->filepath, $file->filename);
//print_r($fileinfo);
$tmpdir = $CFG->dataroot . '/temp/backup';
$tempfilename = restore_controller::get_tempdir_name(7, 7);
$tempfilepathname = $tmpdir . '/' . $tempfilename;
echo $tempfilepathname;
$fileinfo->copy_to_pathname($tempfilepathname);

*/

$client=new MoodleWS();
try {
	$lr=$client->login('moodle_ws','ws');
	echo $lr->client;
}
catch(Exception $ex)
{
	echo $ex;
}
try{
$res=$client->exec_copy_content($lr->getClient(),$lr->getSessionKey(),7,8);
}
catch (Exception $e){
	echo $e;
	
}
//print($res);
//$client->logout($lr->getClient(),$lr->getSessionKey());

?>
