
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
    $html = '<div id="aac_page_div" >';
    $html .= '  <h1>Who Should I contact for Support?</h1>';
    $html .= '  <h2>Instructor:</h2>';
    $html .= '  <p>Instructors are your first point of contact for Moodle support. You can find their contact information in the course syllabus. They can help you with:</p>';
    $html .= '      <ul style="float:none">';
    $html .= '          <li>Enrollment issues</li>';
    $html .= '          <li>Course related content</li>';
    $html .= '          <li>Functional - Submitting assignments, taking quizzes, etc.</li>';
    $html .= '      </ul>';
    $html .= '  <h2>Student Success Contact Centre (SSCC) (<a href="http://www.nait.ca/39042.htm">link</a>)</h2>';
    $html .= '  <p>The SSCC can provide limited technical support:</p> ';
    $html .= '  <ul style="float:none">';
    $html .= '      <li>Login Issues/Password Reset</li>';
    $html .= '      <li>Browser Troubleshooting</li>';
    $html .= '      <li>Escalate major technical issues to Help Desk</li>';
    $html .= '  </ul>';
    $html .= '</div>';    
    

	return $html;   
}
