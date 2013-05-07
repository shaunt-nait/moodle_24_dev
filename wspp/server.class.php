<?php

// $Id$
/**
 * Base class for web services server layer. PP 5 ONLY.
 *
 * @package Web Services
 * @version $Id$
 * @author Open Knowledge Technologies - http://www.oktech.ca/
 * @author Justin Filip <jfilip@oktech.ca> v 1.4
 * @author Patrick Pollet <patrick.pollet@insa-lyon.fr> v 1.5, v 1.6, v 1.7
 * @author
 */
/* rev history
 @see revisions.txt
**/

require_once ('../config.php');
require_once ('wslib.php');
require_once ('filterlib.php');
/// increase memory limit (PHP 5.2 does different calculation, we need more memory now)
// j'ai 11000 comptes
@ raise_memory_limit ( "2048M" ); //fonction de lib/setuplib.php incluse via config.php
//set_time_limit(0);
//define('DEBUG', true);  rev. 1.5.16 already set (or not) in  MoodleWS.php
define ( 'cal_show_global', 1 );
define ( 'cal_show_course', 2 );
define ( 'cal_show_group', 4 );
define ( 'cal_show_user', 8 );
/**
 * The main server class.
 *
 * The only methods that need to be extended in a child class are error() and any of
 * the service methods which need special transport-protocol specific handling of
 * input and / or output data (ie non simple type returns)
 *

 */
class server {
	var $version = 2010101000; // also Moodle 2.0  compatible
	var $using17;
	var $using19 = false;
	/**
	 * Constructor method.
	 *
	 * @uses $CFG
	 * @param none
	 * @return none
	 */
	function server() {
		global $CFG;
		$this->debug_output ( "Server init..." );
		$this->debug_output ( '    Version: ' . $this->version );
		
		if (! $CFG->wspp_using_moodle20) {
			$this->using17 = file_exists ( $CFG->libdir . '/accesslib.php' );
			$this->using19 = file_exists ( $CFG->libdir . '/grouplib.php' );
			//Check for any DB upgrades.
			if (empty ( $CFG->webservices_version )) {
				$this->upgrade ( 0 );
			} else if ($CFG->webservices_version < $this->version) {
				$this->upgrade ( $CFG->webservices_version );
			}
		} else {
			$this->using17 = $this->using19 = true;
		}
		// setup default values if not set in admin screens (see admin/wspp.php)
		if (empty ( $CFG->ws_sessiontimeout ))
			$CFG->ws_sessiontimeout = 1800;
		$this->sessiontimeout = $CFG->ws_sessiontimeout;
		
		if (! isset ( $CFG->ws_logoperations ))
			$CFG->ws_logoperations = 1;
		if (! isset ( $CFG->ws_logerrors ))
			$CFG->ws_logerrors = 0;
		if (! isset ( $CFG->ws_logdetailedoperations ))
			$CFG->ws_logdetailledoperations = 0;
		if (! isset ( $CFG->ws_debug ))
			$CFG->ws_debug = 0;
		if (! isset ( $CFG->ws_enforceipcheck ))
			$CFG->ws_enforceipcheck = 0; // rev 1.6.1 off by default++++
		$this->debug_output ( '    Session Timeout: ' . $this->sessiontimeout );
	}
	
	/**
	 * Performs an upgrade of the webservices system.
	 * Moodle < 2.0 ONLY
	 * @uses $CFG
	 * @param int $oldversion The old version number we are upgrading from.
	 * @return boolean True if successful, False otherwise.
	 */
	private function upgrade($oldversion) {
		global $CFG;
		
		if ($CFG->wspp_using_moodle20)
			return $this->error ( get_string ( 'ws_not_installed_moodle20', 'local_wspp' ) );
		
		$this->debug_output ( 'Starting WS upgrade from version ' . $oldversion . 'to version ' . $this->version );
		$return = true;
		require_once ($CFG->libdir . '/ddllib.php');
		if ($oldversion < 2006050800) {
			$return = install_from_xmldb_file ( $CFG->dirroot . '/wspp/db/install.xml' );
		} else {
			if ($oldversion < 2007051000) {
				$table = new XMLDBTable ( 'webservices_sessions' );
				$field = new XMLDBField ( 'ip' );
				// since table exists, keep NULL as true and no default value !
				// otherwise XMLDB do not do the change but return true ...
				$field->setAttributes ( XMLDB_TYPE_CHAR, '64' );
				$return = add_field ( $table, $field, false, false );
			}
		}
		if ($return) {
			set_config ( 'webservices_version', $this->version );
			$this->debug_output ( 'Upgraded from ' . $oldversion . ' to ' . $this->version );
		} else {
			$this->debug_output ( 'ERROR: Could not upgrade to version ' . $this->version );
		}
		return $return;
	}
	
	/**
	 * Creates a new session key.
	 *
	 * @param none
	 * @return string A 32 character session key.
	 */
	private function add_session_key() {
		$time = ( string ) time ();
		$randstr = ( string ) random_string ( 10 );
		/// XOR the current time and a random string.
		$str = $time;
		$str ^= $randstr;
		/// Use the MD5 sum of this random 10 character string as the session key.
		return md5 ( $str );
	}
	
	/**
	 * Validate's that a client has an existing session.
	 *
	 * @param int $client The client session ID.
	 * @param string $sesskey The client session key.
	 * @return boolean True if the client is valid, False otherwise.
	 */
	private function validate_client($client = 0, $sesskey = '', $operation = '') {
		global $USER, $CFG;
		
		//return true;
		

		// rev 1.6.3 added extra securityu checks
		$client = clean_param ( $client, PARAM_INT );
		$sesskey = clean_param ( $sesskey, PARAM_ALPHANUM );
		
		/// We can't validate a session that hasn't even been initialized yet.
		if (! $sess = ws_get_record ( 'webservices_sessions', 'id', $client, 'sessionend', 0, 'verified', 1 )) {
			return false;
		}
		/// Validate this session.
		if ($sesskey != $sess->sessionkey) {
			return false;
		}
		
		// rev 1.6 make sure the session has not timed out
		if ($sess->sessionbegin + $this->sessiontimeout < time ()) {
			$sess->sessionend = time ();
			ws_update_record ( 'webservices_sessions', $sess );
			return false;
		}
		
		$USER->id = $sess->userid;
		$USER->username = '';
		$USER->mnethostid = $CFG->mnet_localhost_id; //Moodle 1.95+ build sept 2009
		$USER->ip = getremoteaddr ();
		unset ( $USER->access ); // important for get_my_courses !
		$this->debug_output ( "validate_client OK $operation $client user=" . print_r ( $USER, true ) );
		
		//$this->debug_output(print_r($CFG,true));
		

		//LOG INTO MOODLE'S LOG
		if ($operation && $CFG->ws_logoperations)
			add_to_log ( SITEID, 'webservice', 'webservice pp', '', $operation );
		return true;
	}
	
	/**
	 * Sends an FATAL error response back to the client.
	 *
	 * @todo Override in protocol-specific server subclass, e.g. by throwing a PHP  exception
	 * @param string $msg The error message to return.
	 * @return An object with the error message string.(required by mdl_soapserver)
	 */
	protected function error($msg) {
		global $CFG;
		$res = new StdClass ();
		$res->error = $msg;
		if ($CFG->ws_logerrors)
			add_to_log ( SITEID, 'webservice', 'webservice pp', '', 'error :' . $msg );
		$this->debug_output ( "server.soap fatal error : $msg " . getremoteaddr () );
		return $res;
	}
	/**
	 * return and object with error attribute set
	 * this record will be inserted in client array of responses
	 * do not override in protocol-specific server subclass.
	 */
	private function non_fatal_error($msg) {
		$res = new StdClass ();
		$res->error = $msg;
		$this->debug_output ( "server.soap non fatal error : $msg" );
		return $res;
	}
	
	/**
	 * Do server-side debugging output (to file).
	 *
	 * @uses $CFG
	 * @param string $output Debugging output.
	 * @return void
	 */
	function debug_output($output) {
		global $CFG;
		if ($CFG->ws_debug) {
			$fp = fopen ( $CFG->dataroot . '/debug.out', 'a' );
			fwrite ( $fp, "[" . time () . "] $output\n" );
			fflush ( $fp );
			fclose ( $fp );
		}
	}
	
	/**
	 * check that current ws user has the required capability
	 * @param string capability
	 * @param string type on context CONTEXT_SYSTEM, CONTEXT_COURSE ....
	 * @param  object moodle's id
	 * @param int $userid : user to chcek, default me
	 */
	private function has_capability($capability, $context_type, $instance_id, $userid = NULL) {
		global $USER;
		$context = get_context_instance ( $context_type, $instance_id );
		if (empty ( $userid )) { // we must accept null, 0, '0', '' etc. in $userid
			$userid = $USER->id;
		}
		return has_capability ( $capability, $context, $userid );
	}
	
	/**
	 * Validates a client's login request.
	 *
	 * @uses $CFG
	 * @param array $input Input data from the client request object.
	 * @return array Return data (client record ID and session key) to be
	 * converted into a specific data format for sending to the
	 * client.
	 */
	function login($username, $password) {
		global $CFG;
		
		if (! empty ( $CFG->ws_disable ))
			return $this->error ( get_string ( 'ws_accessdisabled', 'local_wspp' ) );
		if (! $this->using17)
			return $this->error ( get_string ( 'ws_nomoodle16', 'local_wspp' ) );
		
		$userip = getremoteaddr (); // rev 1.5.4
		if (! empty ( $CFG->ws_enforceipcheck )) {
			if (! ws_record_exists ( 'webservices_clients_allow', 'client', $userip ))
				return $this->error ( get_string ( 'ws_accessrestricted', 'local_wspp', $userip ) );
			
		}
		
		// rev 1.6.3 added extra security checks
		$username = clean_param ( $username, PARAM_NOTAGS );
		$password = clean_param ( $password, PARAM_NOTAGS );
		
		/// Use Moodle authentication.
		/// FIRST make sure user exists , otherwise account WILL be created with CAS authentification ....
		if (! $knownuser = ws_get_record ( 'user', 'username', $username )) {
			return $this->error ( get_string ( 'ws_invaliduser', 'local_wspp' ) );
		}
		//$this->debug_output(print_r($knownuser, true));
		

		$user = false;
		
		//revision 1.6.1 try to use a custom auth plugin
		if (! exists_auth_plugin ( "webservice" ) || ! is_enabled_auth ( "webservice" )) {
			$this->debug_output ( 'internal ' );
			/// also make sure internal_authentication is used  (a limitation to fix ...)
			if (! is_internal_auth ( $knownuser->auth )) {
				return $this->error ( get_string ( 'ws_invaliduser', 'local_wspp' ) );
			}
			// regular manual authentification (should not be allowed !)
			$user = authenticate_user_login ( addslashes ( $username ), $password );
			$this->debug_output ( 'return of a_u_l' . print_r ( $user, true ) );
			
		} else {
			$this->debug_output ( 'auth plugin' );
			$auth = get_auth_plugin ( "webservice" );
			if ($auth->user_login_webservice ( $username, $password )) {
				$user = $knownuser;
			}
		}
		
		if (($user === false) || ($user && $user->id == 0) || isguestuser ( $user )) {
			
			return $this->error ( get_string ( 'ws_invaliduser', 'local_wspp' ) );
		}
		
		//$this->debug_output(print_r($user,true));
		/// Verify that an active session does not already exist for this user.
		$userip = getremoteaddr (); // rev 1.5.4
		

		$sql = "userid = {$user->id} AND verified = 1 AND
							ip='$userip' AND sessionend = 0 AND
							(" . time () . "- sessionbegin) < " . $this->sessiontimeout;
		
		//$this->debug_output($sql);
		if ($sess = ws_get_record_select ( 'webservices_sessions', $sql )) {
			//return $this->error('A session already exists for this user (' . $user->login . ')');
			/*
			if ($sess->ip != $userip)
			return $this->error(get_string('ws_ipadressmismatch', 'local_wspp',$userip."!=".$sess->ip));
			*/
			//give him more time
			ws_set_field ( 'webservices_sessions', 'sessionbegin', time (), 'id', $sess->id );
			// V1.6 reuse current session
		} else {
			$this->debug_output ( 'nouvelle session ' );
			/// Login valid, create a new session record for this client.
			$sess = new stdClass ();
			$sess->userid = $user->id;
			$sess->verified = true;
			$sess->ip = $userip;
			$sess->sessionbegin = time ();
			$sess->sessionend = 0;
			$sess->sessionkey = $this->add_session_key ();
			if ($sess->id = ws_insert_record ( 'webservices_sessions', $sess )) {
				if ($CFG->ws_logoperations)
					add_to_log ( SITEID, 'webservice', 'webservice pp', '', __FUNCTION__ );
			} else
				return $this->error ( get_string ( 'ws_errorregistersession', 'local_wspp' ) );
			
		}
		/// Return standard data to be converted into the appropriate data format
		/// for return to the client.
		$ret = array ('client' => $sess->id, 'sessionkey' => $sess->sessionkey );
		$this->debug_output ( print_r ( $ret, true ) );
		return $ret;
	}
	
	/**
	 * Logs a client out of the system by removing the valid flag from their
	 * session record and any user ID that is assosciated with their particular
	 * session.
	 *
	 * @param int $client The client record ID.
	 * @param string $sesskey The client session key.
	 * @return boolean True if successfully logged out, false otherwise.
	 * since this operation retunr s a simple type, no need to override it in protocol specific layer
	 */
	function logout($client, $sesskey) {
		global $CFG;
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		if ($sess = ws_get_record ( 'webservices_sessions', 'id', $client, 'sessionend', 0, 'verified', 1 )) {
			$sess->verified = 0;
			$sess->sessionend = time ();
			if (ws_update_record ( 'webservices_sessions', $sess )) {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}
	
	function get_version($client, $sesskey) {
		global $CFG;
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return - 1; //invalid Moodle's ID
		}
		return $this->version;
	}
	

	

	/**
	 * add a user to a course, giving him the role  specified as parameter
	 * @param int $client The client session ID.
	 * @param string $sesskey The client session key.
	 * @param int $userid The user's id
	 * @param int $courseid The course's id
	 * @param string $rolename Specify the name of the role
	 * @return affectRecord Return data (affectRecord object) to be converted into a
	 * specific data format for sending to the client.
	 */
	function affect_user_to_course($client, $sesskey, $userid, $courseid, $rolename, $enrol = "true") {
		
		//if it isn't specified the role name, this will be set as Student
		$rolename = empty ( $rolename ) ? "student" : $rolename;
		$res = $this->affect_role_incourse ( $client, $sesskey, $rolename, $courseid, 'id', array ($userid ), 'id', $enrol );
		
		$r = new stdClass ();
		$r->status = empty ( $res->error );
		return $r;
	}
	
	///I had to create a new method as the $enrol value never seemed to be passed and was always true so I couldnt unenrol
	function affect_user_to_course_remove($client, $sesskey, $userid, $courseid, $rolename) {
		
		//if it isn't specified the role name, this will be set as Student
		$rolename = empty ( $rolename ) ? "student" : $rolename;
		$res = $this->affect_role_incourse_remove( $client, $sesskey, $rolename, $courseid, 'id', array ($userid ), 'id' );
		
		$r = new stdClass ();
		$r->status = empty ( $res->error );
		return $r;
	}
	
	/**
	 * Enrol users with the given role name  in the given course
	 *
	 * @param int $client The client session ID.
	 * @param string $sesskey The client session key.
	 * @param string $rolename  shortname of role to affect
	 * @param string $courseid The course ID number to enrol students in <- changed to category...
	 * @param  string $courseidfield field to use to identify course (idnumber,id, shortname)
	 * @param array $userids An array of input user idnumber values for enrolment.
	 * @param string $idfield identifier used for users . Note that $courseid is expected
	 * to contains an idnumber and not Moodle id.
	 * @return array Return data (user_student records) to be converted into a
	 * specific data format for sending to the client.
	 */
	function affect_role_incourse($client, $sesskey, $rolename, $courseid, $courseidfield, $userids, $useridfield = 'idnumber', $enrol = "true") {
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		global $CFG, $USER;
		
		if (! ($role = ws_get_record ( 'role', 'shortname', $rolename ))) {
			return $this->error ( get_string ( 'ws_roleunknown', 'local_wspp', $rolename ) );
		}
		
		//$groupid = 0; // for the role_assign function (what does this ? not anymore in Moodle 2.0
		if (! $course = ws_get_record ( 'course', $courseidfield, $courseid )) {
			return $this->error ( get_string ( 'ws_courseunknown', 'local_wspp', $courseidfield . "=" . $courseid ) );
		}
		$context = get_context_instance ( CONTEXT_COURSE, $course->id );
		if (! has_capability ( "moodle/role:assign", $context ))
			return $this->error ( get_string ( 'ws_operationnotallowed', 'local_wspp' ) );
		//not anymore in Moodle 2.0 ...
		if (! empty ( $course->enrolperiod )) {
			$timestart = time ();
			$timeend = $timestart + $course->enrolperiod;
		} else {
			$timestart = $timeend = 0;
		}
		//$this->debug_output("IDS=" . print_r($userids, true) . "\n" . $enrol ."\n ctx=".$context->id);
		$return = array ();
		if (! empty ( $userids )) {
			foreach ( $userids as $userid ) {
				//$st = new enrolRecord();
				if (! $leuser = ws_get_record ( 'user', $useridfield, $userid )) {
					$st->error = get_string ( 'ws_userunknown', 'local_wspp', $useridfield . "=" . $userid );
				} else {
					$st->userid = $leuser->$useridfield; //return the sent value
					$st->course = $course->$courseidfield;
					$st->timestart = $timestart;
					$st->timeend = $timeend;
					if ($enrol == "true") {
						if (! ws_role_assign ( $role->id, $leuser->id, $context->id, $timestart, $timeend, $course )) {
							$st->error = "error enroling";
							$op = "error enroling " . $st->userid . " to " . $st->course;
						} else {
							$st->enrol = "webservice";
							$op = $rolename . " " . $st->userid . " added to " . $st->course;
						}
					}
					else
					{
						if (! ws_role_unassign ( $role->id, $leuser->id, $context->id, $course )) {
							$st->error = "error unenroling";
							$op = "error unenroling " . $st->userid . " from " . $st->course;
						} else {
							$st->enrol = "no";
							$op = $rolename . " " . $st->userid . " removed from " . $st->course;
						}						
					}
				}
				$return [] = $st;
				if ($CFG->ws_logdetailedoperations)
					add_to_log ( SITEID, 'webservice', 'webservice pp', '', $op );
			}
		} else {
			//$st = new enrolRecord();
			$st->error = get_string ( 'ws_nothingtodo', 'local_wspp' );
			$return [] = $st;
		}
		//$this->debug_output("ES" . print_r($return, true));
		return $return;
	}
	
	/**
		 * Enrol users with the given role name  in the given course
		 *
		 * @param int $client The client session ID.
		 * @param string $sesskey The client session key.
		 * @param string $rolename  shortname of role to affect
		 * @param string $courseid The course ID number to enrol students in <- changed to category...
		 * @param  string $courseidfield field to use to identify course (idnumber,id, shortname)
		 * @param array $userids An array of input user idnumber values for enrolment.
		 * @param string $idfield identifier used for users . Note that $courseid is expected
		 * to contains an idnumber and not Moodle id.
		 * @return array Return data (user_student records) to be converted into a
		 * specific data format for sending to the client.
		 */
	function affect_role_incourse_remove($client, $sesskey, $rolename, $courseid, $courseidfield, $userids, $useridfield = 'idnumber') {
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		global $CFG, $USER;
		
		if (! ($role = ws_get_record ( 'role', 'shortname', $rolename ))) {
			return $this->error ( get_string ( 'ws_roleunknown', 'local_wspp', $rolename ) );
		}
		
		//$groupid = 0; // for the role_assign function (what does this ? not anymore in Moodle 2.0
		if (! $course = ws_get_record ( 'course', $courseidfield, $courseid )) {
			return $this->error ( get_string ( 'ws_courseunknown', 'local_wspp', $courseidfield . "=" . $courseid ) );
		}
		$context = get_context_instance ( CONTEXT_COURSE, $course->id );
		if (! has_capability ( "moodle/role:assign", $context ))
			return $this->error ( get_string ( 'ws_operationnotallowed', 'local_wspp' ) );
		//not anymore in Moodle 2.0 ...
		if (! empty ( $course->enrolperiod )) {
			$timestart = time ();
			$timeend = $timestart + $course->enrolperiod;
		} else {
			$timestart = $timeend = 0;
		}
		//$this->debug_output("IDS=" . print_r($userids, true) . "\n" . $enrol ."\n ctx=".$context->id);
		$return = array ();
		if (! empty ( $userids )) {
			foreach ( $userids as $userid ) {
				//$st = new enrolRecord();
				if (! $leuser = ws_get_record ( 'user', $useridfield, $userid )) {
					$st->error = get_string ( 'ws_userunknown', 'local_wspp', $useridfield . "=" . $userid );
				} else {
					$st->userid = $leuser->$useridfield; //return the sent value
					$st->course = $course->$courseidfield;
					$st->timestart = $timestart;
					$st->timeend = $timeend;

					if (! ws_role_unassign ( $role->id, $leuser->id, $context->id, $course )) {
						$st->error = "error unenroling";
						$op = "error unenroling " . $st->userid . " from " . $st->course;
					} else {
						$st->enrol = "no";
						$op = $rolename . " " . $st->userid . " removed from " . $st->course;
					}
					
				}
				$return [] = $st;
				if ($CFG->ws_logdetailedoperations)
					add_to_log ( SITEID, 'webservice', 'webservice pp', '', $op );
			}
		} else {
			//$st = new enrolRecord();
			$st->error = get_string ( 'ws_nothingtodo', 'local_wspp' );
			$return [] = $st;
		}
		//$this->debug_output("ES" . print_r($return, true));
		return $return;
	}
	
	//Custom WebServices
	

	private function getCohortUserSearch($cohort) {
		global $DB;
		//by default wherecondition retrieves all users except the deleted, not confirmed and guest
		$params ['cohortid'] = $cohort->id;
		
		$sql = "SELECT u.* 
				FROM {user} u
                 JOIN {cohort_members} cm ON (cm.userid = u.id)
                WHERE cm.cohortid = " . $cohort->id;
		
		$order = ' ORDER BY u.lastname ASC, u.firstname ASC';
		
		$availableusers = $DB->get_records_sql ( $sql . $order );
		
		return $availableusers;
	}
	
	/**
	 * Copy contents from one course to another.
	 *
	 * @param int $client The client session record ID.
	 * @param int $sesskey The client session key.
	 * @param int $fromcourseid The ID of the course should be copied from.
	 * @param int $tocourseid The ID of the course wheer contents should be copied into.
	 * @return boolean True on success, False otherwise.
	 */
	function exec_copy_content_existing($client, $sesskey, $fromcourseid, $tocourseid) { //, $cidnumber, $enrolltype){
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		global $CFG, $DB, $USER;
		
		//This function will basically take a backup of the course, restore it to the destination course and
		// then delete the backup file.
		require_once ($CFG->dirroot . '/backup/util/includes/backup_includes.php');
		require_once ($CFG->dirroot . '/backup/util/includes/restore_includes.php');
		
		$bc = new backup_controller ( backup::TYPE_1COURSE, $fromcourseid, backup::FORMAT_MOODLE, backup::INTERACTIVE_NO, backup::MODE_GENERAL, $USER->id );
		
		$filename = 'forcopycontent_' . $fromcourseid . '_to_' . $tocourseid . '_' . time () . '.mbz';
		$bc->get_plan ()->get_setting ( 'filename' )->set_value ( $filename );
		$bc->get_plan ()->get_setting ( 'users' )->set_value ( 0 );
		$bc->save_controller ();
		$bc->execute_plan ();
		
		$fileinfodb = $DB->get_record ( 'files', array ('filename' => $filename ) );
		$fb = get_file_browser ();
		$fileinfo = $fb->get_file_info ( get_context_instance_by_id ( $fileinfodb->contextid ), $fileinfodb->component, $fileinfodb->filearea, $fileinfodb->itemid, $fileinfodb->filepath, $fileinfodb->filename );
		
		$tmpdir = $CFG->dataroot . '/temp/backup';

        if( $CFG->tempdir )
		{
			$tmpdir = $CFG->tempdir . '/backup';
		}

		$tempfilename = restore_controller::get_tempdir_name ( $fromcourseid, $USER->id );
		$tempfilepathname = $tmpdir . '/' . $tempfilename;
		$this->debug_output ( $tempfilepathname );
		$fileinfo->copy_to_pathname ( $tempfilepathname );
		
		$oldcourse = $DB->get_record( 'course', array('id'=> $tocourseid) );
		//$this->debug_output ( 'current course legacyfiles ' . $oldcourse->legacyfiles);
		
		//Execute restore
		$restoredirpath = restore_controller::get_tempdir_name ( $fromcourseid, $USER->id );
		$fb = get_file_packer ();
		$fb->extract_to_pathname ( $tempfilepathname, $tmpdir . '/' . $restoredirpath . '/' );
		fulldelete ( $tempfilepathname );
		$rc = new restore_controller ( $restoredirpath, $tocourseid, backup::INTERACTIVE_NO, backup::MODE_AUTOMATED, $USER->id, backup::TARGET_EXISTING_DELETING );
		$rc->get_plan()-> get_setting('overwrite_conf')->set_value(1);
		$rc->set_status ( backup::STATUS_AWAITING );
		restore_dbops::delete_course_content($rc->get_courseid());
		$rc->execute_plan ();
		
		$newcourse = $DB->get_record( 'course', array('id'=> $tocourseid) );
		$newcourse->fullname = $oldcourse->fullname;
		$newcourse->shortname= $oldcourse->shortname;
		$newcourse->idnumber= $oldcourse->idnumber;
		
		$DB->update_record( 'course', $newcourse);
		//$oldcourse = ws_get_record ( 'course', 'id', $tocourseid );
		//$this->debug_output ( 'current course legacyfiles ' . $oldcourse->legacyfiles);
					
		//delete backup file
		fulldelete ( $tmpdir . '/' . $restoredirpath );
		$fs = get_file_storage ();
		$stored_file = $fs->get_file ( $fileinfodb->contextid, $fileinfodb->component, $fileinfodb->filearea, $fileinfodb->itemid, $fileinfodb->filepath, $fileinfodb->filename );
		$stored_file->delete ();
		
		return true;
	}

	function exec_copy_content($client, $sesskey, $fromcourseid, $newcourse) { //, $cidnumber, $enrolltype){
		if ($newcourse->id != -1){
			return $this->exec_copy_content_existing($client, $sesskey, $fromcourseid, $newcourse->id);
		}
		
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		global $CFG, $DB, $USER;
		
		//This function will basically take a backup of the course, restore it to the destination course and
		// then delete the backup file.
		require_once ($CFG->dirroot . '/backup/util/includes/backup_includes.php');
		require_once ($CFG->dirroot . '/backup/util/includes/restore_includes.php');
		
		$bc = new backup_controller ( backup::TYPE_1COURSE, $fromcourseid, backup::FORMAT_MOODLE, backup::INTERACTIVE_NO, backup::MODE_GENERAL, $USER->id );
		
		$oldcourse = $DB->get_record ( 'course', array ('id' => $fromcourseid ) );
		//$this->debug_output ( 'Number of sections in old course...'. $oldcourse->numsections );
		
		$filename = 'forcopycontent_' . $fromcourseid . '_' . time () . '.mbz';
		$bc->get_plan ()->get_setting ( 'filename' )->set_value ( $filename );
		$bc->get_plan ()->get_setting ( 'users' )->set_value ( 0 );
		$bc->save_controller ();
		$bc->execute_plan ();
		
		$fileinfodb = $DB->get_record ( 'files', array ('filename' => $filename ) );
		$fb = get_file_browser ();
		$fileinfo = $fb->get_file_info ( get_context_instance_by_id ( $fileinfodb->contextid ), $fileinfodb->component, $fileinfodb->filearea, $fileinfodb->itemid, $fileinfodb->filepath, $fileinfodb->filename );
		
		$tmpdir = $CFG->dataroot . '/temp/backup';
		
        if( $CFG->tempdir )
		{
			$tmpdir = $CFG->tempdir . '/backup';
		}
		
		$tempfilename = restore_controller::get_tempdir_name ( $fromcourseid, $USER->id );
		$tempfilepathname = $tmpdir . '/' . $tempfilename;
		$this->debug_output ( 'Backup file path: '. $tempfilepathname );
		$fileinfo->copy_to_pathname ( $tempfilepathname );
		
		//Execute restore
		$restoredirpath = restore_controller::get_tempdir_name ( $fromcourseid, $USER->id );
		$fb = get_file_packer ();
		$fb->extract_to_pathname ( $tempfilepathname, $tmpdir . '/' . $restoredirpath . '/' );
		fulldelete ( $tempfilepathname );
		$this->debug_output ( 'Creating new course...' );
		$tocourseid = restore_dbops::create_new_course('Test Fullname', 'TF12', $newcourse->category);
        $this->debug_output ( 'New Course created...id = '.$tocourseid );
		$this->debug_output ( 'Starting Course Restore.....');
        $rc = new restore_controller ( $restoredirpath, $tocourseid, backup::INTERACTIVE_NO, backup::MODE_AUTOMATED, $USER->id, backup::TARGET_NEW_COURSE );
		$rc->set_status ( backup::STATUS_AWAITING );
		//restore_dbops::delete_course_content($rc->get_courseid());
		$rc->execute_plan ();
		$this->debug_output ( 'Restore Completed.');
		
		$this->debug_output ( 'This is what the new course should be...'.print_r ( $newcourse, true ) );
		//now put the correct course info, this code is taken from update course
		$newcourse->id = $tocourseid;
		$newcourse->numsections = $oldcourse->numsections;
		$this->debug_output ( 'Updating Course.....');
		$DB->update_record( 'course', $newcourse );
		$this->debug_output ( 'Course Info Updated.');
		
		$this->debug_output ( 'Deleting backup file....');
		//delete backup file
		fulldelete ( $tmpdir . '/' . $restoredirpath );
		$fs = get_file_storage ();
		$stored_file = $fs->get_file ( $fileinfodb->contextid, $fileinfodb->component, $fileinfodb->filearea, $fileinfodb->itemid, $fileinfodb->filepath, $fileinfodb->filename );
		$stored_file->delete ();
		$this->debug_output ( 'Backup file deleted....');
		return true;
	}
	
	/**
	 * Perform a backup
	 *
	 * @param int $client The client session record ID.
	 * @param int $sesskey The client session key.
	 * @param int $courseid The ID of the course.
	 * @param backupPreferences $prefs Preferences to perform the backup.
	 * @return string The backup location on success, boolean False otherwise.
	 */
	function exec_backup($client, $sesskey, $courseid, $prefs) {
		global $CFG;
		
		require_once ($CFG->dirroot . '/backup/lib.php');
		require_once ($CFG->dirroot . '/backup/backuplib.php');
		
		if (! $this->validate_client ( $client, $sesskey )) {
			return $this->error ( 'Invalid client connection.' );
		}
		
		if (! $this->has_capability ( 'moodle/course:create', CONTEXT_SYSTEM, 0 )) {
			$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
			$ret->status = false;
			break;
		}
		
		$preferences = array ();
		
		$preferences ['backup_metacourse'] = $prefs->metacourse;
		$preferences ['backup_users'] = $prefs->users;
		$preferences ['backup_logs'] = $prefs->logs;
		$preferences ['backup_user_files'] = $prefs->user_files;
		$preferences ['backup_course_files'] = $prefs->course_files;
		$preferences ['backup_site_files'] = $prefs->site_files;
		$preferences ['backup_messages'] = $prefs->messages;
		
		$errrstr = '';
		
		return backup_course_silently ( $courseid, $preferences, $errrstr );
		
	}
	// - Orignal May 30, 2011
	function modifyUserEnrolments2($client, $sesskey, $userEnrolments) {
		global $CFG;
		require_once ($CFG->dirroot . '/course/lib.php');
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		$ret = array ();
		
		if (! empty ( $userEnrolments )) {
			
			foreach ( $userEnrolments as $userEnrolment ) {
				$record = new affectRecord ();
				
				$isOk = true;
				
				//first check if the user exists
				$user = ws_get_record ( 'user', 'username', $userEnrolment->user->username );
				
				if (empty ( $user )) {
					
					if (! $this->has_capability ( 'moodle/user:create', CONTEXT_SYSTEM, 0 )) {
						$record->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
						$isOk = false;
					} else {
						$newUser = new userDatum ();
						$newUser->username = $userEnrolment->user->username;
						$newUser->firstname = $userEnrolment->user->firstname;
						$newUser->lastname = $userEnrolment->user->lastname;
						$newUser->email = $userEnrolment->user->email;
						$newUser->idnumber = $userEnrolment->user->idnumber;
						
						$newUser->timecreated = time ();
						$newUser->timemodified = $newUser->timecreated;
						$newUser->auth = 'ldap';
						$newUser->mnethostid = $CFG->mnet_localhost_id;
						$newUser->timezone= '99';
						
						if ($userid = ws_insert_record ( 'user', $newUser )) {
							$user = ws_get_record ( 'user', 'id', $userid );
							$this->debug_output ( 'inserion ok' . print_r ( $user, true ) );
							events_trigger ( 'user_created', $user );
							
						} else {
							$isOk = false;
							$record->error = 'Error inserting user --> ' . $userEnrolment->user->username;
							$this->debug_output ( 'insertion KO ' . print_r ( $user, true ) );
						}
					}
					
				} else {
					//exists
					

				}
				
				if ($isOk == true) {
					if($userEnrolment->addUser == "true" )
					{
						//now add user to role
						$temp = $this->affect_user_to_course ( $client, $sesskey, $user->id, $userEnrolment->courseId, $userEnrolment->roleName);
						$record->error = $temp->error;
						$record->status = true;
					}
					else
					{
						$temp = $this->affect_user_to_course_remove ( $client, $sesskey, $user->id, $userEnrolment->courseId, $userEnrolment->roleName);
						$record->error = $temp->error;
						$record->status = true;
					}
				}
				
				
				$ret [] = $record;
			}
		}
		
		return $ret;
	}
	
	//NAIT
	function modifyUserEnrolments($client, $sesskey, $userEnrolments) {
		global $CFG;
		require_once ($CFG->dirroot . '/course/lib.php');
		require_once ($CFG->dirroot . '/user/lib.php');
		require_once ($CFG->dirroot . '/wspp/classes/userDatum.php');
		require_once ($CFG->dirroot . '/wspp/classes/affectRecord.php');
		//for grade restore
		require_once ($CFG->dirroot . '/lib/gradelib.php');
		
		require_once ($CFG->dirroot . '/theme/nait/custom_scripts/add_test_students.php');
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		$ret = array ();
		
		if (! empty ( $userEnrolments )) {
			foreach ( $userEnrolments as $userEnrolment ) {
				$record = new affectRecord ();
				
				/**/
				$isOk = true;
				
				//first check if the user exists
				//NAIT: Postgres is case sensitive
				if ($CFG->dbtype=="pgsql"){
					$user = ws_get_record ( 'user', 'lower(username)', strtolower($userEnrolment->user->username) );
				} else { 
					$user = ws_get_record ( 'user', 'username', $userEnrolment->user->username );
				}
				
				if (empty ( $user )) {
					
					//TODO: Delete when Completed
					$record->error = "new";
					
					if (! $this->has_capability ( 'moodle/user:create', CONTEXT_SYSTEM, 0 )) {
						$record->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
						$isOk = false;
					} else {
						$newUser = new userDatum ();
						$newUser->username = strtolower($userEnrolment->user->username);
						$newUser->firstname = $userEnrolment->user->firstname;
						$newUser->lastname = $userEnrolment->user->lastname;
						$newUser->email = $userEnrolment->user->email;
						$newUser->idnumber = $userEnrolment->user->idnumber;
						
						$newUser->timecreated = time ();
						$newUser->timemodified = $newUser->timecreated;
						$newUser->auth = 'ldap';
						$newUser->mnethostid = $CFG->mnet_localhost_id;
						$newUser->confirmed = 1;
						$newUser->timezone = '99';
						if ($userid = ws_insert_record ( 'user', $newUser )) {
							$user = ws_get_record ( 'user', 'id', $userid );
							$this->debug_output ( 'inserion ok' . print_r ( $user, true ) );
							events_trigger ( 'user_created', $user );
							
						} else {
							$isOk = false;
							$record->error = 'Error inserting user --> ' . $userEnrolment->user->username;
							$this->debug_output ( 'insertion KO ' . print_r ( $user, true ) );
						}
					}
					
				} else {
					//exists
					//TODO: Delete when Completed
					$record->error = "exists";
				}
				
				if ($isOk == true) {
					
					if($userEnrolment->addUser == "true" )
					{
						
						ob_start ();

						//now add user to role
						$temp = (object) $this->affect_user_to_course ( $client, $sesskey, $user->id, $userEnrolment->courseId, $userEnrolment->roleName);
						grade_recover_history_grades($user->id, $userEnrolment->courseId);
						$record->error = $temp->error;
						$record->status = true;
						
						if (ob_get_length () && trim ( ob_get_contents () )) {
							/// Return an error with  the contents of the output buffer.
							$msg = trim ( ob_get_clean () );

							//ignore if gradebook
							if (strpos($msg,'This activity is locked in the gradebook.') == false)
							{
								return $this->error ( 'Database error: ' . $msg );
							}
						}

						ob_end_clean ();
						
						
						//TODO: Delete when Completed
						$record->error = $record->error . " - add";
						
						$crs = ws_get_record ( 'course', 'id', $userEnrolment->courseId );
						$context = get_context_instance ( CONTEXT_COURSE, $userEnrolment->courseId );
						$userRoles = get_user_roles ( $context, $user->id, false );
						
						
						//TODO: Delete when Completed
						$record->error = $record->error . " - CourseID:" . $crs->id;
						$record->error = $record->error . " - UserId:" . $user->id;
						
						foreach ( $userRoles as $ur ) {
							//if a student role
							if ($ur->roleid == 5) {
								
								$rec ['classsection'] = $userEnrolment->sectionString;
								$rec ['roleassignmentsid'] = $ur->id;								
								
								$record->error = $record->error . " - RoleId:" . $ur->id;
								$recExists = new stdClass();
								$recExists = (object) ws_get_record ( 'role_assignments_class_sections', 'roleassignmentsid', $ur->id );
								
								if ($recExists->id) {
									$record->error .= " Section info already recorded: " . $recExists->classsection . ". ";
									
									ob_start ();
									
									//$ra_classsection->id = insert_record ( 'role_assignments_class_sections', $rec, true );
									
									
									if ($recExists->classsection == $userEnrolment->sectionString) {
										$record->error .= " Section is the same as current. ";
										//$rusers [] = $user;
										break;
									}
									
									$recExists->classsection = $userEnrolment->sectionString;
									$ra_classsection->id = ws_update_record ( 'role_assignments_class_sections', $recExists );
									
									if ($ra_classsection->id) {
										$record->error .= " Class section info updated: " . $user->sectionString;
										//$rusers [] = $user;
									}
									
									if (DEBUG)
										$this->debug_output ( 'Role_assignments_class_section ID is ' . $ra_classsection->id );
									if (ob_get_length () && trim ( ob_get_contents () )) {
										/// Return an error with  the contents of the output buffer.
										$msg = trim ( ob_get_clean () );
										return $this->error ( 'Database error: ' . $msg );
									}
									ob_end_clean ();
									
									//break;
								} else {
									ob_start ();
									
									$ra_classsection->id = ws_insert_record ( 'role_assignments_class_sections', $rec, true );
									
									if ($ra_classsection->id) {
										$record->error  .= " Class section info added: " . $rec ['classsection'];
										//$rusers [] = $user;
									} 
									
									if (DEBUG)
									{
										$this->debug_output ( 'Role_assignments_class_section ID is ' . $ra_classsection->id );
										$this->debug_output ( 'CourseID: ' . $userEnrolment->courseId );
									}
									if (ob_get_length () && trim ( ob_get_contents () )) {
										/// Return an error with  the contents of the output buffer.
										$msg = trim ( ob_get_clean () );
										return $this->error ( 'Database error: ' . $msg );
									}
									ob_end_clean ();
								}
								
							}
							else if($ur->roleid == 3)
								{
									AddStudentsToCourse($userEnrolment->courseId,$user->username,false);
								}							
						}
						
						
						//if student and has section string, then add to section table
						
						
						
					}
					else
					{
						//TODO: Delete when Completed
						$record->error = $record->error . " - delete";
						
						$temp = $this->affect_user_to_course_remove ( $client, $sesskey, $user->id, $userEnrolment->courseId, $userEnrolment->roleName);
						$record->error = $temp->error;
						$record->status = true;
						
					}
				}
				
				
				$ret [] = $record;
			}
		}
		
		return $ret;
	}
	
	function modifyCourseCohortLink($client, $sesskey, $cohortid, $cohortidfield, $courseid, $courseidfield, $roleid, $roleidfield, $addcohorttocourse = true) {
		global $CFG;
		require_once ($CFG->dirroot . '/course/lib.php');
		require_once ($CFG->dirroot . "/enrol/locallib.php");
		
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		/// Check for correct permissions.
		if (! $this->has_capability ( 'moodle/cohort:manage', CONTEXT_SYSTEM, 0 )) {
			return $this->error ( get_string ( 'ws_operationnotallowed', 'local_wspp' ) );
		}
		
		$ret = new affectRecord ();
		
		$cohort = ws_get_record ( 'cohort', $cohortidfield, $cohortid );
		
		//Make sure cohort exists
		if (empty ( $cohort )) {
			$ret->error = "Cohort not found.";
			return $ret;
		}
		
		$course = ws_get_record ( 'course', $courseidfield, $courseid );
		
		//make sure course exists
		if (empty ( $course )) {
			$ret->error = "Course not found.";
			return $ret;
		}
		
		$role = ws_get_record ( 'role', $roleidfield, $roleid );
		
		//make sure role exists
		if (empty ( $role )) {
			$ret->error = "Role not found.";
			return $ret;
		}
		
		$manager = new course_enrolment_manager ( $course );
		
		//Get all enrolment instances for the course
		//This returns all, notjust cohorts
		$instances = $manager->get_enrolment_instances ();
		
		$instanceFound;
		
		foreach ( $instances as $instance ) {
			//make sure the instance is a cohort instance
			if ($instance->enrol == 'cohort') {
				if ($instance->roleid == $role->id && $instance->customint1 == $cohort->id) {
					$instanceFound = $instance;
				}
			}
		}
		
		//only add if not there already
		if ($addcohorttocourse && empty ( $instanceFound )) {
			if (! $manager->enrol_cohort ( $cohort->id, $role->id )) {
				$ret->error = "Unable to add cohort instance.";
			}
		}
		
		//only remove if it exists
		if (! $addcohorttocourse && ! empty ( $instanceFound )) {
			$enroller = enrol_get_plugin ( 'cohort' );
			
			$enroller->delete_instance ( $instanceFound );
		}
		
		return $ret;
	}
	
	function editCohort($client, $sesskey, $cohort) {
		global $CFG;
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		if ($CFG->wspp_using_moodle20) {
			require_once ($CFG->dirroot . '/cohort/lib.php');
		} else
			return $this->error ( get_string ( 'ws_moodle20only', 'local_wspp' ) );
		
		$ret->id = $cohort->id;
		$ret->error = "";
		$ret->status = true;
		
		switch (trim ( strtolower ( $cohort->action ) )) {
			case 'add' :
				/// Adding a new cohort.
				if (! empty ( $cohort->categoryid )) {
					if (! $course = ws_get_record ( 'course_categories', 'id', $cohort->categoryid )) {
						$ret->error = get_string ( 'ws_categoryunknown', 'local_wspp', "id=" . $cohort->categoryid );
						$ret->status = false;
						break;
					}
					
					$context = get_context_instance ( CONTEXT_COURSECAT, $cohort->categoryid );
					
					if (! has_capability ( 'moodle/cohort:manage', $context )) {
						$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
						$ret->status = false;
						break;
					}
					
					$cohort->contextid = $context->id;
					
				} else {
					/// Check for correct permissions. at site level
					if (! $this->has_capability ( 'moodle/cohort:manage', CONTEXT_SYSTEM, 0 )) {
						$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
						$ret->status = false;
						break;
					}
					$cohort->contextid = 1; // site cohort
				}
				// cohorts are Moodle 2.0 only so it will raise an execption for sure
				try {
					$ret->id = cohort_add_cohort ( $cohort );
				} catch ( Exception $ex ) {
					ws_error_log ( $ex );
					$ret->error = get_string ( 'ws_errorcreatingcohort', 'local_wspp', $cohort->name );
					$ret->status = false;
				}
				
				break;
			case 'update' :
				/// Updating an existing group
				if (! $oldgroup = ws_get_record ( 'cohort', 'id', $cohort->id )) {
					$ret->error = get_string ( 'ws_cohortunknown', 'local_wspp', "id=" . $cohort->id );
					$ret->status = false;
					break;
				}
				
				if ($oldgroup->contextid == 1) {
					if (! $this->has_capability ( 'moodle/cohort:manage', CONTEXT_SYSTEM, 0 )) {
						$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
						$ret->status = false;
						break;
					}
				} else {
					$context = get_context_instance_by_id ( $oldgroup->contextid );
					if (! has_capability ( 'moodle/cohort:manage', $context )) {
						$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
						$ret->status = false;
						break;
					}
				}
				// no way to change these !!!
				$cohort->id = $oldgroup->id;
				$cohort->contextid = $oldgroup->contextid;
				
				
				cohort_update_cohort ( $cohort );
				
				break;
			case 'delete' :
				/// Deleting an existing cohort
				

				if (! $oldgroup = ws_get_record ( 'cohort', 'id', $cohort->id )) {
					$ret->error = get_string ( 'ws_cohortunknown', 'local_wspp', "id=" . $cohort->id );
					$ret->status = false;
					break;
				}
				if ($oldgroup->contextid == 1) {
					if (! $this->has_capability ( 'moodle/cohort:manage', CONTEXT_SYSTEM, 0 )) {
						$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
						$ret->status = false;
						break;
					}
				} else {
					$context = get_context_instance_by_id ( $oldgroup->contextid );
					if (! has_capability ( 'moodle/cohort:manage', $context )) {
						$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
						$ret->status = false;
						break;
					}
				}
				cohort_delete_cohort ( $oldgroup );
				break;
			default :
				$ret->error = get_string ( 'ws_invalidaction', 'local_wspp', $cohort->action );
				$ret->status = false;
				
				break;
		}
		
		return $ret;
	}
	
	function editUser($client, $sesskey, $user) {
		global $CFG;
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		require_once ($CFG->dirroot . '/user/lib.php');
		
		$ret->id = $user->id;
		$ret->error = "";
		$ret->status = true;
		
		switch (trim ( strtolower ( $user->action ) )) {
			case 'add' :
				/// Adding a new user.
				
				if (! $this->has_capability ( 'moodle/user:create', CONTEXT_SYSTEM, 0 )) {
					$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
					$ret->status = false;
					break;
				}
				
				// fix record if needed and check for missing values or database collision
				//				if ($errmsg = ws_checkuserrecord ( $user, true )) {
				//					$ret->error = $errmsg;
				//					break;
				//				}
				$user->auth = 'ldap';
				
				$user->mnethostid= $CFG->mnet_localhost_id;
				$user->confirmed= 1;
				$user->timezone= '99';				
				
				if ($userid = user_create_user ( $user )) {
					$this->debug_output ( 'inserion ok' . print_r ( $user, true ) );
					events_trigger ( 'user_created', $user );
					$ret->id = $userid;
					
				} else {
					$ret->error = get_string ( 'ws_errorcreatinguser', 'local_wspp', $user->username );
					$this->debug_output ( 'insertion KO ' . print_r ( $user, true ) );
				}
				
				break;
			case 'update' :
				if (! $this->has_capability ( 'moodle/user:update', CONTEXT_SYSTEM, 0 )) {
					$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
					break;
				}
				if (! $olduser = ws_get_record ( 'user', 'id', $user->id )) {
					$ret->error = get_string ( 'ws_userunknown', 'local_wspp', "id=" . $user->id );
					break;
				}
				
				$user->timemodified = time ();
				
				/// Update values in the $user database record with what
				/// the client supplied.
				
				$user->mnethostid= $CFG->mnet_localhost_id;
				$user->confirmed= 1;
				
				if (ws_update_record ( 'user', $user )) {
					events_trigger ( 'user_updated', $user );
				} else {
					$ret->error = get_string ( 'ws_errorupdatinguser', 'local_wspp', $user->id );
				}
				break;
			case 'delete' :
				if (! $this->has_capability ( 'moodle/user:delete', CONTEXT_SYSTEM, 0 )) {
					$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
					break;
				}
				if (! $olduser = ws_get_record ( 'user', 'id', $user->id )) {
					$ret->error = get_string ( 'ws_userunknown', 'local_wspp', "id=" . $user->id );
					break;
				}
				
				if (! delete_user ( $user )) {
					$ret->error = get_string ( 'ws_errordeletinguser', 'local_wspp', $user->idnumber );
				}
				break;
			default :
				$ret->error = get_string ( 'ws_invalidaction', 'local_wspp', $course->action );
				$ret->status = false;
				
				break;
		}
		
		return $ret;
	}
	
	function editCourse($client, $sesskey, $course) {
		global $CFG;
		
		require_once ($CFG->dirroot . '/course/lib.php');
		
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		$ret->id = $course->id;
		$ret->error = "";
		$ret->status = true;
		
		//DIMAS: to fix single quote in course title
		//$course->fullname = addslashes($course->fullname);
		
		switch (trim ( strtolower ( $course->action ) )) {
			case 'add' :
				/// Adding a new course.

				if (! $this->has_capability ( 'moodle/course:create', CONTEXT_SYSTEM, 0 )) {
					$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
					$ret->status = false;
					break;
				}
				
				// fix record if needed and check for missing values or database collision
				/*if ($errmsg=ws_checkcourserecord($course,true)) {
					$ret->error=$errmsg;
					break;
				}*/
				//NAIT Custom: to allow legacy files when copying content
				$course->legacyfiles = 2;
				if ($newCourse = create_course ( $course )) {
					//$this->debug_output ('New course '.print_r ( $newCourse, true ));					
					$this->debug_output ( 'inserion ok' . print_r ( $course, true ) );
					events_trigger ( 'course_created', $course );
					$ret->id = $newCourse->id;

					//NAIT Cstom - Add course outline link
					//only include if CFG values is not defined or set to false (default is show it)
					if( empty($CFG->excludeCourseOutlineLinkInNewCourses) || $CFG->excludeCourseOutlineLinkInNewCourses == false )
					{
						$this->addCourseOutlineLabel($newCourse->id);
					}
				} else {
					$ret->error = get_string ( 'ws_errorcreatingcourse', 'local_wspp', $course->shortname );
					$this->debug_output ( 'insertion KO ' . print_r ( $course, true ) );
				}
				
				break;
			case 'update' :
				if (! $this->has_capability ( 'moodle/course:update', CONTEXT_SYSTEM, 0 )) {
					$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
					break;
				}
				if (! $oldcourse = ws_get_record ( 'course', 'id', $course->id )) {
					$ret->error = get_string ( 'ws_courseunknown', 'local_wspp', "id=" . $course->id );
					break;
				}
				
				//GROS PB avec le record rempli de 0 !!!!
				
				if (ws_update_record ( 'course', $course )) {
					events_trigger ( 'course_updated', $course );
                    
                    if( $oldcourse->category != $course->category)
                    {
                        //if category changed then this will fix the category course counts
                        fix_course_sortorder();
                    }
                    
				} else {
					$ret->error = get_string ( 'ws_errorupdatingcourse', 'local_wspp', $course->id );
				}
				break;
			case 'delete' :
				if (! $this->has_capability ( 'moodle/course:delete', CONTEXT_SYSTEM, 0 )) {
					$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
					break;
				}
				if (! $oldcourse = ws_get_record ( 'course', 'id', $course->id )) {
					$ret->error = get_string ( 'ws_courseunknown', 'local_wspp', "id=" . $course->id );
					break;
				}
				
				if (! delete_course ( $course )) {
					$ret->error = get_string ( 'ws_errordeletingcourse', 'local_wspp', $course->id );
				} else {
					events_trigger ( 'course_deleted', $course );
				}
				break;
			default :
				$ret->error = get_string ( 'ws_invalidaction', 'local_wspp', $course->action );
				$ret->status = false;
				
				break;
		}
		
		return $ret;
	}
	
	//NAIT - Get Online User
	function getOnlineUserCount($client, $sesskey, $minute) {
		global $CFG, $DB;
		
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		$timefrom = 100 * floor((time()-(60*$minute)) / 100); // Round to nearest 100 seconds for better query cache
		
		$csql = "SELECT COUNT(DISTINCT(u.id))
                 FROM {user} u 
                 WHERE u.lastaccess > $timefrom";
		$usercount = $DB->count_records_sql($csql);
		return $usercount;
    }
	
	//NAIT Custom - to create a label to get Course Outline for the course
	function addCourseOutlineLabel($courseid){
		global $CFG, $DB;
		require_once ($CFG->dirroot . '/mod/label/lib.php');
		require_once ($CFG->dirroot . '/course/lib.php');
		
		//Create the label
		$label = new object();
		$label->course = $courseid;
		$label->name = 'Course Outline';
		$label->intro = '<p><img src="' . $CFG->wwwroot . '/theme/image.php?theme=nait&amp;image=f%2Fpdf&amp;rev=152" style="vertical-align: middle;" /> <a href="#" onclick="ViewCourseOutline();">Course Outline</a></p>';
		$label->introformat = 1;
		$labelid = label_add_instance($label);
		
		//Create the course module and add it to section 0
		$mod = new object();
		$mod->course = $courseid;
		$mod->module = 9;
		$mod->instance = $labelid;
		$mod->section = $DB->get_record("course_sections", array("course"=>$mod->course, "section"=>0))->id;
		//default fields
		$mod->score =0;
		$mod->indent=0;
		$mod->visible=1;
		$mod->visibleold=1;
		$mod->groupmode=0;
		$mod->groupingid=0;
		$mod->groupmembersonly=0;
		$mod->completion=0;
		$mod->completionview=0;
		$mod->completionexpected = 0;
		$mod->availablefrom= 0;
		$mod->availableuntil= 0;
		$mod->showavailability= 1;
		$mod->id = add_course_module($mod);
		
		//add into section 0
		$sectionMod = new object();
		$sectionMod->course = $courseid;
		$sectionMod->section = 0;
		$sectionMod->coursemodule = $mod->id;
		$sectionId = add_mod_to_section($sectionMod);
		return $sectionId; 
	}
	
	function editCategory($client, $sesskey, $category) {
		global $CFG;
		require_once ("{$CFG->dirroot}/course/lib.php");
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		$ret->id = $category->id;
		$ret->error = "";
		$ret->status = true;
		
		switch (trim ( strtolower ( $category->action ) )) {
			case 'add' :
				/// Adding a new category.
				

				if (! $this->has_capability ( 'moodle/category:manage', CONTEXT_SYSTEM, 0 )) {
					$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
					$ret->status = false;
					break;
				}
				
				if ($oldcategory = ws_get_record ( 'course_categories', 'name', $category->name )) {
					if ($oldcategory->parent == $category->parent) {
						$ret->error = "Category '" . $category->name . "' already exists for parentid of " . $category->parent;
						$ret->status = false;
						break;
					}
				}
			
                
				if ($categoryid = ws_insert_record ( 'course_categories', $category )) {
					$this->debug_output ( 'inserion ok' . print_r ( $category, true ) );
					events_trigger ( 'category_created', $category );
					$ret->id = $categoryid;
                    
                    if( $category->parent != 0 )
                    {
                        $oldcategory = ws_get_record ( 'course_categories', 'id', $categoryid );
                        $parentcat = ws_get_record ( 'course_categories', 'id', $category->parent );
                        
                        move_category($oldcategory,$parentcat);                    
                    }
					
				} else {
					$ret->error = get_string ( 'ws_errorcreatingcategory', 'local_wspp', $category->shortname );
					$this->debug_output ( 'insertion KO ' . print_r ( $category, true ) );
				}
				
				break;
			case 'update' :
				if (! $this->has_capability ( 'moodle/category:manage', CONTEXT_SYSTEM, 0 )) {
					$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
					break;
				}
				if (! $oldcategory = ws_get_record ( 'course_categories', 'id', $category->id )) {
					$ret->error = get_string ( 'ws_categoryunknown', 'local_wspp', "id=" . $category->id );
					break;
				}

                if( $oldcategory->parent != $category->parent )
                {
                    $parentcat = ws_get_record ( 'course_categories', 'id', $category->parent );
                    
                    move_category($oldcategory,$parentcat);
                    
                    $oldcategory = ws_get_record ( 'course_categories', 'id', $category->id );
                    
                    $category->path = $oldcategory->path;
                    $category->depth = $oldcategory->depth;
                }
                
				if (ws_update_record ( 'course_categories', $category )) {
					events_trigger ( 'category_updated', $category );
				} else {
					$ret->error = get_string ( 'ws_errorupdatingcategory', 'local_wspp', $category->id );
				}
				break;
			case 'delete' :
				if (! $this->has_capability ( 'moodle/category:manage', CONTEXT_SYSTEM, 0 )) {
					$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
					break;
				}
				if (! $oldcategory = ws_get_record ( 'course_categories', 'id', $category->id )) {
					$ret->error = get_string ( 'ws_categoryunknown', 'local_wspp', "id=" . $category->id );
					break;
				}
				
				if (! category_delete_move ( $category, 1, false )) {
					$ret->error = get_string ( 'ws_errordeletingcategory', 'local_wspp', $category->id );
				} else {
					events_trigger ( 'category_deleted' );
				}
				break;
			default :
				$ret->error = get_string ( 'ws_invalidaction', 'local_wspp', $category->action );
				$ret->status = false;
				
				break;
		}
		
		return $ret;
	}
	
	function modifyUserCohortEnrolments($client, $sesskey, $cohortid, $cohortidfield, $userEnrolments) {
		global $CFG;
		require_once ($CFG->dirroot . '/course/lib.php');
		require_once ($CFG->dirroot . '/user/lib.php');
		
		if ($CFG->wspp_using_moodle20) {
			require_once ($CFG->dirroot . '/cohort/lib.php');
		} else
			return $this->error ( get_string ( 'ws_moodle20only', 'local_wspp' ) );
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		$ret = array ();
		
		if (! empty ( $userEnrolments )) {
			
			if (! $cohort = ws_get_record ( 'cohort', $cohortidfield, $cohortid )) {
				$record = new affectRecord ();
				$record->error = get_string ( 'ws_cohortunknown', 'local_wspp', "id=" . $cohortid );
				$record->status = false;
				$ret [] = $record;
				
				return $ret;
			}
			
			foreach ( $userEnrolments as $userEnrolment ) {
				$record = new affectRecord ();
				
				$user = ws_get_record ( 'user', 'username', $userEnrolment->user->username );
				
				if ($userEnrolment->addUser) {
					
					$isOk = true;
					
					//first check if the user exists
					if (empty ( $user )) {
						
						if (! $this->has_capability ( 'moodle/user:create', CONTEXT_SYSTEM, 0 )) {
							$record->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
							$isOk = false;
						} else {
							$record->error = 'Create user';
							
							$newUser = new userDatum ();
							$newUser->username = $userEnrolment->user->username;
							$newUser->firstname = $userEnrolment->user->firstname;
							$newUser->lastname = $userEnrolment->user->lastname;
							$newUser->email = $userEnrolment->user->email;
							$newUser->idnumber = $userEnrolment->user->idnumber;
							
							$newUser->timecreated = time ();
							$newUser->timemodified = $newUser->timecreated;
							$newUser->auth = 'ldap';
							$newUser->confirmed = true;
							$newUser->mnethostid = $CFG->mnet_localhost_id;
							
							if ($userid = user_create_user ( $newUser )) {
								$user = ws_get_record ( 'user', 'id', $userid );
								$this->debug_output ( 'inserion ok' . print_r ( $user, true ) );
								events_trigger ( 'user_created', $user );
								
							} else {
								$isOk = false;
								$record->error = 'Error inserting user --> ' . $userEnrolment->user->username;
								$this->debug_output ( 'insertion KO ' . print_r ( $user, true ) );
							}
						}
						
					} else {
						//exists
						

					}
					
					if ($isOk == true) {
						
						//make sure the user isnt there already
						if (! $exists = ws_get_record ( 'cohort_members', 'cohortid', $cohort->id, 'userid', $user->id )) {
							if (empty ( $exists->id )) {
								cohort_add_member ( $cohort->id, $user->id );
								$resp->status = 1;
								$record->status = true;
							}
						}
					}
				} else {
					//if user doesnt exists, then ignore
					if (! empty ( $user )) {
						cohort_remove_member ( $cohort->id, $user->id );
						$record->status = 1;
					}
				}
				
				$ret [] = $record;
			}
		}
		
		return $ret;
	}
	
	function getCohort($client, $sesskey, $cohortid, $cohortidfield) {
		
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		//sleep(400);
		if (! $ret = ws_get_record ( 'cohort', $cohortidfield, $cohortid )) {
			$ret = get_string ( 'ws_cohortunknown', 'local_wspp', "id=" . $cohortid );
			return $ret;
		}
		
		$ret->error = "";
		
		return $ret;
	}
	
	function getUser($client, $sesskey, $userid, $useridfield) {
		global $CFG;
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		//NAIT: Postgres is case sensitive
		if ($CFG->dbtype=="pgsql" && $useridfield=="username"){
			$userid = strtolower($userid);
			$useridfield = "lower($useridfield)";
		}
		if (! $ret = ws_get_record ( 'user', $useridfield, $userid )) {
			$ret = get_string ( 'ws_userunknown', 'local_wspp', "id=" . $userid );
			return $ret;
		}
		
		$ret->error = "";
		
		return $ret;
	}
	
	function getCourse($client, $sesskey, $courseid, $courseidfield) {
		global $CFG;
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		//NAIT: Postgres is case sensitive
		if ($CFG->dbtype=="pgsql" && $courseidfield=="shortname"){
			$courseid = strtolower($courseid);
			$courseidfield = "lower($courseidfield)";
		}
		
		if (! $ret = ws_get_record ( 'course', $courseidfield, $courseid )) {
			$ret = get_string ( 'ws_courseunknown', 'local_wspp', "id=" . $courseid );
			return $ret;
		}
		
		$ret->error = "";
		
		return $ret;
	}
	
	function getCategory($client, $sesskey, $categoryid, $categoryidfield) {
		
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		if (! $ret = ws_get_record ( 'course_categories', $categoryidfield, $categoryid )) {
			$ret = get_string ( 'ws_categoryunknown', 'local_wspp', "id=" . $categoryid );
			return $ret;
		}
		
		$ret->error = "";
		
		return $ret;
	}
    
    function getCategorySubCategories($client, $sesskey, $categoryid, $categoryidfield) {
		
		if (! $this->validate_client ( $client, $sesskey, __FUNCTION__ )) {
            return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		if (! $categories = ws_get_records ( 'course_categories', 'parent', $categoryid )) {
			$categories = get_string ( 'ws_categoryunknown', 'local_wspp', "id=" . $categoryid );
			return $categories;
		}
        
        $ret = array ();
		
		foreach ( $categories as $category ) {
            $category->error = '';
            $ret [] = $category;
		}
		
		return $ret;
	}
	
	function getCourseUsers($client, $sesskey, $courseid, $courseidfield, $roleid, $roleidfield, $includeCohortUsers = true) {
		global $user;
		if (! $this->validate_client ( $client, $sesskey, __function__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		if (! $course = ws_get_record ( 'course', $courseidfield, $courseid )) {
			return $this->error ( get_string ( 'ws_courseunknown', 'local_wspp', $courseidfield . "=" . $courseid ) );
		}
		
		if (! $this->has_capability ( 'moodle/course:update', CONTEXT_COURSE, $course->id ) && ! ws_is_enrolled ( $course->id, $user->id ))
			return $this->error ( get_string ( 'ws_operationnotallowed', 'local_wspp' ) );
		
		if (! empty ( $roleid ) && ! ws_record_exists ( 'role', $roleidfield, $roleid ))
			return $this->error ( get_string ( 'ws_roleunknown', 'local_wspp', $roleid ) );
		
		if( $roleid && $roleidfield)
		{
			$role = ws_get_record ( 'role', $roleidfield, $roleid );
			$roleid = $role->id;
		}
		
		$context = get_context_instance ( CONTEXT_COURSE, $course->id );
		
		//This is so we can get the is cohorts
		$fields = 'u.id, u.confirmed, u.username, u.firstname, u.lastname, ' . 'u.maildisplay, u.mailformat, u.maildigest, u.email, u.city, ' . 'u.country, u.picture, u.idnumber, u.department, u.institution, ' . 'u.emailstop, u.lang, u.timezone, u.lastaccess, u.mnethostid, r.shortname as rolename, ra.component,ra.contextid';
		
		$ret = array ();
		
		if ($users = $this->get_role_users_include_Sections ( $roleid, $context, false, $fields )) {
			
			foreach ( $users as $user ) {
				$user->sectionString = $user->classsection;
				if (empty ( $user->component )) {
					$user->isFromCohort = false;
					$ret [] = $user;
				} else {
					if ($includeCohortUsers == true) {
						$user->isFromCohort = true;
						$ret [] = $user;
					}
				}
				
			}
			
		}
		
		return $ret;
	}
	
	function get_role_users_include_Sections($roleid, $context, $parent = false, $fields = '',
		$sort = 'u.lastname, u.firstname', $gethidden_ignored = null, $group = '',
		$limitfrom = '', $limitnum = '', $extrawheretest = '', $whereparams = array()) {
		global $DB, $CFG;
		
		$parentcontexts = '';
		if ($parent) {
			$parentcontexts = substr($context->path, 1); // kill leading slash
			$parentcontexts = str_replace('/', ',', $parentcontexts);
			if ($parentcontexts !== '') {
				$parentcontexts = ' OR ra.contextid IN ('.$parentcontexts.' )';
			}
		}

		if ($roleid) {
			list($rids, $params) = $DB->get_in_or_equal($roleid, SQL_PARAMS_QM);
			$roleselect = "AND ra.roleid $rids";
		} else {
			$params = array();
			$roleselect = '';
		}

		if ($group) {
			$groupjoin   = "JOIN {groups_members} gm ON gm.userid = u.id";
			$groupselect = " AND gm.groupid = ? ";
			$params[] = $group;
		} else {
			$groupjoin   = '';
			$groupselect = '';
		}

		array_unshift($params, $context->id);

		if ($extrawheretest) {
			$extrawheretest = ' AND ' . $extrawheretest;
			$params = array_merge($params, $whereparams);
		}

		$sql = "SELECT DISTINCT $fields, ra.roleid, racs.classsection as classsection
              FROM {role_assignments} ra
              JOIN {user} u ON u.id = ra.userid
              JOIN {role} r ON ra.roleid = r.id
			left JOIN {$CFG->prefix}role_assignments_class_sections racs on racs.roleassignmentsid = ra.id			
        $groupjoin
             WHERE (ra.contextid = ? $parentcontexts)
                   $roleselect
                   $groupselect
                   $extrawheretest
          ORDER BY $sort";                  // join now so that we can just use fullname() later

		return $DB->get_records_sql($sql, $params, $limitfrom, $limitnum);
	}
	
	function getCohortUsers($client, $sesskey, $cohortid, $cohortidfield) {
		global $user;
		global $CFG;
		if ($CFG->wspp_using_moodle20) {
			require_once ($CFG->dirroot . '/cohort/lib.php');
		} else
			return $this->error ( get_string ( 'ws_moodle20only', 'local_wspp' ) );
		
		if (! $this->validate_client ( $client, $sesskey, __function__ )) {
			return $this->error ( get_string ( 'ws_invalidclient', 'local_wspp' ) );
		}
		
		if (! $this->has_capability ( 'moodle/cohort:manage', CONTEXT_SYSTEM, 0 )) {
			$ret->error = get_string ( 'ws_operationnotallowed', 'local_wspp' );
			$ret->status = false;
			break;
		}
		
		if (! $cohort = ws_get_record ( 'cohort', $cohortidfield, $cohortid )) {
			return $this->error ( get_string ( 'ws_cohortunknown', 'local_wspp', $cohortidfield . "=" . $cohortid ) );
		}
		
		if ($ret = $this->getCohortUserSearch ( $cohort )) {
			//rev 1.6 if $roleid is empty return primary role for each user
			

			return $ret;
			
		} else {
			return array ();
		}
	}

	function GetUserProfileBase64Image($userName, $filename = 'f1') {
                global $DB;

                if ($user = $DB->get_record('user', array('username'=>$userName))) {

                        $pic = new user_picture($user);
                        //print_r($pic);
                        //return;
                        $context = context_user::instance($user->id, IGNORE_MISSING);

                        $fs = get_file_storage();

                        if (!$file = $fs->get_file($context->id, 'user', 'icon', 0, '/', $filename.'.png')) {
                                if (!$file = $fs->get_file($context->id, 'user', 'icon', 0, '/', $filename.'.jpg')) {
                                        if ($filename === 'f3') {
                                                // f3 512x512px was introduced in 2.3, there might be only the smaller version.
                                                if (!$file = $fs->get_file($context->id, 'user', 'icon', 0, '/', 'f1.png')) {
                                                         $file = $fs->get_file($context->id, 'user', 'icon', 0, '/', 'f1.jpg');
                                                }
                                        }
                                }
                        }

                        if( $file != null )
                        {
                                $data = $file->get_content();
                                $base64 = 'data:image\png;base64,' . base64_encode($data);
                                return $base64;
                        }
                        else
                        {
                                $moodlePage = new moodle_page();
                                $moodlePage->set_context(context_course::instance(1));

                                $renderer = $moodlePage->get_renderer('core');

                                $defaulturl = $renderer->pix_url('u/'.$filename); // default image

                                //echo $defaulturl;
                                $contType = get_headers($defaulturl,1);
                                $type = $contType['Content-Type'];
                                $data = file_get_contents($defaulturl);
                                //echo $data;
                                $base64 = 'data:' . $type . ';base64,' . base64_encode($data);
                                return $base64;
                        }
                }
        }

}
?>
