<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

require_once $GLOBALS['dr']."classes/userroles.php";

class Signup {

	public function __construct() {
		$this->html = "";
		$this->debug = true;
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
	public function Process() {
		$this->debug("Processing now...");
		$c = "";
		require_once $GLOBALS['dr']."classes/usermaster.php";
		$um = new UserMaster;
		if ($this->debug) {
			$um->SetVar("debug",true);
		}
		$um->SetVar("fullname",$_POST['fullname']);
		$um->SetVar("password",$_POST['password']);
		$um->SetVar("userlogin",$_POST['emailaddress']);		
		$this->debug("Calling Add");
		$result = $um->Add();
		$this->debug("Adding complete");
		if (!$result) {
			$this->debug("Found errors adding the user to usermaster object");
			$this->Errors($um->ShowErrors());
			return false;
		}
		else {		
			$this->userid = $um->GetVar("userid");
			$this->debug("Add user to role");
			// ADD USER TO ROLE FOR EVENT
			$userrole = new UserRoles;
			if ($this->debug) {
				$userrole->SetVar("debug",true);				
			}
			$userrole->SetVar("userid",$this->userid);			
			$userrole->SetVar("roleid",2);
			$result2 = $userrole->Add();
			$this->debug("Add user to role for event - SUCCESS");
			if (!$result2) {
				$this->debug("User Role Added Failed");
				$this->errors("Failed to add user role");
				//$GLOBALS['errors']->SetAlert($userrole->ShowErrors());				
				return False;
			}
			$this->Errors(MessageCatalogue(4));
			return true;
		}
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