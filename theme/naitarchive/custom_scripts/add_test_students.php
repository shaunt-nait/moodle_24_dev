<?php
   
global $CFG;

require_once($CFG->dirroot.'/user/edit_form.php');
require_once($CFG->dirroot.'/user/editlib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->libdir.'/gdlib.php');
require_once($CFG->libdir.'/accesslib.php');
require_once($CFG->libdir.'/enrollib.php');

function AddStudentsToCourse($courseid, $usernameFor, $showOutput = true)
{
	global $DB, $CFG;
	
	$coursecontext = get_context_instance(CONTEXT_COURSE, $courseid);

	if( empty($CFG->allowCustomStudentAccountCreation) || $CFG->allowCustomStudentAccountCreation == false )
	{
		if( $showOutput)
		{
		echo "This functionality is not enabled.";
		echo "<br/><br/><a href='" .$CFG->wwwroot . "/'>Return to Moodle</a>";
		}
	}
	else if( empty($courseid) )
	{
				if( $showOutput)
		{
		echo 'CourseId not supplied';
		echo "<br/><br/><a href='" .$CFG->wwwroot . "/'>Return to Moodle</a>";
		}
	}
	else if( $courseid == 1 )
	{
				if( $showOutput)
		{
		echo "Cannot modify course id 1";
		echo "<br/><br/><a href='" .$CFG->wwwroot . "/'>Return to Moodle</a>";
		}
	}
	else if (!has_capability('moodle/course:enrolreview', $coursecontext))
	{	
				if( $showOutput)
		{
		echo("You do not have permission to add students to this course.");
		}
	}
	else if( empty($usernameFor))
	{
				if( $showOutput)
		{
		echo "You must be logged in to use this.";
	
		echo "<br/><br/><a href='" .$CFG->wwwroot . "/'>Return to Moodle</a>";
		}
	}
	else
	{
		//header( 'Location: http://localhost/course/view.php?id=' .$courseid ) ;
	
		$instances = enrol_get_instances($courseid, false);
	
		$manualEnrol;
	
		foreach ($instances as $instance) {
			if ($instance->enrol === 'manual') {
				$manualEnrol = $instance;
				break;
			}
		}
	
		$manual = enrol_get_plugin('manual');
	
		for ($i = 1; $i <= $CFG->numberOfCustomStudentAccounts; $i++) {
	    
			$username = $usernameFor . "_student" . $i;
		
			$userid = get_user_id($username);
	
			if( $userid < 1 )
			{
						if( $showOutput)
		{
				echo "Creating - " . $username . "<br/>";
		}
				$userid = user_create_studentuser($username, $i,$usernameFor);
			}
	
					if( $showOutput)
		{
			echo "Enrolling - " . $username . "<br/>";
		}
			$manual->enrol_user($manualEnrol, $userid, 5);
		}
				if( $showOutput)
		{
		echo "<br/><br/><a href='" .$CFG->wwwroot . "/course/view.php?id=" . $courseid . "'>Return to course</a>";
		}
		
		
	}
}
function user_create_studentuser($username,$index = 1, $forUserName) {
    global $DB, $CFG;
    
    $userfound = $DB->get_record('user', array('username'=>$forUserName));

/// set the timecreate field to the current time

        //TODO check out if it makes sense to create account with this auth plugin and what to do with the password
        //unset($usernew->id);
        //$usernew = file_postupdate_standard_editor($usernew, 'description', $editoroptions, null, 'user', 'profile', null);
        $usernew->mnethostid = $CFG->mnet_localhost_id; // always local user
        $usernew->confirmed  = 1;
        $usernew->timecreated = time();
        $usernew->password = hash_internal_user_password("training");
        $usernew->email=$userfound->email;
		$usernew->username = $username;
		$usernew->firstname = $userfound->firstname . " (" .  $username. ")";
		$usernew->lastname = $userfound->lastname;
		$usercreated = true;

		 $newuserid = $DB->insert_record('user', $usernew);


/// trigger user_created event on the full database user row
    $newuser = $DB->get_record('user', array('id' => $newuserid));
    events_trigger('user_created', $newuser);

/// create USER context for this user
    get_context_instance(CONTEXT_USER, $newuserid);

    return $newuserid;
}

function get_user_id($username)
{
	global $DB, $CFG, $USER;
	$userfound = $DB->get_record('user', array('username'=>$username));

	if( !empty($userfound))
	{return $userfound->id;
	}
	else
	{
		return -1;
	}
}