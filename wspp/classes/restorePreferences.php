<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class restorePreferences {
	/** 
	* @var boolean
	*/
	public $emptyfirst;
	/** 
	* @var boolean
	*/
	public $userdata;
	/** 
	* @var boolean
	*/
	public $metacourse;
	/** 
	* @var boolean
	*/
	public $logs;
	/** 
	* @var boolean
	*/
	public $course_files;
	/** 
	* @var boolean
	*/
	public $messages;

	/**
	* default constructor for class restorePreferences
	* @param boolean $emptyfirst
	* @param boolean $userdata
	* @param boolean $metacourse
	* @param boolean $logs
	* @param boolean $course_files
	* @param boolean $messages
	* @return restorePreferences
	*/
	 public function restorePreferences($emptyfirst=false,$userdata=false,$metacourse=false,$logs=false,$course_files=false,$messages=false){
		 $this->emptyfirst=$emptyfirst   ;
		 $this->userdata=$userdata   ;
		 $this->metacourse=$metacourse   ;
		 $this->logs=$logs   ;
		 $this->course_files=$course_files   ;
		 $this->messages=$messages   ;
	}
	/* get accessors */

	/**
	* @return boolean
	*/
	public function getEmptyfirst(){
		 return $this->emptyfirst;
	}


	/**
	* @return boolean
	*/
	public function getUserdata(){
		 return $this->userdata;
	}


	/**
	* @return boolean
	*/
	public function getMetacourse(){
		 return $this->metacourse;
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
	public function getCourse_files(){
		 return $this->course_files;
	}


	/**
	* @return boolean
	*/
	public function getMessages(){
		 return $this->messages;
	}

	/*set accessors */

	/**
	* @param boolean $emptyfirst
	* @return void
	*/
	public function setEmptyfirst($emptyfirst){
		$this->emptyfirst=$emptyfirst;
	}


	/**
	* @param boolean $userdata
	* @return void
	*/
	public function setUserdata($userdata){
		$this->userdata=$userdata;
	}


	/**
	* @param boolean $metacourse
	* @return void
	*/
	public function setMetacourse($metacourse){
		$this->metacourse=$metacourse;
	}


	/**
	* @param boolean $logs
	* @return void
	*/
	public function setLogs($logs){
		$this->logs=$logs;
	}


	/**
	* @param boolean $course_files
	* @return void
	*/
	public function setCourse_files($course_files){
		$this->course_files=$course_files;
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
