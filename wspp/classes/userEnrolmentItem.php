<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class userEnrolmentItem {
	/** 
	* @var int
	*/
	public $courseId;
	/** 
	* @var userEnrolmentUserItem
	*/
	public $user;
	/** 
	* @var string
	*/
	public $roleName;
	/** 
	* @var boolean
	*/
	public $addUser;

	/**
	* default constructor for class userEnrolmentItem
	* @param int $courseId
	* @param userEnrolmentUserItem $user
	* @param string $roleName
	* @param boolean $addUser
	* @return userEnrolmentItem
	*/
	 public function userEnrolmentItem($courseId=0,$user=NULL,$roleName='',$addUser=false){
		 $this->courseId=$courseId   ;
		 $this->user=$user   ;
		 $this->roleName=$roleName   ;
		 $this->addUser=$addUser   ;
	}
	/* get accessors */

	/**
	* @return int
	*/
	public function getCourseId(){
		 return $this->courseId;
	}


	/**
	* @return userEnrolmentUserItem
	*/
	public function getUser(){
		 return $this->user;
	}


	/**
	* @return string
	*/
	public function getRoleName(){
		 return $this->roleName;
	}


	/**
	* @return boolean
	*/
	public function getAddUser(){
		 return $this->addUser;
	}

	/*set accessors */

	/**
	* @param int $courseId
	* @return void
	*/
	public function setCourseId($courseId){
		$this->courseId=$courseId;
	}


	/**
	* @param userEnrolmentUserItem $user
	* @return void
	*/
	public function setUser($user){
		$this->user=$user;
	}


	/**
	* @param string $roleName
	* @return void
	*/
	public function setRoleName($roleName){
		$this->roleName=$roleName;
	}


	/**
	* @param boolean $addUser
	* @return void
	*/
	public function setAddUser($addUser){
		$this->addUser=$addUser;
	}

}

?>
