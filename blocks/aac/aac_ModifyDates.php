
<?php

header('Access-Control-Allow-Origin: *');
require_once("../../config.php");
require_once("../../course/lib.php");

$courseId   = required_param('id', PARAM_INT); // Course id
$type   = optional_param('type', null, PARAM_TEXT);
$problem_description = optional_param('description', null, PARAM_TEXT); 


$course = $DB->get_record('course', array('id' => $courseId));

if (!$course) {
    print_error("invalidcourseid");
}
require_login();

$context = get_context_instance(CONTEXT_COURSE, $course->id);
if (!$course->visible and !has_capability('moodle/course:viewhiddencourses', $context)) {
    print_error('coursehidden', '', $CFG->wwwroot .'/');
}

$PAGE->navbar->ignore_active();

$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/mod/acc/aac_course.php', array('id' => $course->id));
$PAGE->set_title($course->shortname.': Modify Dates');
$PAGE->set_heading($course->shortname.': Modify Dates');
$PAGE->set_course($course);
$PAGE->navbar->add($course->shortname, new moodle_url('/course/view.php?id=' .$courseId));
$PAGE->navbar->add('Course Administration', new moodle_url('index.php?id=' .$courseId));
$PAGE->navbar->add('Modify Dates');

echo $OUTPUT->header();
echo getHTML($course);
echo $OUTPUT->footer();


function getHTML($course)
{
    $html ='<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>';
    $html .='<script type="text/javascript" src="aac_moodle.1.1.js"></script>';
    $html .='<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>';
    $html .='<script>';
    $html .='    $(function() {';
    $html .='   $( ".datePicker" ).datepicker();';
    $html .='   $( ".datePicker" ).datepicker( "option", "dateFormat", "DD - MM d, yy" );';
    $html .='   });';
    $html .='   </script>';
    $html .= '<div id="aac_page_div">';
    $html .= '  <div class="aac_form">';
    $html .= '      <h1 class="large_gear">modify dates</h1>';
    $html .= '      <table>';
    $html .= '          <tr><td><b>Student Access</b><p>This is a description.</p></td><td><input type="text"  class="datePicker" id="dateStudentAccess" readonly="readonly" value="1/11/2013"  /></td></tr>';
//    $html .= '          <tr><td><b>Student Readonly</b><p>This is a description.</p></td><td><input type="text" class="datePicker" id="dateStudentReadOnly" readonly="readonly" /></td></tr>';
    $html .= '          <tr><td><b>Student Access Removed</b><p>This is a description.</p></td><td><input type="text" class="datePicker" id="dateStudentAccessRemoved" readonly="readonly" value="1/11/2013" /></td></tr>';
//    $html .= '          <tr><td><b>Instructor Access Removed</b><p>This is a description.</p></td><td><input type="text" class="datePicker" id="dateInstructorAccessRemoved" readonly="readonly" /></td></tr>';
//    $html .= '          <tr><td><b>Course Archived and Removed</b><p>This is a description.</p></td><td><input type="text" class="datePicker" id="dateCourseArchive" readonly="readonly" /></td></tr>';
    $html .= '      </table>';
    $html .=  '    <input type="submit" name="action" value="save" />';   
    $html .=  '    <a class="btnCancel" href="index.php?id=' .$course->id. '">cancel</a>';  
    $html .= '  </div>';
    $html .= '</div>';
    $html .= '<h3>What happens when I submit this form?</h3>';
    
   
    return $html;

}
