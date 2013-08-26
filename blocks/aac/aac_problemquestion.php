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
    $descriptionLabel = "<b>Describe the problem in detail.</b> By outlining when and how the problem occurs, NAIT support staff can better identify the problem and help you.";
}
else if($type == "question")
{
    $title = "Ask a question";
    $heading = '<h1 class="large_question">Ask a question</h1>';
    $descriptionLabel = "What is your question?";
}
else //admin
{
    $title = "Get Moodle support";
    $heading = '<h1 class="large_gear">Get Moodle support</h1>';
    $descriptionLabel = "What support do you need?";
}

include 'aac_common_headers.php';
include 'aac_common.php';
try
{
    if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
        $response = servicenow_moodlebroken($USER->username, $courseId, $problem_description, $type);
        $html = getStartOfForm();
        $html .=  ShowPostBackForm($response->ServiceNowMoodleBrokenResult->IsErrored, $response->ServiceNowMoodleBrokenResult->ErrorMessage , $title,  $course->shortname, $response->ServiceNowMoodleBrokenResult->IncidentNumber, $courseId);
        $html .= getEndOfForm();
        echo $html;
    }
    else
    {    
        echo getHTML($courseId, $course,  $heading, $descriptionLabel  );
    }
    echo $OUTPUT->footer();
}
catch(Exception $e)
{
    echo showFriendlyErrorMessage($e);
}


function getStartOfForm()
{
    $html ='<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>';
    $html .='<script type="text/javascript" src="aac_moodle.1.1.js?a=1"></script>';
    $html .= '<div id="aac_page_div">';
    $html .= '<div class="aac_form" >';    
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

function getHTML($courseId, $course,  $heading, $descriptionLabel) {
	global $USER;

    $html = getStartOfForm();
    $html .= $heading;
    $html .= '<ul>';
    $html .= '    <li><span style="color:#777">Opened by: </span>'.$USER->firstname.' '.$USER->lastname.' ('.$USER->email.')</li>';
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


function servicenow_moodlebroken($userName, $courseid, $problem_description, $type) {
    //   global $CFG, $USER;
    
	$client = get_ws_client();
	$param->moodleCourseId = $courseid;
	$param->userNameRequestedFor =  $userName;
    $param->description = $problem_description;
    $param->type = $type;
	$response = $client->ServiceNowMoodleBroken($param);
    
    return $response;    
}

