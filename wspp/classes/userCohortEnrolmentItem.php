<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class userCohortEnrolmentItem {
	/** 
	* @var userEnrolmentUserItem
	*/
	public $user;
	/** 
	* @var boolean
	*/
	public $addUser;

	/**
	* default constructor for class userCohortEnrolmentItem
	* @param userEnrolmentUserItem $user
	* @param boolean $addUser
	* @return userCohortEnrolmentItem
	*/
	 public function userCohortEnrolmentItem($user=NULL,$addUser=false){
		 $this->user=$user   ;
		 $this->addUser=$addUser   ;
	}
	/* get accessors */

	/**
	* @return userEnrolmentUserItem
	*/
	public function getUser(){
		 return $this->user;
	}


	/**
	* @return boolean
	*/
	public function getAddUser(){
		 return $this->addUser;
	}

	/*set accessors */

	/**
	* @param userEnrolmentUserItem $user
	* @return void
	*/
	public function setUser($user){
		$this->user=$user;
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
