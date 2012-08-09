<?php


defined('MOODLE_INTERNAL') || die();

/**
 * The blog menu block class
 */
class block_add_test_students extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_add_test_students');
    }

    function instance_allow_multiple() {
        return true;
    }

    function has_config() {
        return false;
    }

    function applicable_formats() {
        return array('all' => true, 'my' => false, 'tag' => false);
    }

    function instance_allow_config() {
        return true;
    }

    function get_content() {
        global $CFG, $COURSE, $USER;

		
		 $this->content = new stdClass();

    	if( empty($CFG->allowCustomStudentAccountCreation) || $CFG->allowCustomStudentAccountCreation == false )
		 {
			$this->content->text = "This functionality is not enabled"; 
		 }
		 else if(  empty($COURSE) || $COURSE->id == 1 )
		 {
			$this->content->text = "Only Available on Course Pages"; 
		 }
		 else
		 {
			 $coursecontext = get_context_instance(CONTEXT_COURSE, $COURSE->id);

			if (!has_capability('moodle/course:enrolreview', $coursecontext))
			{	
				$this->content->text = "Only Available to Instructors"; 
			}
			else
			{	
				//echo($USER->username . "_student1" . "<br/>");
				$userFound = $this->get_user($USER->username . "_student1");
				//echo($userFound->username);
				$tester = get_role_users(5,$coursecontext);
				
				$foundStudent = false;
				
				foreach($tester as $tt)
				{
					//echo $tt->username . "==" . $userFound->username . "<br/>";
					if( $tt->username == $userFound->username)
					{
						$foundStudent = true;
						break;
					}
				}				
				
				if( !$foundStudent)
				{
					$this->content->text = '<p>To add four test students to this course, click on the link below. The test students will have their password set to "training".</p>';
					$this->content->text .= "<p><a href='" .$CFG->wwwroot . "/theme/nait/custom_scripts/AddUserStudentAccounts.php?courseid=" .$COURSE->id . "'>Add Test Students</a></p>";
				}
				else
				{
					$this->content->text = '<p>Your test student accounts ( ie. ' . $USER->username . "_student1" . ') are already in this course.</p><p>The test students will have their password set to "training".</p>';
				}
			}
		 }

		 $this->content->name = 'Add Test Students';

		
		$this->content->footer = '';

		return $this->content;

    }
    
	function get_user($username)
	{
		global $DB, $CFG, $USER;
		$userfound = $DB->get_record('user', array('username'=>$username));
	
		if( !empty($userfound))
		{
			return $userfound;
		}
		else
		{
			return null;
		}
	}
}
