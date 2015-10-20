<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class Organisation {

	function __construct() {
		$this->errors = "";
		$this->debug = false;
		$this->returncode=false;
	}
	public function GetVar($v) {
		if (ISSET($this->$v)) {
			return $this->$v;
		}
		else {
			return "No Data";
		}
	}	
	public function SetVar($v,$val) {
		$this->$v = trim($val);
	}
	
	public function Add() {
	
		$this->debug("Adding now");		
		if (!ISSET($this->apicode) || !ISSET($this->orgname)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}
								
		$sql = "call sp_core_organisation_master_add('".$this->apicode."','".$this->orgname."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if ($result && $GLOBALS['db']->AffectedRows($result) > 0) {
			$this->debug("Added Org");
			$this->Errors("Organisation Added Successfully");
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				$this->debug("Org ID: ".$row['OrganisationID']);
				$this->organisationid = $row['OrganisationID'];
				$this->returncode = $row['ReturnCode'];
			}
			return true;			
		}
		$this->Errors("Org add failed");
		$this->Debug("Failed to add Org as no SQL probably failed");		
		return false;
	}
	public function AddUser() {
		$this->debug("Adding user to org now");		
		if (!ISSET($this->apicode) || !ISSET($this->organisationid) || !ISSET($this->userid)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}
								
		$sql = "call sp_core_organisation_user_add('".$this->apicode."','".$this->organisationid."','".$this->userid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if ($result && $GLOBALS['db']->AffectedRows($result) > 0) {
			$this->debug("Added user to org");
			$this->Errors("User added to organisation successfully");			
			return true;			
		}
		$this->Errors("User add to org failed");
		$this->Debug("Failed to add user to org as no SQL probably failed");
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