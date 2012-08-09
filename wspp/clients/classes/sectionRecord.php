<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class sectionRecord {
	/** 
	* @var string
	*/
	public $error;
	/** 
	* @var integer
	*/
	public $id;
	/** 
	* @var integer
	*/
	public $course;
	/** 
	* @var integer
	*/
	public $section;
	/** 
	* @var string
	*/
	public $sequence;
	/** 
	* @var string
	*/
	public $summary;
	/** 
	* @var integer
	*/
	public $visible;

	/**
	* default constructor for class sectionRecord
	* @param string $error
	* @param integer $id
	* @param integer $course
	* @param integer $section
	* @param string $sequence
	* @param string $summary
	* @param integer $visible
	* @return sectionRecord
	*/
	 public function sectionRecord($error='',$id=0,$course=0,$section=0,$sequence='',$summary='',$visible=0){
		 $this->error=$error   ;
		 $this->id=$id   ;
		 $this->course=$course   ;
		 $this->section=$section   ;
		 $this->sequence=$sequence   ;
		 $this->summary=$summary   ;
		 $this->visible=$visible   ;
	}
	/* get accessors */

	/**
	* @return string
	*/
	public function getError(){
		 return $this->error;
	}


	/**
	* @return integer
	*/
	public function getId(){
		 return $this->id;
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
	public function getSection(){
		 return $this->section;
	}


	/**
	* @return string
	*/
	public function getSequence(){
		 return $this->sequence;
	}


	/**
	* @return string
	*/
	public function getSummary(){
		 return $this->summary;
	}


	/**
	* @return integer
	*/
	public function getVisible(){
		 return $this->visible;
	}

	/*set accessors */

	/**
	* @param string $error
	* @return void
	*/
	public function setError($error){
		$this->error=$error;
	}


	/**
	* @param integer $id
	* @return void
	*/
	public function setId($id){
		$this->id=$id;
	}


	/**
	* @param integer $course
	* @return void
	*/
	public function setCourse($course){
		$this->course=$course;
	}


	/**
	* @param integer $section
	* @return void
	*/
	public function setSection($section){
		$this->section=$section;
	}


	/**
	* @param string $sequence
	* @return void
	*/
	public function setSequence($sequence){
		$this->sequence=$sequence;
	}


	/**
	* @param string $summary
	* @return void
	*/
	public function setSummary($summary){
		$this->summary=$summary;
	}


	/**
	* @param integer $visible
	* @return void
	*/
	public function setVisible($visible){
		$this->visible=$visible;
	}

}

?>
