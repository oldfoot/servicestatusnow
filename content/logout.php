<?php
class logout {

	public function __construct() {
		$this->html = "";
		$this->errors = "";
		$this->debug = false;
	}
	public function GetVar($v) {
		if (ISSET($this->$v)) {
			return $this->$v;
		}
		else {
			return "";
		}
	}	
	public function SetVar($v,$val) {
		$this->$v = trim($val);
	}	
	public function HTML() {		
			session_destroy();
			header("Location: index.php?content=home");
	}
	
	private function Errors($err) {
		//echo $err."<br />";
		$this->errors .= $err."<br />\n";    
	}
	public function ShowErrors(){ 
		return $this->errors;
	}
	private function debug($msg) {
		if ($this->debug) {
			file_put_contents("login.php.log",$msg."\n",FILE_APPEND);
			echo $msg."<br />\n";
		}
	}
}
?>