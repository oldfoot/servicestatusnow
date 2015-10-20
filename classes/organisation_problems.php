<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class OrganisationProblems {

	function __construct() {
		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;		
		$this->debug = false;
		$this->errors = "";		
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
		$this->$v = $val;
	}
	
	public function Add() {
		
		if (ISSET($this->problemid) && IS_NUMERIC($this->problemid) && ISSET($this->organisationid) && IS_NUMERIC($this->organisationid)) {
			//$pieces = explode("@",$this->emailaddress);
			//$domain = $pieces[1];
			//$domain_pieces = explode(".",$domain);
			//$organisation = $domain_pieces[0];
			
			$sql = "call sp_problemstream_organisationproblems_add('".$this->problemid."','".$this->organisationid."')";
			$this->debug($sql);
			$result = $GLOBALS['db']->Query($sql);
			$this->Errors(MessageCatalogue(17));
			return true;
		}
		$this->Errors(MessageCatalogue(16));
		return false;
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
		}
	}
}
?>