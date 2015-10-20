<?php
//require_once $GLOBALS['dr']."classes/usermaster.php";

class help {

	public function __construct() {
		$this->html = "";
	}	
	
	public function HTML() {
		
		$this->html = "<iframe src='wiki/' width='100%' height='700'></iframe>";
		
		return $this->html;
	}
	public function Process() {
		$c = "";
		
		$um = new UserMaster;
		
	}
}
?>