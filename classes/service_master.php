<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class ServiceMaster {

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
		$this->$v = CleanVar(trim($val));
	}
	
	public function Add() {
	
		$this->debug("Adding now");		
		if (!ISSET($this->apicode) || !ISSET($this->categoryid) || !ISSET($this->parentid) || !ISSET($this->servicename) || !ISSET($this->organisationid)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}
		
		// EXISTS
		$sql = "call sp_service_master_exists('".$this->apicode."','".$this->categoryid."','".$this->parentid."','".$this->servicename."','".$this->organisationid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
				
		if ($result) {
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				if (IS_NUMERIC($row['ServiceID']) > 0) {
					$this->Errors("Service Name Exists. You can't have two the same");
					return false;
				}
			}
		}
		$parentid = "0";
		if (IS_NUMERIC($this->parentid)) { $parentid = $this->parentid; }
		$sql = "call sp_service_master_add('".$this->apicode."','".$this->categoryid."',".$parentid.",'".$this->servicename."','".$this->organisationid."')";
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if ($result && $GLOBALS['db']->AffectedRows($result) > 0) {
			$this->debug("Added Service");
			$this->Errors("Service Added Successfully");
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				$this->debug("Service ID: ".$row['ServiceID']);
				$this->serviceid = $row['ServiceID'];
			}
			return true;			
		}
		$this->Errors("Service add failed");
		$this->Debug("Failed to add service as no SQL probably failed");
		return false;
	}
	public function Edit() {
	
		$this->debug("Editing now");		
		if (!ISSET($this->apicode) || !ISSET($this->serviceid) || !ISSET($this->servicename)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on edit");
			return false;
		}
		
		if (strlen($this->servicename) < 1) {			
			return $this->Delete();
		}
		
		$sql = "call sp_service_master_edit('".$this->apicode."','".$this->serviceid."','".$this->servicename."')";
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if ($result && $GLOBALS['db']->AffectedRows($result) > 0) {
			$this->debug("Edited Service");
			//$this->Errors("Service Edited Successfully");
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				$this->debug("Result: ".$row['UpdateResult']);
				$this->Errors($row['UpdateResult']);
				return $row['UpdateResult'];
			}			
		}
		$this->Errors("Service edit failed");
		$this->Debug("Failed to edit service as no SQL probably failed");
		return false;
	}
	public function Delete() {
	
		$this->debug("Deleting now");		
		if (!ISSET($this->apicode) || !ISSET($this->serviceid)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on del");
			return false;
		}		
		
		$sql = "call sp_service_master_delete('".$this->apicode."','".$this->serviceid."')";
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if ($result && $GLOBALS['db']->AffectedRows($result) > 0) {
			$this->debug("Deleted Service");
			//$this->Errors("Service Edited Successfully");
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				$this->debug("Result: ".$row['UpdateResult']);
				$this->Errors($row['UpdateResult']);
				return $row['UpdateResult'];
			}			
		}
		$this->Errors("Service delete failed");
		$this->Debug("Failed to del service as no SQL probably failed");
		return false;
	}
	
	public function GetServiceIDFromName() {		
		$this->debug("Init function now");		
		if (!ISSET($this->apicode) || !ISSET($this->servicename) || !ISSET($this->orgid)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters getting service name");
			return false;
		}	
		
		//ADD
		$sql = "call sp_service_master_id_from_name('".$this->apicode."','".$this->servicename."','".$this->orgid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		
		if ($result && $GLOBALS['db']->NumRows($result) > 0) {
			$this->debug("Got more than one row");			
			while($row = $GLOBALS['db']->FetchArray($result)) {
				return $row["ServiceID"];
			}			
		}		
		$this->Errors("Failed to find category");
		$this->Debug("Failed to find category");
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