<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class getFormatsOutput {
	/** 
	* @var formatRecord[]
	*/
	public $formats;

	/**
	* default constructor for class getFormatsOutput
	* @param formatRecord[] $formats
	* @return getFormatsOutput
	*/
	 public function getFormatsOutput($formats=array()){
		 $this->formats=$formats   ;
	}
	/* get accessors */

	/**
	* @return formatRecord[]
	*/
	public function getFormats(){
		 return $this->formats;
	}

	/*set accessors */

	/**
	* @param formatRecord[] $formats
	* @return void
	*/
	public function setFormats($formats){
		$this->formats=$formats;
	}

}

?>
