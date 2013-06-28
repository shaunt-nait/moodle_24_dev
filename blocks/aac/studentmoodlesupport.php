
<?php

/// Displays external information about a course
header('Access-Control-Allow-Origin: *');
require_once("../../config.php");
require_once("../../course/lib.php");

$courseId   = required_param('id',  PARAM_INT); // Course id
$course = $DB->get_record("course", array("id"=>$courseId));

include 'aac_common.php';

if (!$courseId){// and !$name) {
    print_error("unspecifycourseid");
}


if (!$course) {
    print_error("invalidcourseid");
}
require_login();

$context = get_context_instance(CONTEXT_COURSE, $course->id);

if (!$course->visible and !has_capability('moodle/course:viewhiddencourses', $context)) {
    print_error('coursehidden', '', $CFG->wwwroot .'/');
}

$PAGE->set_context($context);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('course-view-' . $course->format);
$PAGE->set_title($course->shortname.': Moodle Support');
$PAGE->set_heading($course->shortname.':  Moodle Support');
$PAGE->set_course($course);
$PAGE->navbar->add(' Moodle Support');

echo $OUTPUT->header();


    try
    {
        echo GetHTML($courseId);
    }
    catch (Exception $e)
    {
        echo showFriendlyErrorMessage($e);
    }
        

echo $OUTPUT->footer();

function GetHTML($courseId)
{
    $html = "<h1>Moodle Support</h1>";

	return $html;   
}
