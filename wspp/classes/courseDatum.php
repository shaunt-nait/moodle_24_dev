<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class courseDatum {
	/** 
	* @var string
	*/
	public $action;
	/** 
	* @var int
	*/
	public $id;
	/** 
	* @var int
	*/
	public $category;
	/** 
	* @var int
	*/
	public $sortorder;
	/** 
	* @var string
	*/
	public $fullname;
	/** 
	* @var string
	*/
	public $shortname;
	/** 
	* @var string
	*/
	public $idnumber;
	/** 
	* @var string
	*/
	public $summary;
	/** 
	* @var string
	*/
	public $format;
	/** 
	* @var int
	*/
	public $showgrades;
	/** 
	* @var int
	*/
	public $newsitems;
	/** 
	* @var int
	*/
	public $numsections;
	/** 
	* @var int
	*/
	public $marker;
	/** 
	* @var int
	*/
	public $maxbytes;
	/** 
	* @var int
	*/
	public $visible;
	/** 
	* @var int
	*/
	public $hiddensections;
	/** 
	* @var int
	*/
	public $groupmode;
	/** 
	* @var int
	*/
	public $groupmodeforce;
	/** 
	* @var string
	*/
	public $lang;
	/** 
	* @var string
	*/
	public $theme;
	/** 
	* @var int
	*/
	public $timecreated;
	/** 
	* @var int
	*/
	public $timemodified;

	/**
	* default constructor for class courseDatum
	* @param string $action
	* @param int $id
	* @param int $category
	* @param int $sortorder
	* @param string $fullname
	* @param string $shortname
	* @param string $idnumber
	* @param string $summary
	* @param string $format
	* @param int $showgrades
	* @param int $newsitems
	* @param int $numsections
	* @param int $marker
	* @param int $maxbytes
	* @param int $visible
	* @param int $hiddensections
	* @param int $groupmode
	* @param int $groupmodeforce
	* @param string $lang
	* @param string $theme
	* @param int $timecreated
	* @param int $timemodified
	* @return courseDatum
	*/
	 public function courseDatum($action='',$id=0,$category=0,$sortorder=0,$fullname='',$shortname='',$idnumber='',$summary='',$format='',$showgrades=0,$newsitems=0,$numsections=0,$marker=0,$maxbytes=0,$visible=0,$hiddensections=0,$groupmode=0,$groupmodeforce=0,$lang='',$theme='',$timecreated=0,$timemodified=0){
		 $this->action=$action   ;
		 $this->id=$id   ;
		 $this->category=$category   ;
		 $this->sortorder=$sortorder   ;
		 $this->fullname=$fullname   ;
		 $this->shortname=$shortname   ;
		 $this->idnumber=$idnumber   ;
		 $this->summary=$summary   ;
		 $this->format=$format   ;
		 $this->showgrades=$showgrades   ;
		 $this->newsitems=$newsitems   ;
		 $this->numsections=$numsections   ;
		 $this->marker=$marker   ;
		 $this->maxbytes=$maxbytes   ;
		 $this->visible=$visible   ;
		 $this->hiddensections=$hiddensections   ;
		 $this->groupmode=$groupmode   ;
		 $this->groupmodeforce=$groupmodeforce   ;
		 $this->lang=$lang   ;
		 $this->theme=$theme   ;
		 $this->timecreated=$timecreated   ;
		 $this->timemodified=$timemodified   ;
	}
	/* get accessors */

	/**
	* @return string
	*/
	public function getAction(){
		 return $this->action;
	}


	/**
	* @return int
	*/
	public function getId(){
		 return $this->id;
	}


	/**
	* @return int
	*/
	public function getCategory(){
		 return $this->category;
	}


	/**
	* @return int
	*/
	public function getSortorder(){
		 return $this->sortorder;
	}


	/**
	* @return string
	*/
	public function getFullname(){
		 return $this->fullname;
	}


	/**
	* @return string
	*/
	public function getShortname(){
		 return $this->shortname;
	}


	/**
	* @return string
	*/
	public function getIdnumber(){
		 return $this->idnumber;
	}


	/**
	* @return string
	*/
	public function getSummary(){
		 return $this->summary;
	}


	/**
	* @return string
	*/
	public function getFormat(){
		 return $this->format;
	}


	/**
	* @return int
	*/
	public function getShowgrades(){
		 return $this->showgrades;
	}


	/**
	* @return int
	*/
	public function getNewsitems(){
		 return $this->newsitems;
	}


	/**
	* @return int
	*/
	public function getNumsections(){
		 return $this->numsections;
	}


	/**
	* @return int
	*/
	public function getMarker(){
		 return $this->marker;
	}


	/**
	* @return int
	*/
	public function getMaxbytes(){
		 return $this->maxbytes;
	}


	/**
	* @return int
	*/
	public function getVisible(){
		 return $this->visible;
	}


	/**
	* @return int
	*/
	public function getHiddensections(){
		 return $this->hiddensections;
	}


	/**
	* @return int
	*/
	public function getGroupmode(){
		 return $this->groupmode;
	}


	/**
	* @return int
	*/
	public function getGroupmodeforce(){
		 return $this->groupmodeforce;
	}


	/**
	* @return string
	*/
	public function getLang(){
		 return $this->lang;
	}


	/**
	* @return string
	*/
	public function getTheme(){
		 return $this->theme;
	}


	/**
	* @return int
	*/
	public function getTimecreated(){
		 return $this->timecreated;
	}


	/**
	* @return int
	*/
	public function getTimemodified(){
		 return $this->timemodified;
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
	* @param int $id
	* @return void
	*/
	public function setId($id){
		$this->id=$id;
	}


	/**
	* @param int $category
	* @return void
	*/
	public function setCategory($category){
		$this->category=$category;
	}


	/**
	* @param int $sortorder
	* @return void
	*/
	public function setSortorder($sortorder){
		$this->sortorder=$sortorder;
	}


	/**
	* @param string $fullname
	* @return void
	*/
	public function setFullname($fullname){
		$this->fullname=$fullname;
	}


	/**
	* @param string $shortname
	* @return void
	*/
	public function setShortname($shortname){
		$this->shortname=$shortname;
	}


	/**
	* @param string $idnumber
	* @return void
	*/
	public function setIdnumber($idnumber){
		$this->idnumber=$idnumber;
	}


	/**
	* @param string $summary
	* @return void
	*/
	public function setSummary($summary){
		$this->summary=$summary;
	}


	/**
	* @param string $format
	* @return void
	*/
	public function setFormat($format){
		$this->format=$format;
	}


	/**
	* @param int $showgrades
	* @return void
	*/
	public function setShowgrades($showgrades){
		$this->showgrades=$showgrades;
	}


	/**
	* @param int $newsitems
	* @return void
	*/
	public function setNewsitems($newsitems){
		$this->newsitems=$newsitems;
	}


	/**
	* @param int $numsections
	* @return void
	*/
	public function setNumsections($numsections){
		$this->numsections=$numsections;
	}


	/**
	* @param int $marker
	* @return void
	*/
	public function setMarker($marker){
		$this->marker=$marker;
	}


	/**
	* @param int $maxbytes
	* @return void
	*/
	public function setMaxbytes($maxbytes){
		$this->maxbytes=$maxbytes;
	}


	/**
	* @param int $visible
	* @return void
	*/
	public function setVisible($visible){
		$this->visible=$visible;
	}


	/**
	* @param int $hiddensections
	* @return void
	*/
	public function setHiddensections($hiddensections){
		$this->hiddensections=$hiddensections;
	}


	/**
	* @param int $groupmode
	* @return void
	*/
	public function setGroupmode($groupmode){
		$this->groupmode=$groupmode;
	}


	/**
	* @param int $groupmodeforce
	* @return void
	*/
	public function setGroupmodeforce($groupmodeforce){
		$this->groupmodeforce=$groupmodeforce;
	}


	/**
	* @param string $lang
	* @return void
	*/
	public function setLang($lang){
		$this->lang=$lang;
	}


	/**
	* @param string $theme
	* @return void
	*/
	public function setTheme($theme){
		$this->theme=$theme;
	}


	/**
	* @param int $timecreated
	* @return void
	*/
	public function setTimecreated($timecreated){
		$this->timecreated=$timecreated;
	}


	/**
	* @param int $timemodified
	* @return void
	*/
	public function setTimemodified($timemodified){
		$this->timemodified=$timemodified;
	}

}

?>
