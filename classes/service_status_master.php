<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class ServiceStatusMaster {

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
		//echo "API code: ".$this->apicode ."<br />";
		//echo "service code1: ".$this->servicecode ."<br />";
		if (!ISSET($this->apicode) || !ISSET($this->serviceid) || !ISSET($this->servicecode) || !ISSET($this->servicedesc)) {
			
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}
								
		$sql = "call sp_service_status_master_add('".$this->apicode."','".$this->serviceid."','".$this->servicecode."','".$this->servicedesc."')";
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if ($result && $GLOBALS['db']->AffectedRows($result) > 0) {			
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				if (IS_NUMERIC($row['StatusID'])) {
					$this->debug("Added Status Service with numeric value");
					$this->Errors("Service Status Added Successfully");
					$this->debug("Service Status ID: ".$row['StatusID']);
					$this->statusid = $row['StatusID'];
					return true;			
				}
				else {
					$this->debug("Added Status Service without numeric value - something happened in the storedprod. Check the StatusID");
					$this->Errors("Service add failed: ".$row['StatusID']);
					return false;
				}
			}			
		}
		$this->Errors("Service add failed");
		$this->Debug("Failed to add service as no SQL probably failed");
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