<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

//require_once $GLOBALS['dr']."classes/userroles.php";

class Signin {

	public function __construct() {
		$this->html = "";
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
	public function Process() {
		$c = "";		
		$sql = "call sp_core_userauth('".$this->emailaddress."','".$this->password."')";	
		$this->debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		// AUTH SUCCESSFUL
		if ($result) {
			$this->debug("SQL executed ok");
			// UPDATE LAST AUTH
			$sql1 = "call sp_core_usermaster_lastlogin('".$this->emailaddress."')";				
			$this->debug($sql1);
			$result1 = $GLOBALS['db']->Query($sql1);
			
			while ($row = $GLOBALS['db']->FetchArray($result)) {
				$this->debug("Found a user");
				if ($row['Activated'] == "y") {
					$this->debug("User Activated");
					$_SESSION['userid'] = $row['UserID'];
					//$GLOBALS['errors']->SetAlert($_SESSION['userid']);
					$this->Errors(MessageCatalogue(8));
					return True;
					
				}
				else {
					$this->debug("Not activated");
					$error = MessageCatalogue(10);
					$this->Errors($error);
					return false;					
				}
			}
		}
		$this->debug("SQL Error? Returning False;");
		$error = MessageCatalogue(9);
		$this->Errors($error);
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