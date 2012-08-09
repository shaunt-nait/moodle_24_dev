<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class addEnrollStudentsIncludeSectionInput {
	/** 
	* @var studentSectionDatum[]
	*/
	public $students;

	/**
	* default constructor for class addEnrollStudentsIncludeSectionInput
	* @param studentSectionDatum[] $students
	* @return addEnrollStudentsIncludeSectionInput
	*/
	 public function addEnrollStudentsIncludeSectionInput($students=array()){
		 $this->students=$students   ;
	}
	/* get accessors */

	/**
	* @return studentSectionDatum[]
	*/
	public function getStudents(){
		 return $this->students;
	}

	/*set accessors */

	/**
	* @param studentSectionDatum[] $students
	* @return void
	*/
	public function setStudents($students){
		$this->students=$students;
	}

}

?>
