<?php
header('Access-Control-Allow-Origin: *');
require_once("../../config.php");
require_once("../../course/lib.php");

$courseId   = required_param('id', PARAM_INT); // Course id
$type   = optional_param('type', null, PARAM_TEXT);
$problem_description = optional_param('description', null, PARAM_TEXT); 


if($type == "broken")
{
    $title = "Something is broken";
    $heading = '<h1 class="large_warning">Something is broken!</h1>';
    $descriptionLabel = "Describe the problem";
}
else if($type == "question")
{
    $title = "Ask a question";
    $heading = '<h1 class="large_question">Ask a question</h1>';
    $descriptionLabel = "What is your question?";
}
else //admin
{
    $title = "Get admin support";
    $heading = '<h1 class="large_gear">Get admin support</h1>';
    $descriptionLabel = "What support do you need?";
}

include 'aac_common_headers.php';
include 'aac_common.php';

if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
    $response = servicenow_moodlebroken($USER->username, $courseId, $problem_description, $type == "broken" || $type == null );
    $html = getStartOfForm();
    $html .=  ShowPostBackForm($response->ServiceNowMoodleBrokenResult->IsErrored, $response->ServiceNowMoodleBrokenResult->ErrorMessage , $title,  $course->shortname, $response->ServiceNowMoodleBrokenResult->IncidentNumber);
    $html .= getEndOfForm();
    echo $html;
}
else
{

    
    echo getHTML($courseId, $course,  $heading, $descriptionLabel  );
}

echo $OUTPUT->footer();


function getStartOfForm()
{
    $html ='<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>';
    $html .='<script type="text/javascript" src="aac_moodle.1.1.js"></script>';
    $html .= '<div id="aac_page_div">';
    $html .= '<div class="aac_form" >';    
    return $html;
}

function getEndOfForm()
{
    $html .= '<h3>What happens when I submit this form?</h3>';
    $html .= '<ol>';
    $html .= '    <li>When you submit this form, a ticket is created in NAIT\'s Service Management System.</li>'; 
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

function getHTML($courseId, $course,  $heading, $descriptionLabel) {

    $html = getStartOfForm();
    $html .= $heading;
    $html .= '<ul>';
    $html .= '    <li><span style="color:#777">Opened by: </span>Mark Kitz (markk@nait.ca)</li>';
    $html .= '    <li><span style="color:#777">Course: </span>' .$course->shortname. ' - ' .$course->fullname. '</li>';
    $html .= '</ul>';
    
    $html .= '<form method="post" onsubmit="return aac_moodle.validate_brokenform(this)" >';
    $html .= '<p>' .$descriptionLabel. '</p>';
    $html .= '<textarea rows="8" name="description" style="padding:10px" cols="75"></textarea>';
    $html .= '<input type="submit" value="submit" />';
    $html .= '<a class="btnCancel" href="index.php?id=' .$courseId. '">cancel</a>';
    $html .= '</form>';
    $html .= '</div>';
   $html .= getEndOfForm();
	return $html;

}


function servicenow_moodlebroken($userName, $courseid, $problem_description, $isSomethingBroken) {
    //   global $CFG, $USER;
    
	$client = get_ws_client();
	$param->moodleCourseId = $courseid;
	$param->userNameRequestingData =  $userName;
    $param->description = $problem_description;
    $param->isSomethingBroken = $isSomethingBroken;
	$response = $client->ServiceNowMoodleBroken($param);
    
    return $response;    
}

