<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class ServiceCodeMaster {

	function __construct() {
		$this->defaultcode = "y";
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
		if (!ISSET($this->apicode) || !ISSET($this->servicecodename) || !ISSET($this->servicecodedesc) || !ISSET($this->servicecodeicon) || !ISSET($this->orgid) || !ISSET($this->codemeaning)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}
		if (strlen($this->servicecodename) < 1) {
			$this->Errors("Name too short");
			return false;
		}
		// EXISTS
		$sql = "call sp_service_code_master_exists('".$this->apicode."','".$this->servicecodename."','".$this->orgid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
				
		if ($result) {
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				$this->Errors("Icon Exists. You can't have two the same");
				return false;				
			}
		}
		// SET DEFAULT CODE IF NEED BE
		$sql = "call sp_service_code_count('".$this->orgid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
				
		if ($result) {
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				if ($row['total'] > 0) {
					$this->defaultcode = "n";
				}				
			}
		}
		
		//ADD
		$sql = "call sp_service_code_master_add('".CleanVar($this->apicode)."','".CleanVar($this->servicecodename)."','".CleanVar($this->servicecodedesc)."','".CleanVar($this->servicecodeicon)."','".$this->orgid."','".$this->defaultcode."','".CleanVar($this->codemeaning)."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);		
		if ($result && $GLOBALS['db']->NumRows($result) > 0) {
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				if (IS_NUMERIC($row['ServiceCode'])) {
					$this->debug("Added Icon");
					$this->Errors("Icon Added Successfully");
					$this->debug("ServiceCode: ".$row['ServiceCode']);
					$this->servicecode = $row['ServiceCode'];
					return true;
				}
				else {
					$this->Errors("Icon add failed: ".$row['ServiceCode']);
				}
			}
		}
		$this->Errors("Service category add failed");
		$this->Debug("Failed to add icon as no SQL probably failed");
		return false;
	}
	
	public function GetServiceCodeFromName() {		
		$this->debug("Init function now");		
		if (!ISSET($this->apicode) || !ISSET($this->codename) || !ISSET($this->orgid)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters getting code name");
			return false;
		}	
		
		//ADD
		$sql = "call sp_service_code_from_name('".$this->apicode."','".$this->codename."','".$this->orgid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		
		if ($result && $GLOBALS['db']->NumRows($result) > 0) {
			$this->debug("Got more than one row");			
			while($row = $GLOBALS['db']->FetchArray($result)) {
				return $row["ServiceCode"];
			}			
		}		
		$this->Errors("Failed to find code");
		$this->Debug("Failed to find code");
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