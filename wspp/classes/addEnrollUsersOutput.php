<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class addEnrollUsersOutput {
	/** 
	* @var userRecord[]
	*/
	public $users;

	/**
	* default constructor for class addEnrollUsersOutput
	* @param userRecord[] $users
	* @return addEnrollUsersOutput
	*/
	 public function addEnrollUsersOutput($users=array()){
		 $this->users=$users   ;
	}
	/* get accessors */

	/**
	* @return userRecord[]
	*/
	public function getUsers(){
		 return $this->users;
	}

	/*set accessors */

	/**
	* @param userRecord[] $users
	* @return void
	*/
	public function setUsers($users){
		$this->users=$users;
	}

}

?>
