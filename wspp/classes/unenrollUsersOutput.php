<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class unenrollUsersOutput {
	/** 
	* @var userRecord[]
	*/
	public $users;

	/**
	* default constructor for class unenrollUsersOutput
	* @param userRecord[] $users
	* @return unenrollUsersOutput
	*/
	 public function unenrollUsersOutput($users=array()){
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
