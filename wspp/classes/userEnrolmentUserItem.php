<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class userEnrolmentUserItem {
	/** 
	* @var string
	*/
	public $userName;
	/** 
	* @var string
	*/
	public $firstName;
	/** 
	* @var string
	*/
	public $lastName;

	/**
	* default constructor for class userEnrolmentUserItem
	* @param string $userName
	* @param string $firstName
	* @param string $lastName
	* @return userEnrolmentUserItem
	*/
	 public function userEnrolmentUserItem($userName='',$firstName='',$lastName=''){
		 $this->userName=$userName   ;
		 $this->firstName=$firstName   ;
		 $this->lastName=$lastName   ;
	}
	/* get accessors */

	/**
	* @return string
	*/
	public function getUserName(){
		 return $this->userName;
	}


	/**
	* @return string
	*/
	public function getFirstName(){
		 return $this->firstName;
	}


	/**
	* @return string
	*/
	public function getLastName(){
		 return $this->lastName;
	}

	/*set accessors */

	/**
	* @param string $userName
	* @return void
	*/
	public function setUserName($userName){
		$this->userName=$userName;
	}


	/**
	* @param string $firstName
	* @return void
	*/
	public function setFirstName($firstName){
		$this->firstName=$firstName;
	}


	/**
	* @param string $lastName
	* @return void
	*/
	public function setLastName($lastName){
		$this->lastName=$lastName;
	}

}

?>
