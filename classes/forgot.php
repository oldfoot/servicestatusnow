<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

//require_once $GLOBALS['dr']."classes/userroles.php";
require_once $GLOBALS['dr']."classes/mq.php";

class Forgot {

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
	public function SendEmail() {
		// SEND REGISTER EMAIL
		$code = md5(microtime());
				
		$sql = "call sp_usermaster_pw_code('".$_POST['emailaddress']."','".$code."')";			
		$this->debug($sql);
		$result = $GLOBALS['db']->Query($sql);		
		if ($result) {			
			$mq = new mq;
			$mq->SetVar('type','email');
			//$mq->SetVar('debug',true);
			$result = $mq->InsertMaster();
			if ($result) {
				// FROM
				$mq->SetVar('name','from');
				$mq->SetVar('value',$GLOBALS['register_email_from']);
				$mq->InsertDetails();
				// TO
				$mq->SetVar('name','to');
				$mq->SetVar('value',$_POST['emailaddress']);
				$mq->InsertDetails();
				// SUBJECT
				$mq->SetVar('name','subject');
				$mq->SetVar('value',$GLOBALS['forgot_email_subject']);
				$mq->InsertDetails();					
				// BODY				
				$body = str_replace("%code%",$code,$GLOBALS['forgot_email_body']);
				$mq->SetVar('name','message');
				$mq->SetVar('value',$body);
				$mq->InsertDetails();
			}			
			$this->Errors(MessageCatalogue(11));			
		}
		else {
			$this->Errors(MessageCatalogue(14));
		}
	}
	
	public function Verify() {
		
		$sql = "call sp_core_usermaster_get_pwcode('".$this->code."')";			
		$this->debug($sql);
		$result = $GLOBALS['db']->Query($sql);		
		if ($result) {
			while ($row = $GLOBALS['db']->FetchArray($result)) {
				$_SESSION['userid'] = $row['UserID'];
				$this->Errors(MessageCatalogue(70));
				return true;
			}			
		}
		$this->Errors(MessageCatalogue(71));		
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