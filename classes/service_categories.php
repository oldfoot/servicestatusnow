<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class ServiceCategoryMaster {

	function __construct() {
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
	
	public function Add() {
	
		$this->debug("Adding now");		
		if (!ISSET($this->apicode) || !ISSET($this->categoryname) || !ISSET($this->orgid)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}
								
		$sql = "call sp_service_category_master_add('".$this->apicode."','".$this->categoryname."','".$this->orgid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if ($result && $GLOBALS['db']->AffectedRows($result) > 0) {
			$this->debug("Added Service Category");
			$this->Errors("Service Category Added Successfully");
			return true;			
		}
		$this->Errors("Service category add failed");
		$this->Debug("Failed to add service category as no SQL probably failed");
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