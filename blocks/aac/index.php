
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
$PAGE->set_title($course->shortname.': Manage My Course');
$PAGE->set_heading($course->shortname.': Manage My Course');
$PAGE->set_course($course);
$PAGE->navbar->add('Manage My Course');

echo $OUTPUT->header();
if (has_capability('moodle/course:update', $context)) {

    try
    {
        echo GetMoodleAACPageViewData($courseId);
    }
    catch (Exception $e)
    {
        echo showFriendlyErrorMessage($e);
    }
        
}
else
{
    echo "<h1>Unauthorized access</h1>";
}
echo $OUTPUT->footer();

function GetMoodleAACPageViewData($courseId)
{
    $client = get_ws_client();
	$param->moodleCourseId = $courseId;
	$param->userNameRequestingData = $USER->username;
    $moodleAACPageViewData= $client->GetMoodleAACPageViewData($param)->GetMoodleAACPageViewDataResult;
    $html ='<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>';
    $html .='<script type="text/javascript" src="aac_moodle.1.1.js"></script>';
    $html .='<div id="aac_page_div" class="aac_main_div">';
    $html .='    <h1>Manage My Course</h1>';
    $html .='    <p style="font-size:12pt">' .$moodleAACPageViewData->Title. '</p>';
    $html .='    <div class="aac_row">';
    $html .='        <ul class="aac_requestgroup">';
    $html .='            <li class="aac_head">users</li>';
    $html .='            <li >';
    $html .='                 <ul class="innerItem">';
    if( count($moodleAACPageViewData->NameUserNameRoleViews->NameUserNameRoleView ) == 1 )
    {
        $html .=RenderStaff($moodleAACPageViewData->NameUserNameRoleViews->NameUserNameRoleView);
    }
    else
    {
        foreach($moodleAACPageViewData->NameUserNameRoleViews->NameUserNameRoleView as $user)
        {
            $html .=RenderStaff($user);
        }
    }
    if($moodleAACPageViewData->TotalNumberOfStudent == 0)
    {
        $html .='                     <li style="padding-top:10px">no students enrolled</li>';
    }
    else
    {   
        $html .='                     <li style="padding-top:10px">' .$moodleAACPageViewData->TotalNumberOfStudent. ' students enrolled (<a id="showhideStudentsLink" >view</a>)</li>';
    }
    $html .='                     <li>';
    $html .='                         <ul class="aac_studentList" >';
    
    
    

    foreach($moodleAACPageViewData->StudentSections->StudentSection as $section)
    {
    
        
        $html .='                             <li class="aac_studentList_section">' .$section->Section .'</li>';
        
        if(count($section->NameUserNameRoleViews->NameUserNameRoleView) > 0)
        {        
            foreach($section->NameUserNameRoleViews->NameUserNameRoleView as $student)
            {
                $html .='                             <li>' .$student->Name. ' <span>(' .$student->UserName.   ')</span></li>';
            }
        }
        else
        {
            $html .='                             <li><span>No students enrolled</span></li>';
        }
        
    }
    $html .='                         </ul>';
    $html .='                     </li>';
    $html .='                 </ul>';    
    $html .='            </li>';
    $html .='            <li>';
    $html .='                <ul class="aac_actions">';
    $html .='                    <li><a class="icon_gear" href="aac_removeme.php?id='.$courseId. '">remove me from this course</a></li>';
    $html .='                    <li><a class="icon_gear" href="aac_addremovecolleague.php?id='.$courseId. '">add or remove a colleague</a></li>';
    $html .='                    <li><a class="icon_warning" href="aac_StudentDoesNotHaveAccess.php?id=' .$courseId. '">my student does not have access!</a></li>';
    $html .='                </ul>';
    $html .='            </li>';
    $html .='        </ul>';
    
    if($moodleAACPageViewData->ShowStudentAccessDate == true || $moodleAACPageViewData->ShowArchivedDate == true || $moodleAACPageViewData->ShowDeletedDate == true  )
    {       
   
    
        $html .='        <ul >';
        $html .='            <li class="aac_head">dates</li>';
        $html .='            <li>';
        $html .='                <table  class="innerItem">';
        if($moodleAACPageViewData->ShowStudentAccessDate == true  )
        {  
        
            $html .='                    <tr>';
            $html .='                        <td>' .$moodleAACPageViewData->StudentAccessDate. '</td>';
            $html .='                        <td class="aac_tdDates">Student Access</td>';
            $html .='                    </tr>';
        
        }
        if($moodleAACPageViewData->ShowEnrollmentEndDate == true  )
        {  
            
            $html .='                    <tr>';
            $html .='                        <td>' .$moodleAACPageViewData->EnrollmentEndDate. '</td>';
            $html .='                        <td class="aac_tdDates">Course End Date</td>';
            $html .='                    </tr>';
            
        }
        if($moodleAACPageViewData->ShowArchivedDate == true  )
        {  
            
            $html .='                    <tr>';
            $html .='                        <td>' .$moodleAACPageViewData->ArchivedDate. '</td>';
            $html .='                        <td class="aac_tdDates">Course Archived</td>';
            $html .='                    </tr>';
            
        }
        if($moodleAACPageViewData->ShowDeletedDate == true  )
        {  
            
            $html .='                    <tr>';
            $html .='                        <td>' .$moodleAACPageViewData->DeletedDate. '</td>';
            $html .='                        <td class="aac_tdDates">Course Deleted</td>';
            $html .='                    </tr>';
            
        }
        $html .='                </table>';
        $html .='            </li>';
        $html .='            <li>';
        $html .='                <ul class="aac_actions"><li><a class="icon_gear" href="aac_ModifyDates.php?id=' .$courseId. '">modify dates</a></li></ul>';
        $html .='            </li>';
        $html .='        </ul>';    
    }
    $html .='        <div style="clear: both"></div>';
    $html .='    </div>';
    $html .='    <div class="aac_row" style="margin-top:20px">';
    $html .='        <ul>';
    $html .='            <li class="aac_head">get help</li>';
    $html .='            <li>';
    $html .='                <ul class="aac_actions">';
    $html .='                    <li><a class="icon_warning" href="aac_problemquestion.php?id=' .$courseId. '&type=broken">something is broken!</a></li>';
    $html .='                    <li><a class="icon_question" href="aac_problemquestion.php?id=' .$courseId. '&type=question">ask a question</a></li>';
    //$html .='                </ul>';
    //$html .='            </li>';
    //$html .='        </ul>';
    //$html .='        <ul>';
    //$html .='            <li class="aac_head">admin</li>';
    //$html .='            <li>';
    //$html .='                <ul class="aac_actions">';
    //$html .='                    <li><a class="icon_gear" href="#remove">clone this course</a></li>';
    //$html .='                    <li><a class="icon_gear" href="#remove">archive this course</a></li>';
    $html .='                    <li><a class="icon_gear" href="aac_problemquestion.php?id=' .$courseId. '&type=admin">get Moodle support</a></li>';
    $html .='                </ul>';
    $html .='            </li>';
    $html .='        </ul>';
    $html .='        <div style="clear: both"></div>';
    $html .='    </div>';
    $html .='</div>';

	return $html;   
}
function RenderStaff($user)
{
    return '                     <li>' .$user->Name. ' <span>(' .$user->UserName. ') '.$user->Role.  '</span></li>';
}
