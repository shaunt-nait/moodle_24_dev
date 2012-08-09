<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class studentSectionDatum {
	/** 
	* @var string
	*/
	public $username;
	/** 
	* @var string
	*/
	public $sectionCode;

	/**
	* default constructor for class studentSectionDatum
	* @param string $username
	* @param string $sectionCode
	* @return studentSectionDatum
	*/
	 public function studentSectionDatum($username='',$sectionCode=''){
		 $this->username=$username   ;
		 $this->sectionCode=$sectionCode   ;
	}
	/* get accessors */

	/**
	* @return string
	*/
	public function getUsername(){
		 return $this->username;
	}


	/**
	* @return string
	*/
	public function getSectionCode(){
		 return $this->sectionCode;
	}

	/*set accessors */

	/**
	* @param string $username
	* @return void
	*/
	public function setUsername($username){
		$this->username=$username;
	}


	/**
	* @param string $sectionCode
	* @return void
	*/
	public function setSectionCode($sectionCode){
		$this->sectionCode=$sectionCode;
	}

}

?>
