<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class addEnrollStudentsIncludeSectionOutput {
	/** 
	* @var userRecord[]
	*/
	public $students;

	/**
	* default constructor for class addEnrollStudentsIncludeSectionOutput
	* @param userRecord[] $students
	* @return addEnrollStudentsIncludeSectionOutput
	*/
	 public function addEnrollStudentsIncludeSectionOutput($students=array()){
		 $this->students=$students   ;
	}
	/* get accessors */

	/**
	* @return userRecord[]
	*/
	public function getStudents(){
		 return $this->students;
	}

	/*set accessors */

	/**
	* @param userRecord[] $students
	* @return void
	*/
	public function setStudents($students){
		$this->students=$students;
	}

}

?>
