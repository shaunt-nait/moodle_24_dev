<?php
/**
 * MoodleWS class file
 * 
 * @author    Patrick Pollet :<patrick.pollet@insa-lyon.fr>
 * @copyright (c) P.Pollet 2007 under GPL
 * @package   MoodleWS
 */

define('DEBUG',true);
if (DEBUG) ini_set('soap.wsdl_cache_enabled', '0');  // no caching by php in debug mode

/**
 * affectRecord class
 */
require_once 'affectRecord.php';
/**
 * profileitemRecord class
 */
require_once 'profileitemRecord.php';
/**
 * userRecord class
 */
require_once 'userRecord.php';
/**
 * loginReturn class
 */
require_once 'loginReturn.php';
/**
 * cohortDatum class
 */
require_once 'cohortDatum.php';
/**
 * cohortRecord class
 */
require_once 'cohortRecord.php';
/**
 * courseRecord class
 */
require_once 'courseRecord.php';
/**
 * courseDatum class
 */
require_once 'courseDatum.php';
/**
 * userDatum class
 */
require_once 'userDatum.php';
/**
 * categoryDatum class
 */
require_once 'categoryDatum.php';
/**
 * categoryRecord class
 */
require_once 'categoryRecord.php';
/**
 * backupPreferences class
 */
require_once 'backupPreferences.php';
/**
 * restorePreferences class
 */
require_once 'restorePreferences.php';
/**
 * userEnrolmentItem class
 */
require_once 'userEnrolmentItem.php';
/**
 * userEnrolmentUserItem class
 */
require_once 'userEnrolmentUserItem.php';
/**
 * editedRecord class
 */
require_once 'editedRecord.php';
/**
 * userCohortEnrolmentItem class
 */
require_once 'userCohortEnrolmentItem.php';

/**
 * MoodleWS class
 * the two attributes are made public for debugging purpose
 * i.e. accessing $client->client->__getLast* methods
 * 
 *  
 * 
 * @author    Patrick Pollet :<patrick.pollet@insa-lyon.fr>
 * @copyright (c) P.Pollet 2007 under GPL
 * @package   MoodleWS
 */
class MoodleWS {

 /** 
 * @var SoapClient
 */
  public $client;

  private $uri = 'http://www.nait.ca/moodle/wspp/wsdl';
private $test = '';
  /**
  * Constructor method
  * @param string $wsdl URL of the WSDL
  * @param string $uri
  * @param string[] $options  Soap Client options array (see PHP5 documentation)
  * @return MoodleWS
  */
  public function MoodleWS($wsdl = "http://moodle2-dev2.nait.ca/moodle/wspp/wsdl_pp.php", $uri=null, $options = array()) {
    
  	//$this->test = $wsdl;
  	if($uri != null) {
      $this->uri = $uri;
    };
    $this->client = new SoapClient(null, array('location' => "http://moodle2-dev2.nait.ca/moodle/wspp/service_pp.php",
 'uri' => $this->uri));
   
  }

        private function castTo($className,$res){
            if (class_exists($className)) {
                $aux= new $className();
                foreach ($res as $key=>$value)
                    $aux->$key=$value;
                return $aux;
             } else
                return $res;
        }
  /**
   * MoodleWS Client Login 
   *
   * @param string $username
   * @param string $password
   * @return loginReturn
   */
  public function login($username, $password) {
    
  	//echo $this->uri;
  	$res= $this->client->__soapCall('login', array(
            new SoapParam($username, 'username'),
            new SoapParam($password, 'password')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
      
  return $this->castTo ('loginReturn',$res);
  }

  /**
   * MoodleWS: Client Logout 
   *
   * @param int $client
   * @param string $sesskey
   * @return boolean
   */
  public function logout($client, $sesskey) {
    $res= $this->client->__call('logout', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
   return $res;
  }

  /**
   * MoodleWS: Copy content from one course to another 
   * 
   *
   * @param int $client
   * @param string $sesskey
   * @param int $fromcourseid
   * @param int $tocourseid
   * @return boolean
   */
  public function exec_copy_content($client, $sesskey, $fromcourseid, $tocourseid) {
    $res= $this->client->__call('exec_copy_content', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($fromcourseid, 'fromcourseid'),
            new SoapParam($tocourseid, 'tocourseid')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
   return $res;
  }

  /**
   * MoodleWS: Execute backup of a course 
   *
   * @param int $client
   * @param string $sesskey
   * @param int $courseid
   * @param backupPreferences $prefs
   * @return string
   */
  public function exec_backup($client, $sesskey, $courseid, backupPreferences $prefs) {
    $res= $this->client->__call('exec_backup', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($courseid, 'courseid'),
            new SoapParam($prefs, 'prefs')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
   return $res;
  }

  /**
   * MoodleWS: Add and/or remove users from a course 
   * 
   *
   * @param int $client
   * @param string $sesskey
   * @param userEnrolmentItem[] $userEnrolments
   * @return affectRecord[]
   */
  public function modifyUserEnrolments($client, $sesskey, $userEnrolments) {
    $res= $this->client->__call('modifyUserEnrolments', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($userEnrolments, 'userEnrolments')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
   return $res;
  }

  /**
   * MoodleWS: Add and/or remove users from a course 
   * 
   *
   * @param int $client
   * @param string $sesskey
   * @param string $cohortid
   * @param string $cohortidfield
   * @param string $courseid
   * @param string $courseidfield
   * @param string $roleid
   * @param string $roleidfield
   * @param boolean $addcohorttocourse
   * @return affectRecord
   */
  public function modifyCourseCohortLink($client, $sesskey, $cohortid, $cohortidfield, $courseid, $courseidfield, $roleid, $roleidfield, $addcohorttocourse) {
    $res= $this->client->__call('modifyCourseCohortLink', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($cohortid, 'cohortid'),
            new SoapParam($cohortidfield, 'cohortidfield'),
            new SoapParam($courseid, 'courseid'),
            new SoapParam($courseidfield, 'courseidfield'),
            new SoapParam($roleid, 'roleid'),
            new SoapParam($roleidfield, 'roleidfield'),
            new SoapParam($addcohorttocourse, 'addcohorttocourse')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
  return $this->castTo ('affectRecord',$res);
  }

  /**
   * MoodleWS: Add, Edit or delete a cohort 
   *
   * @param int $client
   * @param string $sesskey
   * @param cohortDatum $cohort
   * @return editedRecord
   */
  public function editCohort($client, $sesskey, cohortDatum $cohort) {
    $res= $this->client->__call('editCohort', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($cohort, 'cohort')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
  return $this->castTo ('editedRecord',$res);
  }

  /**
   * MoodleWS: Add, Edit or delete a user 
   *
   * @param int $client
   * @param string $sesskey
   * @param userDatum $user
   * @return editedRecord
   */
  public function editUser($client, $sesskey, userDatum $user) {
    $res= $this->client->__call('editUser', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($user, 'user')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
  return $this->castTo ('editedRecord',$res);
  }

  /**
   * MoodleWS: Add, Edit or delete a course 
   *
   * @param int $client
   * @param string $sesskey
   * @param courseDatum $course
   * @return editedRecord
   */
  public function editCourse($client, $sesskey, courseDatum $course) {
    $res= $this->client->__call('editCourse', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($course, 'course')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
  return $this->castTo ('editedRecord',$res);
  }

  /**
   * MoodleWS: Add, Edit or delete a category 
   *
   * @param int $client
   * @param string $sesskey
   * @param categoryDatum $category
   * @return editedRecord
   */
  public function editCategory($client, $sesskey, categoryDatum $category) {
    $res= $this->client->__call('editCategory', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($category, 'category')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
  return $this->castTo ('editedRecord',$res);
  }

  /**
   * MoodleWS: Add and/or remove users from a cohort 
   * 
   *
   * @param int $client
   * @param string $sesskey
   * @param string $cohortid
   * @param string $cohortidfield
   * @param userCohortEnrolmentItem[] $userEnrolments
   * @return affectRecord[]
   */
  public function modifyUserCohortEnrolments($client, $sesskey, $cohortid, $cohortidfield, $userEnrolments) {
    $res= $this->client->__call('modifyUserCohortEnrolments', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($cohortid, 'cohortid'),
            new SoapParam($cohortidfield, 'cohortidfield'),
            new SoapParam($userEnrolments, 'userEnrolments')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
   return $res;
  }

  /**
   * MoodleWS: Get a cohort record for specified id 
   * and field 
   *
   * @param int $client
   * @param string $sesskey
   * @param string $cohortid
   * @param string $cohortidfield
   * @return cohortRecord
   */
  public function getCohort($client, $sesskey, $cohortid, $cohortidfield) {
    $res= $this->client->__call('getCohort', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($cohortid, 'cohortid'),
            new SoapParam($cohortidfield, 'cohortidfield')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
  return $this->castTo ('cohortRecord',$res);
  }

  /**
   * MoodleWS: Get a user record for specified id and 
   * field 
   *
   * @param int $client
   * @param string $sesskey
   * @param string $userid
   * @param string $useridfield
   * @return userRecord
   */
  public function getUser($client, $sesskey, $userid, $useridfield) {
    $res= $this->client->__call('getUser', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($userid, 'userid'),
            new SoapParam($useridfield, 'useridfield')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
  return $this->castTo ('userRecord',$res);
  }

  /**
   * MoodleWS: Get a course record for specified id 
   * and field 
   *
   * @param int $client
   * @param string $sesskey
   * @param string $courseid
   * @param string $courseidfield
   * @return courseRecord
   */
  public function getCourse($client, $sesskey, $courseid, $courseidfield) {
    $res= $this->client->__call('getCourse', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($courseid, 'courseid'),
            new SoapParam($courseidfield, 'courseidfield')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
  return $this->castTo ('courseRecord',$res);
  }

  /**
   * MoodleWS: Get a category record for specified 
   * id and field 
   *
   * @param int $client
   * @param string $sesskey
   * @param string $categoryid
   * @param string $categoryidfield
   * @return categoryRecord
   */
  public function getCategory($client, $sesskey, $categoryid, $categoryidfield) {
    $res= $this->client->__call('getCategory', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($categoryid, 'categoryid'),
            new SoapParam($categoryidfield, 'categoryidfield')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
  return $this->castTo ('categoryRecord',$res);
  }

  /**
   * MoodleWS: Get users enrolled in course and specified 
   * role 
   *
   * @param int $client
   * @param string $sesskey
   * @param string $courseid
   * @param string $courseidfield
   * @param string $roleid
   * @param string $roleidfield
   * @return userRecord[]
   */
  public function getCourseUsers($client, $sesskey, $courseid, $courseidfield, $roleid, $roleidfield) {
    $res= $this->client->__call('getCourseUsers', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($courseid, 'courseid'),
            new SoapParam($courseidfield, 'courseidfield'),
            new SoapParam($roleid, 'roleid'),
            new SoapParam($roleidfield, 'roleidfield')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
   return $res;
  }

  /**
   * MoodleWS: Get users enrolled in cohort 
   *
   * @param int $client
   * @param string $sesskey
   * @param string $cohortid
   * @param string $cohortidfield
   * @return userRecord[]
   */
  public function getCohortUsers($client, $sesskey, $cohortid, $cohortidfield) {
    $res= $this->client->__call('getCohortUsers', array(
            new SoapParam($client, 'client'),
            new SoapParam($sesskey, 'sesskey'),
            new SoapParam($cohortid, 'cohortid'),
            new SoapParam($cohortidfield, 'cohortidfield')
      ),
      array(
            'uri' => $this->uri ,
            'soapaction' => ''
           )
      );
   return $res;
  }

}

?>
