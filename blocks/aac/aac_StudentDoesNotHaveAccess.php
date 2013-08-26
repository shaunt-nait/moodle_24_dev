
<?php

header('Access-Control-Allow-Origin: *');
require_once("../../config.php");
require_once("../../course/lib.php");

$courseId   = required_param('id', PARAM_INT); // Course id
$studentName   = optional_param('studentName', null, PARAM_TEXT);
$studentId   = optional_param('studentId', null, PARAM_TEXT);
$description = optional_param('description', null, PARAM_TEXT); 
$title = "student does not have access";


$course = $DB->get_record('course', array('id' => $courseId));

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
$PAGE->set_title($course->shortname.': ' .$title);
$PAGE->set_heading($course->shortname.': ' .$title);
$PAGE->set_course($course);
$PAGE->navbar->add($course->shortname, new moodle_url('/course/view.php?id=' .$courseId));
$PAGE->navbar->add('Manage My Course', new moodle_url('index.php?id=' .$courseId));
$PAGE->navbar->add($title);

echo $OUTPUT->header();
try
{
    if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
    

        $response = studentDoesNotHaveAccess($USER->username, $courseId, $studentName, $studentId, $description);
        $html .= '<div id="aac_page_div">';
        $html .= '  <div class="aac_form">';
        if($response->ServiceNowStudentDoesNotHaveAccessResult->IsErrored != "1")
        {    
            $html .=  '<h1>submitted</h1>';
            $html .=  '<p>Ticket <b>' .$response->ServiceNowStudentDoesNotHaveAccessResult->IncidentNumber. '</b> has been created. You should recieve an email shortly.</p>';
        
        }
        else
        {
    
            $html .=  '<h1>error</h1>';
            $html .=  '<p>Ticket has not been created.</p>';
            $html .=  '<p>Server Error Message:' .$response->ServiceNowStudentDoesNotHaveAccessResult->ErrorMessage.  '</p>';
            $html .=  '<p>Please email the help desk at helpline@nait.ca.</p>';
        }
        $html .= '      <a class="btnCancel" href="index.php?id=' .$courseId. '">ok</a>';  
        $html .= '  </div>';
        echo $html;
    }
    else
    {
        echo getHTML( $course, $title);
    }
    echo getEndOfForm();
}
catch(Exception $e)
{
    echo showFriendlyErrorMessage($e);
}
echo $OUTPUT->footer();


function getHTML($course, $title)
{
    $html ='<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>';
    $html .='<script type="text/javascript" src="aac_moodle.1.1.js?a=1"></script>';
    $html .='<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>';
    $html .= '<div id="aac_page_div">';
    $html .= '  <div class="aac_form" >';
    $html .= '      <h1 class="large_warning">' .$title. '</h1>';
    $html .= '      <div style="font-size:13pt"><label>Course:</label> ' .$course->shortname. '<b></b></div>';
    //$html .= '<p  style="margin-top:10px;font-size:13pt">Are you sure you want to remove yourself from this course?</p>';
    //$html .= '<form method="post" id="form_search"  onsubmit="return aac_moodle.validate_brokenform(this)" >';
    $html .= '<form  method="post" id="form_search" onsubmit="return aac_moodle.validate_StudentDoesNotHaveAccessForm(this)">';  
    $html .= '  <ul class="aac_fieldList">';    
    $html .= '      <li><label>Student Name:</label><input type="text" name="studentName"/></li>';
    $html .= '      <li><label>Student Id (optional):</label><input type="text"  name="studentId"/></li>';
    $html .= '      <li><label>Problem Description:</label><textarea rows="4" name="description" cols="50"></textarea></li>';
    $html .= '  </ul>';
    $html .= '    <input type="submit" name="action" value="submit" />';   
    $html .= '    <a class="btnCancel" href="index.php?id=' .$course->id. '">cancel</a>';
    $html .= '</form>';
    $html .= '</div>';
    return $html;
}
function getEndOfForm()
{

    $html .= '<h3>What happens when I submit this form?</h3>';
    $html .= '<ol>';
    $html .= '    <li>When you submit this form, a ticket is created in NAIT\'s IT Service Management System.</li>'; 
    $html .= '    <li>You will be notified via email that the ticket has been created.</li>';
    $html .= '    <li>The ticket will be assigned to an ITS Helpdesk analyst.</li>';
    $html .= '    <li>If the analyst can\'t help you, they will forward the call to either your Local Area Expert (LAE) or to Academic IT Services (AITS). The analyst or expert may call or email you to get more information.</li>';
    $html .= '    <li>Once the problem is solved, they will close the call.</li>';
    $html .= '    <li>You will be notified that the call has been closed via email.</li>';
    $html .= '</ol>';
    $html .= '<img src="flowchart.png"/>';     
    $html .= '</div>';
    return $html;
}
function studentDoesNotHaveAccess($userName, $courseid, $studentName, $studentId, $description) {
    global $CFG, $USER;
	$client = get_ws_client();
	$param->moodleCourseId = $courseid;
    $param->userNameRequestedFor = $userName;
    $param->studentName = $studentName;
    $param->studentId = $studentId;
    $param->description = $description;
	$response = $client->ServiceNowStudentDoesNotHaveAccess($param);    
    return $response;    
    //return "hit";
}

