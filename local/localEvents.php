<?php
require_once($CFG->libdir.'/gdlib.php');

function role_unassigned_handler($roledata)
{
	global $DB;
	return $DB->delete_records('role_assignments_class_sections',array('roleassignmentsid' =>$roledata->id));	
}

function course_deleted_handler($roledata)
{
	global $DB;
	
	return $DB->delete_records_select('role_assignments_class_sections',
		'not roleassignmentsid in 
		(
			select id from mdl_role_assignments
		)');
}

?>