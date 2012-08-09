<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class backupPreferences {
	/** 
	* @var boolean
	*/
	public $metacourse;
	/** 
	* @var boolean
	*/
	public $users;
	/** 
	* @var boolean
	*/
	public $logs;
	/** 
	* @var boolean
	*/
	public $user_files;
	/** 
	* @var boolean
	*/
	public $course_files;
	/** 
	* @var boolean
	*/
	public $site_files;
	/** 
	* @var boolean
	*/
	public $messages;

	/**
	* default constructor for class backupPreferences
	* @param boolean $metacourse
	* @param boolean $users
	* @param boolean $logs
	* @param boolean $user_files
	* @param boolean $course_files
	* @param boolean $site_files
	* @param boolean $messages
	* @return backupPreferences
	*/
	 public function backupPreferences($metacourse=false,$users=false,$logs=false,$user_files=false,$course_files=false,$site_files=false,$messages=false){
		 $this->metacourse=$metacourse   ;
		 $this->users=$users   ;
		 $this->logs=$logs   ;
		 $this->user_files=$user_files   ;
		 $this->course_files=$course_files   ;
		 $this->site_files=$site_files   ;
		 $this->messages=$messages   ;
	}
	/* get accessors */

	/**
	* @return boolean
	*/
	public function getMetacourse(){
		 return $this->metacourse;
	}


	/**
	* @return boolean
	*/
	public function getUsers(){
		 return $this->users;
	}


	/**
	* @return boolean
	*/
	public function getLogs(){
		 return $this->logs;
	}


	/**
	* @return boolean
	*/
	public function getUser_files(){
		 return $this->user_files;
	}


	/**
	* @return boolean
	*/
	public function getCourse_files(){
		 return $this->course_files;
	}


	/**
	* @return boolean
	*/
	public function getSite_files(){
		 return $this->site_files;
	}


	/**
	* @return boolean
	*/
	public function getMessages(){
		 return $this->messages;
	}

	/*set accessors */

	/**
	* @param boolean $metacourse
	* @return void
	*/
	public function setMetacourse($metacourse){
		$this->metacourse=$metacourse;
	}


	/**
	* @param boolean $users
	* @return void
	*/
	public function setUsers($users){
		$this->users=$users;
	}


	/**
	* @param boolean $logs
	* @return void
	*/
	public function setLogs($logs){
		$this->logs=$logs;
	}


	/**
	* @param boolean $user_files
	* @return void
	*/
	public function setUser_files($user_files){
		$this->user_files=$user_files;
	}


	/**
	* @param boolean $course_files
	* @return void
	*/
	public function setCourse_files($course_files){
		$this->course_files=$course_files;
	}


	/**
	* @param boolean $site_files
	* @return void
	*/
	public function setSite_files($site_files){
		$this->site_files=$site_files;
	}


	/**
	* @param boolean $messages
	* @return void
	*/
	public function setMessages($messages){
		$this->messages=$messages;
	}

}

?>
