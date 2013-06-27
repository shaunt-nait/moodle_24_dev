<?php
header('Access-Control-Allow-Origin: *');
require_once("../../config.php");
require_once("../../course/lib.php");

$courseId   = required_param('id', PARAM_INT); // Course id
$title = "remove me";
include 'aac_common_headers.php';
include 'aac_common.php';


$isStudent = false;
$roles = get_user_roles($context, $USER->id);
foreach($roles as $role)
{
    if($role->shortname == "student")
        $isStudent = true;
}


if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
    $response = removeMe($USER->username, $courseId);   

    $html = '<div id="aac_page_div">';
    $html .= '  <div class="aac_form">';
    $html .= ShowPostBackForm($response->GetRemoveMeViewResult->IsErrored, $response->GetRemoveMeViewResult->ErrorMessage , $title,  $course->shortname, null, null);
}
else
{
    if ($isStudent) {
        echo "<h1>Unauthorized access</h1>";  
    }
    else
    {
        try
        {
        
            echo getHTML( $course, $title, has_capability('moodle/course:update', $context));
            echo getEndOfFormAACRemoveMe();        
        }
        catch(Exception $e)
        {
            echo showFriendlyErrorMessage($e);
        }
    }
}


    

echo $html .= '</div>'; 
echo $OUTPUT->footer();

function getHTML($course, $title, $hasEdit)
{
    $html =  '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>';
    $html .= '<script type="text/javascript" src="aac_moodle.1.1.js"></script>';
    $html .= '<div id="aac_page_div">';
    $html .= '  <div class="aac_form">';
    $html .= '      <h1 class="large_gear">' .$title. '</h1>';
    $html .= '      <div style="font-size:13pt"><label>Course:</label> ' .$course->shortname. '<b></b></div>';
    $html .= '      <p  style="margin-top:10px;font-size:13pt">Are you sure you want to remove yourself from this course?</p>';
    $html .= '      <form  method="post" id="form_search">';  
    $html .= '         <input type="submit" name="action" value="yes" />';  
    if($hasEdit)
    {
        $html .= '         <a class="btnCancel" href="index.php?id=' .$course->id. '">no</a>';  
    }
    else
    {
        $html .= '         <a class="btnCancel" href="/course/view.php?id=' .$course->id. '">no</a>';
    }
    $html .= '     </form>';
    $html .= '      <p  style="margin-top:10px;font-size:10pt">Please note: After removing yourself, you will have to ask either an instructor in this course or your Moodle Local Area Administrator to add you back in.</p>';

    $html .= '  </div>';    
    return $html;
}


function removeMe($userName, $courseid) {
    //   global $CFG, $USER;
	$client = get_ws_client();

	$param->moodleCourseId = $courseid;
    $param->userNameRequestedFor = $userName;
	$response = $client->GetRemoveMeView($param);
    return $response;    
}


