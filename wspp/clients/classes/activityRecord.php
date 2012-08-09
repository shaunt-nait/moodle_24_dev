<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class activityRecord {
	/** 
	* @var string
	*/
	public $error;
	/** 
	* @var integer
	*/
	public $id;
	/** 
	* @var integer
	*/
	public $time;
	/** 
	* @var integer
	*/
	public $userid;
	/** 
	* @var string
	*/
	public $ip;
	/** 
	* @var integer
	*/
	public $course;
	/** 
	* @var integer
	*/
	public $module;
	/** 
	* @var integer
	*/
	public $cmid;
	/** 
	* @var string
	*/
	public $action;
	/** 
	* @var string
	*/
	public $url;
	/** 
	* @var string
	*/
	public $info;
	/** 
	* @var string
	*/
	public $DATE;
	/** 
	* @var string
	*/
	public $auth;
	/** 
	* @var string
	*/
	public $firstname;
	/** 
	* @var string
	*/
	public $lastname;
	/** 
	* @var string
	*/
	public $email;
	/** 
	* @var integer
	*/
	public $firstaccess;
	/** 
	* @var integer
	*/
	public $lastaccess;
	/** 
	* @var integer
	*/
	public $lastlogin;
	/** 
	* @var integer
	*/
	public $currentlogin;
	/** 
	* @var string
	*/
	public $DLA;
	/** 
	* @var string
	*/
	public $DFA;
	/** 
	* @var string
	*/
	public $DLL;
	/** 
	* @var string
	*/
	public $DCL;

	/**
	* default constructor for class activityRecord
	* @param string $error
	* @param integer $id
	* @param integer $time
	* @param integer $userid
	* @param string $ip
	* @param integer $course
	* @param integer $module
	* @param integer $cmid
	* @param string $action
	* @param string $url
	* @param string $info
	* @param string $DATE
	* @param string $auth
	* @param string $firstname
	* @param string $lastname
	* @param string $email
	* @param integer $firstaccess
	* @param integer $lastaccess
	* @param integer $lastlogin
	* @param integer $currentlogin
	* @param string $DLA
	* @param string $DFA
	* @param string $DLL
	* @param string $DCL
	* @return activityRecord
	*/
	 public function activityRecord($error='',$id=0,$time=0,$userid=0,$ip='',$course=0,$module=0,$cmid=0,$action='',$url='',$info='',$DATE='',$auth='',$firstname='',$lastname='',$email='',$firstaccess=0,$lastaccess=0,$lastlogin=0,$currentlogin=0,$DLA='',$DFA='',$DLL='',$DCL=''){
		 $this->error=$error   ;
		 $this->id=$id   ;
		 $this->time=$time   ;
		 $this->userid=$userid   ;
		 $this->ip=$ip   ;
		 $this->course=$course   ;
		 $this->module=$module   ;
		 $this->cmid=$cmid   ;
		 $this->action=$action   ;
		 $this->url=$url   ;
		 $this->info=$info   ;
		 $this->DATE=$DATE   ;
		 $this->auth=$auth   ;
		 $this->firstname=$firstname   ;
		 $this->lastname=$lastname   ;
		 $this->email=$email   ;
		 $this->firstaccess=$firstaccess   ;
		 $this->lastaccess=$lastaccess   ;
		 $this->lastlogin=$lastlogin   ;
		 $this->currentlogin=$currentlogin   ;
		 $this->DLA=$DLA   ;
		 $this->DFA=$DFA   ;
		 $this->DLL=$DLL   ;
		 $this->DCL=$DCL   ;
	}
	/* get accessors */

	/**
	* @return string
	*/
	public function getError(){
		 return $this->error;
	}


	/**
	* @return integer
	*/
	public function getId(){
		 return $this->id;
	}


	/**
	* @return integer
	*/
	public function getTime(){
		 return $this->time;
	}


	/**
	* @return integer
	*/
	public function getUserid(){
		 return $this->userid;
	}


	/**
	* @return string
	*/
	public function getIp(){
		 return $this->ip;
	}


	/**
	* @return integer
	*/
	public function getCourse(){
		 return $this->course;
	}


	/**
	* @return integer
	*/
	public function getModule(){
		 return $this->module;
	}


	/**
	* @return integer
	*/
	public function getCmid(){
		 return $this->cmid;
	}


	/**
	* @return string
	*/
	public function getAction(){
		 return $this->action;
	}


	/**
	* @return string
	*/
	public function getUrl(){
		 return $this->url;
	}


	/**
	* @return string
	*/
	public function getInfo(){
		 return $this->info;
	}


	/**
	* @return string
	*/
	public function getDATE(){
		 return $this->DATE;
	}


	/**
	* @return string
	*/
	public function getAuth(){
		 return $this->auth;
	}


	/**
	* @return string
	*/
	public function getFirstname(){
		 return $this->firstname;
	}


	/**
	* @return string
	*/
	public function getLastname(){
		 return $this->lastname;
	}


	/**
	* @return string
	*/
	public function getEmail(){
		 return $this->email;
	}


	/**
	* @return integer
	*/
	public function getFirstaccess(){
		 return $this->firstaccess;
	}


	/**
	* @return integer
	*/
	public function getLastaccess(){
		 return $this->lastaccess;
	}


	/**
	* @return integer
	*/
	public function getLastlogin(){
		 return $this->lastlogin;
	}


	/**
	* @return integer
	*/
	public function getCurrentlogin(){
		 return $this->currentlogin;
	}


	/**
	* @return string
	*/
	public function getDLA(){
		 return $this->DLA;
	}


	/**
	* @return string
	*/
	public function getDFA(){
		 return $this->DFA;
	}


	/**
	* @return string
	*/
	public function getDLL(){
		 return $this->DLL;
	}


	/**
	* @return string
	*/
	public function getDCL(){
		 return $this->DCL;
	}

	/*set accessors */

	/**
	* @param string $error
	* @return void
	*/
	public function setError($error){
		$this->error=$error;
	}


	/**
	* @param integer $id
	* @return void
	*/
	public function setId($id){
		$this->id=$id;
	}


	/**
	* @param integer $time
	* @return void
	*/
	public function setTime($time){
		$this->time=$time;
	}


	/**
	* @param integer $userid
	* @return void
	*/
	public function setUserid($userid){
		$this->userid=$userid;
	}


	/**
	* @param string $ip
	* @return void
	*/
	public function setIp($ip){
		$this->ip=$ip;
	}


	/**
	* @param integer $course
	* @return void
	*/
	public function setCourse($course){
		$this->course=$course;
	}


	/**
	* @param integer $module
	* @return void
	*/
	public function setModule($module){
		$this->module=$module;
	}


	/**
	* @param integer $cmid
	* @return void
	*/
	public function setCmid($cmid){
		$this->cmid=$cmid;
	}


	/**
	* @param string $action
	* @return void
	*/
	public function setAction($action){
		$this->action=$action;
	}


	/**
	* @param string $url
	* @return void
	*/
	public function setUrl($url){
		$this->url=$url;
	}


	/**
	* @param string $info
	* @return void
	*/
	public function setInfo($info){
		$this->info=$info;
	}


	/**
	* @param string $DATE
	* @return void
	*/
	public function setDATE($DATE){
		$this->DATE=$DATE;
	}


	/**
	* @param string $auth
	* @return void
	*/
	public function setAuth($auth){
		$this->auth=$auth;
	}


	/**
	* @param string $firstname
	* @return void
	*/
	public function setFirstname($firstname){
		$this->firstname=$firstname;
	}


	/**
	* @param string $lastname
	* @return void
	*/
	public function setLastname($lastname){
		$this->lastname=$lastname;
	}


	/**
	* @param string $email
	* @return void
	*/
	public function setEmail($email){
		$this->email=$email;
	}


	/**
	* @param integer $firstaccess
	* @return void
	*/
	public function setFirstaccess($firstaccess){
		$this->firstaccess=$firstaccess;
	}


	/**
	* @param integer $lastaccess
	* @return void
	*/
	public function setLastaccess($lastaccess){
		$this->lastaccess=$lastaccess;
	}


	/**
	* @param integer $lastlogin
	* @return void
	*/
	public function setLastlogin($lastlogin){
		$this->lastlogin=$lastlogin;
	}


	/**
	* @param integer $currentlogin
	* @return void
	*/
	public function setCurrentlogin($currentlogin){
		$this->currentlogin=$currentlogin;
	}


	/**
	* @param string $DLA
	* @return void
	*/
	public function setDLA($DLA){
		$this->DLA=$DLA;
	}


	/**
	* @param string $DFA
	* @return void
	*/
	public function setDFA($DFA){
		$this->DFA=$DFA;
	}


	/**
	* @param string $DLL
	* @return void
	*/
	public function setDLL($DLL){
		$this->DLL=$DLL;
	}


	/**
	* @param string $DCL
	* @return void
	*/
	public function setDCL($DCL){
		$this->DCL=$DCL;
	}

}

?>
