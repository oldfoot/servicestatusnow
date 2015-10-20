<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

//require_once $GLOBALS['dr']."classes/userroles.php";
require_once $GLOBALS['dr']."classes/mq.php";

class InviteFriends {

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
		// SEND REGISTER EMAIL
		$friends = array();
		if (preg_match("/,/",$this->emailaddress)) {
			$friends = preg_split("/[,]+/",$this->emailaddress);
			//$this->debug("Split friends: $friends");
		}
		else {
			$friends[] = $this->emailaddress;
		}
		foreach ($friends as $friend) {
			$friend = trim($friend);
			$this->debug("In the loop for friend $friend");
			if (preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$friend)) {
				$this->debug("Email address valid: $friend");
				$sql = "call sp_ozlotto_invitefriend('".$_SESSION['userid']."','".$friend."')";	
				$this->debug($sql);
				$result1 = $GLOBALS['db']->Query($sql);		
				if ($result1) {					
					while ($row = $GLOBALS['db']->FetchArray($result1)) {					
						if ($row['result'] == "1") {
							
							// SEND REGISTER EMAIL
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
								$mq->SetVar('value',$GLOBALS['register_email_subject']);
								$mq->InsertDetails();					
								// BODY
								$thisuser = $GLOBALS['user']->GetVar("FullName");
								$body = str_replace("%friendname%",$thisuser,$GLOBALS['invite_email_body']);
								$mq->SetVar('name','message');
								$mq->SetVar('value',$body);
								$mq->InsertDetails();
							}
							/*
							$thisuser = $GLOBALS['user']->GetVar("FullName");
				
							$email = new email;
							$email->SetVar("to",$_POST['emailaddress']);
							
							$email->SetVar("subject",$GLOBALS['invite_email_subject']);
							$body = str_replace("%friendname%",$thisuser,$GLOBALS['invite_email_body']);
							
							$email->SetVar("body",$body);
							
							$email->SendEmail();
							*/
							
							$msg = MessageCatalogue(68);							
							$this->debug($msg);
							$this->Errors($msg);
						}
						else {
							$msg = MessageCatalogue(69);							
							$this->debug($msg);
							$this->Errors($msg);
						}
					}
				}
				else {					
					$msg = MessageCatalogue(69);
					$this->debug($msg);
					$this->Errors($msg);
				}
			}
			else {
				$this->debug("Email address NOT valid: $friend");
				$msg = MessageCatalogue(69);
				$this->Errors($msg);
			}
		}
		return true;
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