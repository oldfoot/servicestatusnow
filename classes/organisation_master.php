<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class OrganisationMaster {

	function __construct() {
		/* SET CHECKING TO FALSE */
		$this->accounttype="Free";
		$this->parameter_check=False;		
		$this->debug = false;
		$this->errors = "";
		$this->orgroleid = 2; // DEFAULT USER
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

	public function SetParameters($organisationid,$userid) {

		/* CHECKS */
		if (!IS_NUMERIC($organisationid)) { $this->Errors("Invalid organisationid"); return False; }

		/* SET SOME COMMON VARIABLES */
		$this->organisationid=$organisationid;
		$this->userid=$userid;

		/* CALL THE INFORMATION METHOD */
		$this->Info();

		/* PARAMETER CHECK SUCCESSFUL */
		$this->parameter_check=True;

		return True;
	}

	private function Info() {
		$db=$GLOBALS['db'];
		$sql = "CALL sp_core_organisation_browse_id(".$this->organisationid.",'".$this->userid."');";
		$this->debug($sql);
		$result = $db->Query($sql);
		if ($db->NumRows($result) > 0) {
			while($row = $db->FetchArray($result)) {
				/* HERE WE CALL THE FIELDS AND SET THEM INTO DYNAMIC VARIABLES */
				$arr_cols=$db->GetColumns($result);
				for ($i=1;$i<count($arr_cols);$i++) {
					$col_name=$arr_cols[$i];
					$this->$col_name=$row[$col_name];
				}
			}
		}
		else {
			return False;
		}
	}
	public function OrganisationExists() {
		if (ISSET($this->organisation)) {
			$sql = "call sp_core_organisation_exists('".$this->organisation."')";
			$this->debug($sql);
			$result = $GLOBALS['db']->Query($sql);
			if ($result && $GLOBALS['db']->NumRows($result) > 0) {
				while ($row = $GLOBALS['db']->FetchArray($result)) {
					return $row['OrganisationID'];
				}
			}
			else {
				return False;
			}
		}
		else {
			$this->Errors("No org set");
			return false;
		}
	}
	public function AddDefault() {
		
		if (ISSET($this->organisation) && ISSET($this->userid) && ISSET($this->api_auth_code)) {
			//$pieces = explode("@",$this->emailaddress);
			//$domain = $pieces[1];
			//$domain_pieces = explode(".",$domain);
			//$organisation = $domain_pieces[0];
			
			$sql = "call sp_core_organisation_exists('".$this->organisation."')";
			$this->debug($sql);
			$result = $GLOBALS['db']->Query($sql);
			// EXISTS
			if ($result && $GLOBALS['db']->NumRows($result) > 0) {				
				while ($row = $GLOBALS['db']->FetchArray($result)) {
					//$sql = "call sp_core_organisation_user_add('".$row['OrganisationID']."',".$this->userid.",'n',".$this->orgroleid.")";
					$sql = "call sp_core_organisation_def_user_add('".$this->api_auth_code."','".$row['OrganisationID']."',".$this->userid.")";
				}
			}
			else {
				$sql1 = "call sp_core_organisation_master_add('".$this->api_auth_code."','".$this->organisation."')";
				$this->debug($sql1);
				$result1 = $GLOBALS['db']->Query($sql1);
				while ($row1 = $GLOBALS['db']->FetchArray($result1)) {
					$organisation_id = $row1['OrganisationID'];
				}
				$sql = "call sp_core_organisation_def_user_add('".$this->api_auth_code."','".$organisation_id."',".$this->userid.")";
			}
			$this->debug($sql);
			$result = $GLOBALS['db']->Query($sql);			
			if ($result && $GLOBALS['db']->AffectedRows($result) > 0) {	
				// SUCCESS				
				$this->Errors("Success");
				return True;
			}					
		}
		$this->Errors(MessageCatalogue(16));
		return false;
	}
	
	public function Add() {
		
		if (ISSET($this->organisationname) && ISSET($this->userid) && ISSET($this->api_auth_code)) {
			//$pieces = explode("@",$this->emailaddress);
			//$domain = $pieces[1];
			//$domain_pieces = explode(".",$domain);
			//$organisation = $domain_pieces[0];
			
			$sql = "call sp_core_organisation_exists('".$this->organisationname."')";
			$this->debug($sql);
			$result = $GLOBALS['db']->Query($sql);
			// EXISTS
			if ($result && $GLOBALS['db']->NumRows($result) > 0) {				
				$this->Errors(MessageCatalogue(76));
				return false;
			}
			else {
				// REMOVE THE USER FROM THE CORE ORG				
				$sql = "call sp_core_organisation_def_del(".$this->userid.")";
				$result = $GLOBALS['db']->Query($sql);			
				
				// ADD USER
				$sql1 = "call sp_core_organisation_master_add('".$this->api_auth_code."','".$this->organisationname."')";
				$this->debug($sql1);
				$result1 = $GLOBALS['db']->Query($sql1);
				while ($row1 = $GLOBALS['db']->FetchArray($result1)) {
					$this->organisation_id = $row1['OrganisationID'];
				}				
			}
			
			
			// SUCCESS				
			$this->Errors(MessageCatalogue(77));
			return True;								
		}
		$this->Errors(MessageCatalogue(75));
		return false;
	}
	
	public function GetOrgIDFromName() {
		if (!ISSET($this->organisation)) {
			$this->errors("Invalid org");
			return false;
		}
		$sql = "call sp_core_get_organisationid_from_name('".$this->organisation."')";
		$this->debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		while ($row = $GLOBALS['db']->FetchArray($result)) {
			$this->organisationid = $row['OrganisationID'];
			return $this->organisationid;
		}
	}
	
	public function UserAdd() {
		
		if (
			ISSET($this->userid) && IS_NUMERIC($this->organisationid)
			&& IS_NUMERIC($this->userid)
			&& ISSET($this->approved)
			&& ISSET($this->api_auth_code)
			&& ISSET($this->orgroleid) && IS_NUMERIC($this->orgroleid)
			) {
			//$pieces = explode("@",$this->emailaddress);
			//$domain = $pieces[1];
			//$domain_pieces = explode(".",$domain);
			//$organisation = $domain_pieces[0];
			
			$sql = "call sp_core_organisation_user_add('".$this->api_auth_code."','".$this->organisationid."','".$this->userid."','".$this->orgroleid."','".$this->approved."')";
			$this->debug($sql);
			$result = $GLOBALS['db']->Query($sql);

			// SUCCESS				
			$this->Errors("Success");
			return True;			
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