<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class groupingDatum {
	/** 
	* @var string
	*/
	public $action;
	/** 
	* @var integer
	*/
	public $id;
	/** 
	* @var integer
	*/
	public $courseid;
	/** 
	* @var string
	*/
	public $name;
	/** 
	* @var string
	*/
	public $description;

	/**
	* default constructor for class groupingDatum
	* @param string $action
	* @param integer $id
	* @param integer $courseid
	* @param string $name
	* @param string $description
	* @return groupingDatum
	*/
	 public function groupingDatum($action='',$id=0,$courseid=0,$name='',$description=''){
		 $this->action=$action   ;
		 $this->id=$id   ;
		 $this->courseid=$courseid   ;
		 $this->name=$name   ;
		 $this->description=$description   ;
	}
	/* get accessors */

	/**
	* @return string
	*/
	public function getAction(){
		 return $this->action;
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
	public function getCourseid(){
		 return $this->courseid;
	}


	/**
	* @return string
	*/
	public function getName(){
		 return $this->name;
	}


	/**
	* @return string
	*/
	public function getDescription(){
		 return $this->description;
	}

	/*set accessors */

	/**
	* @param string $action
	* @return void
	*/
	public function setAction($action){
		$this->action=$action;
	}


	/**
	* @param integer $id
	* @return void
	*/
	public function setId($id){
		$this->id=$id;
	}


	/**
	* @param integer $courseid
	* @return void
	*/
	public function setCourseid($courseid){
		$this->courseid=$courseid;
	}


	/**
	* @param string $name
	* @return void
	*/
	public function setName($name){
		$this->name=$name;
	}


	/**
	* @param string $description
	* @return void
	*/
	public function setDescription($description){
		$this->description=$description;
	}

}

?>
