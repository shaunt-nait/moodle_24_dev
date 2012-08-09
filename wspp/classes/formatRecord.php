<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class formatRecord {
	/** 
	* @var string
	*/
	public $idname;
	/** 
	* @var integer
	*/
	public $name;

	/**
	* default constructor for class formatRecord
	* @param string $idname
	* @param integer $name
	* @return formatRecord
	*/
	 public function formatRecord($idname='',$name=0){
		 $this->idname=$idname   ;
		 $this->name=$name   ;
	}
	/* get accessors */

	/**
	* @return string
	*/
	public function getIdname(){
		 return $this->idname;
	}


	/**
	* @return integer
	*/
	public function getName(){
		 return $this->name;
	}

	/*set accessors */

	/**
	* @param string $idname
	* @return void
	*/
	public function setIdname($idname){
		$this->idname=$idname;
	}


	/**
	* @param integer $name
	* @return void
	*/
	public function setName($name){
		$this->name=$name;
	}

}

?>
