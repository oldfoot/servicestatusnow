<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class UserRoles {

	function __construct() {
		$this->errors = "";		
		$this->debug = false;
		
		$this->role_priv_array = array();
		//$this->GenUserRolePriv();		
		
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
		if (!ISSET($this->userid) || !IS_NUMERIC($this->userid) || !ISSET($this->roleid) || !IS_NUMERIC($this->roleid)) {    			
			$this->debug("Invalid data types or params not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}
								
		$sql = "call sp_core_userrole_add(".$this->userid.",".$this->roleid.")";				
		$this->Debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if ($result && $GLOBALS['db']->AffectedRows($result) > 0) {
			$this->debug("Added User To Role");
			$this->Errors("User add to role succeeded");
			return true;			
		}
		$this->Errors("User add to role failed");
		$this->Debug("Failed to add User To Role");
		return false;
	}
	private function GenUserRolePriv() {
		$sql = "call sp_userrole_priv(".$this->userid.")";		
		$arr = array();
		$this->debug($sql);		
		$result = $GLOBALS['db']->Query($sql);						
		if ($result) {			
			//$this->debug("ok");
			while ($row = $GLOBALS['db']->FetchArray($result)) {				
				$arr[] = $row['RolePriv'];
			}
		}		
		$this->role_priv_array = $arr;
	}
	public function CheckUserRolePriv($priv) {
		
		if (ISSET($priv)) {
			if (in_array($priv,$this->role_priv_array)) {
				$this->debug("Found priv for user");
				return true;
			}
			/*
			foreach ($this->role_priv_array as $key=>$val) {
				if ($priv == $val) {
					return true;
				}
				else {
					echo "$priv is not equal to $val <br />";
				}
			}
			*/
		}
		$this->debug("Priv \"$priv\" does not exist for user");		
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