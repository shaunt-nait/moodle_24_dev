<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class gradeStatsRecord {
	/** 
	* @var integer
	*/
	public $gradeItems;
	/** 
	* @var string
	*/
	public $allgrades;
	/** 
	* @var integer
	*/
	public $points;
	/** 
	* @var integer
	*/
	public $totalpoints;
	/** 
	* @var float
	*/
	public $percent;
	/** 
	* @var float
	*/
	public $weight;
	/** 
	* @var float
	*/
	public $weighted;

	/**
	* default constructor for class gradeStatsRecord
	* @param integer $gradeItems
	* @param string $allgrades
	* @param integer $points
	* @param integer $totalpoints
	* @param float $percent
	* @param float $weight
	* @param float $weighted
	* @return gradeStatsRecord
	*/
	 public function gradeStatsRecord($gradeItems=0,$allgrades='',$points=0,$totalpoints=0,$percent=0.0,$weight=0.0,$weighted=0.0){
		 $this->gradeItems=$gradeItems   ;
		 $this->allgrades=$allgrades   ;
		 $this->points=$points   ;
		 $this->totalpoints=$totalpoints   ;
		 $this->percent=$percent   ;
		 $this->weight=$weight   ;
		 $this->weighted=$weighted   ;
	}
	/* get accessors */

	/**
	* @return integer
	*/
	public function getGradeItems(){
		 return $this->gradeItems;
	}


	/**
	* @return string
	*/
	public function getAllgrades(){
		 return $this->allgrades;
	}


	/**
	* @return integer
	*/
	public function getPoints(){
		 return $this->points;
	}


	/**
	* @return integer
	*/
	public function getTotalpoints(){
		 return $this->totalpoints;
	}


	/**
	* @return float
	*/
	public function getPercent(){
		 return $this->percent;
	}


	/**
	* @return float
	*/
	public function getWeight(){
		 return $this->weight;
	}


	/**
	* @return float
	*/
	public function getWeighted(){
		 return $this->weighted;
	}

	/*set accessors */

	/**
	* @param integer $gradeItems
	* @return void
	*/
	public function setGradeItems($gradeItems){
		$this->gradeItems=$gradeItems;
	}


	/**
	* @param string $allgrades
	* @return void
	*/
	public function setAllgrades($allgrades){
		$this->allgrades=$allgrades;
	}


	/**
	* @param integer $points
	* @return void
	*/
	public function setPoints($points){
		$this->points=$points;
	}


	/**
	* @param integer $totalpoints
	* @return void
	*/
	public function setTotalpoints($totalpoints){
		$this->totalpoints=$totalpoints;
	}


	/**
	* @param float $percent
	* @return void
	*/
	public function setPercent($percent){
		$this->percent=$percent;
	}


	/**
	* @param float $weight
	* @return void
	*/
	public function setWeight($weight){
		$this->weight=$weight;
	}


	/**
	* @param float $weighted
	* @return void
	*/
	public function setWeighted($weighted){
		$this->weighted=$weighted;
	}

}

?>
