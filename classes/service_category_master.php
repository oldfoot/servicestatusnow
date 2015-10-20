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
		$this->$v = CleanVar(trim($val));
	}
	
	public function Add() {
	
		$this->debug("Adding now");		
		if (!ISSET($this->apicode) || !ISSET($this->categoryname) || !ISSET($this->orgid)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}
		if (strlen($this->categoryname) < 1) {
			$this->Errors("Category Name too short");
			return false;
		}
		// EXISTS
		$sql = "call sp_service_category_master_exists('".$this->apicode."','".$this->categoryname."','".$this->orgid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
				
		if ($result) {
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				if (IS_NUMERIC($row['CategoryID'])) {
					$this->Errors("Category Name Exists. You can't have two the same");
					return false;
				}				
			}
		}
		//ADD
		$sql = "call sp_service_category_master_add('".$this->apicode."','".$this->categoryname."','".$this->orgid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);		
		if ($result && $GLOBALS['db']->NumRows($result) > 0) {
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				if (IS_NUMERIC($row['CategoryID'])) {
					$this->debug("Added Service Category");
					$this->Errors("Service Category Added Successfully");
					$this->debug("Category ID: ".$row['CategoryID']);
					$this->categoryid = $row['CategoryID'];
					return true;
				}
				else {
					$this->Errors("Service category add failed: ".$row['CategoryID']);
				}
			}
		}
		$this->Errors("Service category add failed - ");
		$this->Debug("Failed to add service category as no SQL probably failed");
		return false;
	}
	public function Edit() {
	
		$this->debug("Editing now");		
		if (!ISSET($this->apicode) || !ISSET($this->categoryid) || !ISSET($this->categoryname)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on edit");
			return false;
		}
		if (strlen($this->categoryname) < 1) {			
			return $this->Delete();
		}
		
		//ADD
		$sql = "call sp_service_category_master_edit('".$this->apicode."','".$this->categoryid."','".$this->categoryname."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);		
		if ($result && $GLOBALS['db']->NumRows($result) > 0) {
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				if ($row['UpdateResult'] == "Success") {
					$this->debug("Editing Service Category");
					$this->Errors("Service Category Edited Successfully");
					$this->debug("Result: ".$row['UpdateResult']);					
					return true;
				}
				else {
					$this->Errors("Service category edit failed: ".$row['UpdateResult']);
				}
			}
		}
		$this->Errors("Service category edit failed ");
		$this->Debug("Failed to edit service category as no SQL probably failed");
		return false;
	}
	public function Delete() {
	
		$this->debug("Deleting now");		
		if (!ISSET($this->apicode) || !ISSET($this->categoryid)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}
				
		//ADD
		$sql = "call sp_service_category_master_delete('".$this->apicode."','".$this->categoryid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);		
		if ($result && $GLOBALS['db']->NumRows($result) > 0) {
			while ($row=$GLOBALS['db']->FetchArray($result)) {
				if ($row['UpdateResult'] == "Success") {
					$this->debug("Deleting Service Category");
					$this->Errors("Service Category Deleted Successfully");
					$this->debug("Result: ".$row['UpdateResult']);
					return true;
				}
				else {
					$this->Errors("Service category delete failed: ".$row['UpdateResult']);
				}
			}
		}
		$this->Errors("Service category delete failed ");
		$this->Debug("Failed to delete service category as no SQL probably failed");
		return false;
	}	
	public function Browse() {
		// BUGGY 
		return false;
		$this->debug("Browsing now");		
		if (!ISSET($this->apicode) || !ISSET($this->orgid)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}	
		
		//ADD
		$sql = "call sp_service_category_browse('".$this->apicode."','".$this->orgid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		$arr = array(); // store the result set
		if ($result && $GLOBALS['db']->NumRows($result) > 0) {
			$this->debug("Got more than one row");			
			while($row = $GLOBALS['db']->FetchArray($result)) {
				$arr[$row["CategoryID"]] = $row["CategoryName"];
			}			
		}
		return $arr;
		$this->Errors("Browsing failed");
		$this->Debug("Failed to browse");
		return false;
	}

	public function GetCategoryIDFromName() {		
		$this->debug("Init function now");		
		if (!ISSET($this->apicode) || !ISSET($this->categoryname) || !ISSET($this->orgid)) {
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters getting category name");
			return false;
		}	
		
		//ADD
		$sql = "call sp_service_category_id_from_name('".$this->apicode."','".$this->categoryname."','".$this->orgid."')";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		
		if ($result && $GLOBALS['db']->NumRows($result) > 0) {
			$this->debug("Got more than one row");			
			while($row = $GLOBALS['db']->FetchArray($result)) {
				return $row["CategoryID"];
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