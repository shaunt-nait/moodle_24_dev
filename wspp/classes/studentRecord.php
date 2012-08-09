<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class studentRecord {
	/** 
	* @var integer
	*/
	public $userid;
	/** 
	* @var integer
	*/
	public $course;
	/** 
	* @var integer
	*/
	public $timestart;
	/** 
	* @var integer
	*/
	public $timeend;
	/** 
	* @var integer
	*/
	public $timeaccess;
	/** 
	* @var string
	*/
	public $enrol;

	/**
	* default constructor for class studentRecord
	* @param integer $userid
	* @param integer $course
	* @param integer $timestart
	* @param integer $timeend
	* @param integer $timeaccess
	* @param string $enrol
	* @return studentRecord
	*/
	 public function studentRecord($userid=0,$course=0,$timestart=0,$timeend=0,$timeaccess=0,$enrol=''){
		 $this->userid=$userid   ;
		 $this->course=$course   ;
		 $this->timestart=$timestart   ;
		 $this->timeend=$timeend   ;
		 $this->timeaccess=$timeaccess   ;
		 $this->enrol=$enrol   ;
	}
	/* get accessors */

	/**
	* @return integer
	*/
	public function getUserid(){
		 return $this->userid;
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
	public function getTimestart(){
		 return $this->timestart;
	}


	/**
	* @return integer
	*/
	public function getTimeend(){
		 return $this->timeend;
	}


	/**
	* @return integer
	*/
	public function getTimeaccess(){
		 return $this->timeaccess;
	}


	/**
	* @return string
	*/
	public function getEnrol(){
		 return $this->enrol;
	}

	/*set accessors */

	/**
	* @param integer $userid
	* @return void
	*/
	public function setUserid($userid){
		$this->userid=$userid;
	}


	/**
	* @param integer $course
	* @return void
	*/
	public function setCourse($course){
		$this->course=$course;
	}


	/**
	* @param integer $timestart
	* @return void
	*/
	public function setTimestart($timestart){
		$this->timestart=$timestart;
	}


	/**
	* @param integer $timeend
	* @return void
	*/
	public function setTimeend($timeend){
		$this->timeend=$timeend;
	}


	/**
	* @param integer $timeaccess
	* @return void
	*/
	public function setTimeaccess($timeaccess){
		$this->timeaccess=$timeaccess;
	}


	/**
	* @param string $enrol
	* @return void
	*/
	public function setEnrol($enrol){
		$this->enrol=$enrol;
	}

}

?>
