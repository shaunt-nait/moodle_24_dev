<?php

/// Displays external information about a course
header('Access-Control-Allow-Origin: *');
require_once("../../config.php");
require_once("../../course/lib.php");

$courseId = required_param('id', PARAM_INT);
$searchText   = optional_param('searchText', null, PARAM_TEXT);
$addedUser = optional_param('addedUser', null, PARAM_TEXT);
$removeUser = optional_param('removeUser', null, PARAM_TEXT);
$action = optional_param('action', null, PARAM_TEXT);
$users = optional_param_array('user', null, PARAM_TEXT);
$roles = optional_param_array('role', null, PARAM_TEXT);


$fullNames = optional_param_array('fullName', null, PARAM_TEXT);
$title = "Add or remove a colleague";

include 'aac_common_headers.php';
include 'aac_common.php';

if (has_capability('moodle/course:update', $context)) {
    echo getHTML($USER->username, $courseId, $action, $course, $searchText, $addedUser, $removeUser, $users, $roles, $fullNames);
}
else
{
    echo "<h1>Unauthorized access</h1>";
}


echo $OUTPUT->footer();

function getHTML($userName, $courseId, $action, $course, $searchText, $addedUser, $removeUser, $users, $roles, $fullNames )
{
    $response = addRemoveCollegue($userName, $courseId, $action, $searchText, $addedUser, $removeUser, $users, $roles, $fullNames );    
    $isSaved =  $response->GetAddRemoveColleaguePageViewResult->IsSaved;
    $errorMessage = $response->GetAddRemoveColleaguePageViewResult->ErrorMessage;
    
    
    
    $html = '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js" type="text/javascript"></script>';
    $html .='<script type="text/javascript" src="aac_moodle.1.1.js?a=1"></script>';    
    if($isSaved == "1")
    {
        $html .= '<div class="aac_head" style="margin-bottom:10px">Request Submitted</div>';
        $html .= '<p>You request has been submitted</p>';
        $html .= '<a  href="index.php?id=' .$courseId. '">Return to Manage My Courses</a>';
       return $html;
    }   
    
    $html .= '<form  method="get" id="form_search">';    
    $html .= '<input type="hidden" name="id" value="' .  $courseId .'"/>';
    $html .= '<input type="hidden" name="addedUser"/>';
    $html .= '<input type="hidden" name="removeUser"/>';
    $html .= '<div id="aac_page_div">';    
    
    if($action != "search" && $action != "+ Add User" )
    {
        $html .= '<div  id="aac_staff" class="aac_form" >';
    }
    else
    {
        $html .= '<div  id="aac_staff" class="aac_form" style="display:none" >';
    }
        
    $html .=  '<h1>Staff</h1>';
    
    if($errorMessage != null)
    {
        $html .= '<p style="color:red">' .$errorMessage. '</p>';
    }
    
    $html .=  '<table>';
    $courseUsers = $response->GetAddRemoveColleaguePageViewResult->CourseUsers->NameUserNameRoleView;

    if(is_array($courseUsers))
    {
        for($i = 0; $i < count($courseUsers); $i++)
        {           
            $html .= RenderUserTD($courseUsers[$i], $i, $response->GetAddRemoveColleaguePageViewResult->MoodleRoles->MoodleRoleView);
        }        
    }
    else if ($courseUsers != null)
    {
        $html .= RenderUserTD($courseUsers, 0, $response->GetAddRemoveColleaguePageViewResult->MoodleRoles->MoodleRoleView);
    }
        
    $html .=  '        <tr>';
    $html .=  '            <td colspan="3"><input type="submit" name="action" value="+ Add User" /></td>';
    $html .=  '        </tr>';
    $html .=  '    </table>';
    $html .=  '    <input type="submit" name="action" value="save" />';   
    $html .=  '    <a class="btnCancel" href="index.php?id=' .$courseId. '">cancel</a>';        
    $html .= '</div>';
    
    if($action == "search" || $action == "+ Add User" )
    {
        $html .=  '<div id="aac_staffSearch"  class="aac_form">';
        $html .=  '    <h1>Staff Search</h1>';
        $html .=  '    <p>Search for staff to add to your course.</p>';
        $html .=  '    <div><input type="text" name="searchText" style="font-size: 14pt" id="SearchStaffToAdd_SearchText" value="' .  $response->GetAddRemoveColleaguePageViewResult->SearchText .'"><input type="submit" name="action" value="search" /></div>';
        $html .=  '    <table>';
        
        $searchUsers = $response->GetAddRemoveColleaguePageViewResult->SearchNameUserNameRoleViews->NameUserNameRoleView;

        if(is_array($searchUsers))
        {
            foreach( $searchUsers as $user)
            {           
                $html .= RenderSearchUserTD($user);
            }        
        }
        else if ($searchUsers != null)
        {
            $html .= RenderSearchUserTD($searchUsers);
        }       

        $html .=  '    </table>';        
        $html .=  '    <input type="submit" name="action" value="cancel" />';    
        $html .= '</div>'; 
    }    
    $html .= '</div>';
    $html .= '</form>';  
    $html .= getEndOfFormAACAddRemoveColleague();
    return $html;

}
function RenderUserTD($user, $i, $MoodleRoles)
{
    $html =  '        <tr>';
    $html .=  '            <td>' .$user->Name. ' <span>(' .$user->UserName. ')</span><input type ="hidden" name="user[' .$i. ']" value="' .$user->UserName. '" /><input type ="hidden" name="fullName[' .$i. ']" value="' .$user->Name. '" /></td>';
    $html .=  '            <td>';
    $html .=  '                <select class="ChangeStaffMember_Select" name="role[' .$i. ']" style="float: left">';
    $html .=  RenderRoleOptions($user->Role, $MoodleRoles);
    $html .=  '                </select>';
    $html .=  '            </td>';
    $html .=  '            <td><a href="javascript:aac_moodle.Staff_RemoveUser(\'' .$user->UserName.  '\')">remove</a></td>';
    $html .=  '        </tr>';
    return $html;
}
function RenderSearchUserTD($user)
{
    $html =  '        <tr><td><a  onclick="javascript:aac_moodle.Staff_AddUser(\'' .$user->UserName. '\')">select</a></td><td>' .$user->Name. ' (' .$user->UserName. ')</td><td>' .$user->Title. '</td><td>' .$user->Location. '</td></tr>';
    return $html;
}
function RenderRoleOptions($selectedRole, $MoodleRoles)
{

    $html = '';
    foreach($MoodleRoles as $role)
    {
        $html .= '<option value="' .$role->Id. '"'  .($role->Id == $selectedRole ? 'selected="selected"' : '').    '>' .$role->RoleName. '</option>';
    }

    return  $html;// '                    <option value="7">Student</option><option selected="selected" value="8">Instructor</option><option value="9">Non-Editing Instructor</option><option value="10">Guest</option><option value="11">Course Creator</option><option value="12">Admin Support</option>';
}
function addRemoveCollegue($userName, $courseid, $action, $searchText, $addedUser, $removeUser, $users, $roles, $fullNames) {
    //   global $CFG, $USER;
	$client = get_ws_client();

	$param->moodleCourseId = $courseid;
    $param->userNameRequestedFor = $userName;
    $param->action = $action;
	$param->searchText =  $searchText;
    $param->addedUser = $addedUser;
    $param->removeUser = $removeUser;
    $param->users = $users;
    $param->roles = $roles;
    $param->fullNames = $fullNames;
	$response = $client->GetAddRemoveColleaguePageView($param);
    return $response;    
}
