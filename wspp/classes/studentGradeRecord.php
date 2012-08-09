<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class studentGradeRecord {
	/** 
	* @var string
	*/
	public $error;
	/** 
	* @var string
	*/
	public $courseid;
	/** 
	* @var gradeStatsRecord
	*/
	public $stats;
	/** 
	* @var gradeRecord[]
	*/
	public $grades;

	/**
	* default constructor for class studentGradeRecord
	* @param string $error
	* @param string $courseid
	* @param gradeStatsRecord $stats
	* @param gradeRecord[] $grades
	* @return studentGradeRecord
	*/
	 public function studentGradeRecord($error='',$courseid='',$stats=NULL,$grades=array()){
		 $this->error=$error   ;
		 $this->courseid=$courseid   ;
		 $this->stats=$stats   ;
		 $this->grades=$grades   ;
	}
	/* get accessors */

	/**
	* @return string
	*/
	public function getError(){
		 return $this->error;
	}


	/**
	* @return string
	*/
	public function getCourseid(){
		 return $this->courseid;
	}


	/**
	* @return gradeStatsRecord
	*/
	public function getStats(){
		 return $this->stats;
	}


	/**
	* @return gradeRecord[]
	*/
	public function getGrades(){
		 return $this->grades;
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
	* @param string $courseid
	* @return void
	*/
	public function setCourseid($courseid){
		$this->courseid=$courseid;
	}


	/**
	* @param gradeStatsRecord $stats
	* @return void
	*/
	public function setStats($stats){
		$this->stats=$stats;
	}


	/**
	* @param gradeRecord[] $grades
	* @return void
	*/
	public function setGrades($grades){
		$this->grades=$grades;
	}

}

?>
