<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class editedRecord {
	/** 
	* @var int
	*/
	public $id;
	/** 
	* @var string
	*/
	public $error;
	/** 
	* @var boolean
	*/
	public $status;

	/**
	* default constructor for class editedRecord
	* @param int $id
	* @param string $error
	* @param boolean $status
	* @return editedRecord
	*/
	 public function editedRecord($id=0,$error='',$status=false){
		 $this->id=$id   ;
		 $this->error=$error   ;
		 $this->status=$status   ;
	}
	/* get accessors */

	/**
	* @return int
	*/
	public function getId(){
		 return $this->id;
	}


	/**
	* @return string
	*/
	public function getError(){
		 return $this->error;
	}


	/**
	* @return boolean
	*/
	public function getStatus(){
		 return $this->status;
	}

	/*set accessors */

	/**
	* @param int $id
	* @return void
	*/
	public function setId($id){
		$this->id=$id;
	}


	/**
	* @param string $error
	* @return void
	*/
	public function setError($error){
		$this->error=$error;
	}


	/**
	* @param boolean $status
	* @return void
	*/
	public function setStatus($status){
		$this->status=$status;
	}

}

?>
