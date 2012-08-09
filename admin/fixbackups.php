<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This script checks for orphaned course modules which may be breaking,
 * backups and provides a way to delete them from "course_modules" table.
 *
 * @package    fix backups
 * @copyright  2012 Mark Ward {mark.ward@gmail.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_login();
require_capability('moodle/site:config', get_context_instance(CONTEXT_SYSTEM, SITEID));

$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->set_url('/admin/fixbackups.php');
$PAGE->set_pagetype('admin-fix-backups');
$PAGE->set_pagelayout('admin');
$PAGE->blocks->add_region('content');
$PAGE->set_title('Orphaned Course Modules');
$PAGE->set_heading('Orphaned Course Modules');
echo $OUTPUT->header();

$confirm = optional_param('confirm', 0, PARAM_BOOL);
$fixcourses = optional_param('courses', 0, PARAM_TEXT);

global $DB;
$mods = $DB->get_records("modules", NULL);
$courses = $DB->get_records("course", NULL);
$count = 0;


if ($confirm && isset($fixcourses)) {
    require_sesskey();
	$fixcourses = explode(",",$fixcourses);
	
	foreach ($fixcourses as $courseid){
		$result = NULL;
		$cmodules = $DB->get_records("course_modules", array('course'=>$courseid));
		foreach($cmodules as $cmodule){
			
			$real = NULL;
			$real = $DB->get_record($mods[$cmodule->module]->name, array("id"=>$cmodule->instance));
			if($real==NULL){
				$DB->delete_records("course_modules", array('id'=>$cmodule->id));
				echo("<b>deleted</b> ".$mods[$cmodule->module]->name." ".$cmodule->id.", ");
				echo("<br />");
				$count++;
			}
		}
	}
	echo("<br />");
	echo("<h3>Deleted ".$count." orphaned course modules</h3>");	
	
}
else{
	echo("<table style='margin: 0 auto;'>
		<tr>
			<th>Courses</th>
			<th>Orphan Modules</th>
		</tr>");
	
	foreach ($courses as $course){
		$result = NULL;
		$cmodules = $DB->get_records("course_modules", array('course'=>$course->id));
		foreach($cmodules as $cmodule){
			
			$real = NULL;
			$real = $DB->get_record($mods[$cmodule->module]->name, array("id"=>$cmodule->instance));
			if($real==NULL){
				$result .= ($mods[$cmodule->module]->name." ".$cmodule->id.", ");
				$count++;
			}
		}
		
		if($result != NULL){
			$fixcourses .= $course->id.",";
			echo("<tr>");
			echo("<td style='text-align:right;'><a href='".$CFG->wwwroot."/course/view.php?id=".$course->id."'>".$course->shortname."</a></td><td>".$result."</td>");
			echo("</tr>");
		}
	}
	echo("</table><br />");
	
	if($count > 0){
		$url = new moodle_url('/admin/fixbackups.php', array('sesskey'=>sesskey(), 'courses'=>$fixcourses, 'confirm'=>1));
		$button = new single_button($url, get_string('confirm', 'moodle'), 'post');
		$return = new moodle_url('/');
		if (isset($_SERVER['HTTP_REFERER']) and !empty($_SERVER['HTTP_REFERER'])) {
			if ($_SERVER['HTTP_REFERER'] !== "$CFG->wwwroot/$CFG->admin/index.php") {
				$return = $_SERVER['HTTP_REFERER'];
			}
		}	
		echo $OUTPUT->confirm("<h3>Delete ".$count." orphaned course modules?</h3>", $button, $return);
	}else{
		echo "<h3 style='text-align:center;'>No orphaned course modules found</h3>";
	}
}

echo $OUTPUT->footer();

?>

