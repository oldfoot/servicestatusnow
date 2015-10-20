<?php
class xml {
	function __construct() {
		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;		
		$this->debug = false;
		$this->errors = "";
		$this->content="<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";		
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
		$v = strtolower($v);
		$this->$v = $val;
	}
	public function SetHeader() {
		header('Content-type: application/xml');
	}
	public function OpenXML($name) {
		$this->content.="<$name>\n";
	}
	public function AddRow($element,$val) {
		$this->content.="\t<$element>$val</$element>\n";
	}
	public function CloseXML($name) {
		$this->content.="</$name>\n";
	}
	function Errors($err) {
		$this->errors.=$err."\n";
	}

	function ShowErrors() {
		return $this->errors;
	}
	
	private function debug($msg) {
		if ($this->debug) {
			echo $msg."<br />\n";
			file_put_contents("C:/xampp/htdocs/runningsheet/ajax/jqgrid_edit_orgusers.log",$msg,FILE_APPEND);
		}
	}
	
}
?>