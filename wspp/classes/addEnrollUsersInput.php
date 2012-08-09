<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class addEnrollUsersInput {
	/** 
	* @var userDatum[]
	*/
	public $users;

	/**
	* default constructor for class addEnrollUsersInput
	* @param userDatum[] $users
	* @return addEnrollUsersInput
	*/
	 public function addEnrollUsersInput($users=array()){
		 $this->users=$users   ;
	}
	/* get accessors */

	/**
	* @return userDatum[]
	*/
	public function getUsers(){
		 return $this->users;
	}

	/*set accessors */

	/**
	* @param userDatum[] $users
	* @return void
	*/
	public function setUsers($users){
		$this->users=$users;
	}

}

?>
