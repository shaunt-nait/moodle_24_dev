
<?php

header('Access-Control-Allow-Origin: *');
require_once("../../config.php");
require_once("../../course/lib.php");

$courseId   = required_param('id', PARAM_INT); // Course id
$type   = optional_param('type', null, PARAM_TEXT);
$problem_description = optional_param('description', null, PARAM_TEXT);
$course = $DB->get_record('course', array('id' => $courseId));
$StudentAccessDate = optional_param('StudentAccessDate', null, PARAM_TEXT);
$ArchivedDate = optional_param('ArchivedDate', null, PARAM_TEXT);
$DeletedDate = optional_param('DeletedDate', null, PARAM_TEXT);
$action = optional_param('action', null, PARAM_TEXT);

echo $ArchivedDate;


include 'aac_common.php';

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
echo getHTML($course, $USER->username, $StudentAccessDate, $ArchivedDate, $DeletedDate, $action);
echo getEndOfFormAACModifyDates();
echo $OUTPUT->footer();



function getHTML($course, $userName, $StudentAccessDate, $ArchivedDate, $DeletedDate, $action)
{
    //echo $userName;
    
    $client = get_ws_client();
	$param->moodleCourseId = $course->id;
	$param->userNameRequestingData = $userName;
    $param->StudentAccessDate = $StudentAccessDate;
    $param->ArchivedDate = $ArchivedDate;
    $param->DeletedDate = $DeletedDate;
    $param->action = $action;
    
    $courseDates = $client->GetCourseDates($param)->GetCourseDatesResult;
    $isSaved =  $courseDates->IsSaved;
    if($isSaved == "1")
    {
        $html .= '<div class="aac_head" style="margin-bottom:10px">Request Submitted</div>';
        $html .= '<p>You request has been submitted</p>';
        $html .= '<a  href="index.php?id=' .$course->id. '">Return to Course Administration</a>';
        return $html;
    }   
    

    $html ='<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>';
    $html .='<script type="text/javascript" src="aac_moodle.1.1.js"></script>';
    $html .='<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>';
    $html .='<script>';
    $html .='    $(function() {';
    $html .='   $( ".datePicker" ).datepicker();';
    $html .='   $( ".datePicker" ).datepicker( "option", "dateFormat", "MM d, yy" );';
    $html .='   });';
    $html .='   </script>';
    $html .= '<form  method="get" id="form_search">';    
    $html .= '<input type="hidden" name="id" value="' .  $course->id .'"/>';
    $html .= '<div id="aac_page_div">';
    $html .= '  <div class="aac_form">';
    $html .= '      <h1 class="large_gear">modify dates</h1>';
    $html .= '      <table>';
    if($courseDates->StudentAccessDate != "N/A")
    {
        $html .= '          <tr><td><b>Student Access</b><p>The date students will have access to this course. Student enrollment is handled by a batch process that runs hourly. </p></td><td><input type="text" name="StudentAccessDate"  class="datePicker" id="dateStudentAccess" readonly="readonly" value="' .$courseDates->StudentAccessDate.'"  /></td></tr>';
    }
    if($courseDates->ArchivedDate != "N/A")
    {
        $html .= '          <tr><td><b>Course Archived</b><p>The date the course is changed to archived status. When a course is in archived status, students will only get read-only access. They will not be able take quizzes, join discussions, edit wikis etc.</p></td><td><input type="text" name="ArchivedDate" class="datePicker" id="dateArchivedDate" readonly="readonly" value="' .$courseDates->ArchivedDate.'" /></td></tr>';
    }
    if($courseDates->DeletedDate != "N/A")
    {
        $html .= '          <tr><td><b>Course Deletion</b><p>The date the course is deleted from the server. It may take up to 7 days from this date for the course to be deleted. Once a course is deleted it is not recoverable. </p></td><td><input type="text" name="DeletedDate"  class="datePicker" id="dateDeletedDate" readonly="readonly" value="' .$courseDates->DeletedDate.'" /></td></tr>';
    }
    $html .= '      </table>';
    $html .=  '    <input type="submit" name="action" value="save" />';   
    $html .=  '    <a class="btnCancel" href="index.php?id=' .$course->id. '">cancel</a>';  
    $html .= '  </div>';
    $html .= '</div>';
    $html .= '</form>';
    
    
   
    return $html;

}
