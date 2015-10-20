<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class StatusMaster {

	public $methods = array("add","edit","delete"); 

	function __construct() {
		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;
		$this->params_add = array("statusname","isnew","isnewdefault","ispendingapproval","isinprogress","iscompleted","isclosed","isdeleted");
		$this->params_edit = array("eventid","eventname","datetimestart","datetimeend","locked","userid");
		$this->vartypes_add = array("statusname"=>"a-z","isnew"=>"yn","isnewdefault"=>"yn","ispendingapproval"=>"yn","isinprogress"=>"yn","iscompleted"=>"yn","isclosed"=>"yn","isdeleted"=>"yn");
		$this->vartypes_edit = array("eventid"=>"numeric","eventname"=>"a-z","datetimestart"=>"datetime","datetimeend"=>"datetime","locked"=>"yn","userid"=>"numeric");
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

	public function SetParameters($statusid) {

		/* CHECKS */
		if (!IS_NUMERIC($statusid)) { $this->Errors("Invalid statusid"); return False; }
		
		/* SET SOME COMMON VARIABLES */
		$this->statusid=$statusid;

		/* CALL THE INFORMATION METHOD */
		$this->Info();

		/* PARAMETER CHECK SUCCESSFUL */
		$this->parameter_check=True;

		return True;
	}

	private function Info() {
		if (!ISSET($this->statusid)) { $this->Errors("Invalid Status ID"); return False; }
		if (!ISSET($this->userid)) { $this->Errors("Invalid User ID"); return False; }
		$db=$GLOBALS['db'];
		//echo "ok";
		$sql = "CALL sp_helpdesk_statusmaster_browse(".$this->statusid.",".$this->userid.");";					
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
	public function Add() {
		
		if (!$this->CheckVarsSet("add")) {
			$this->debug("Parameters not set");
			$this->Errors("Invalid Parameters on add");
			return false;
		}
		
		if (!$this->CheckVars($this->vartypes_add)) {
			$this->debug("Invalid Variable types");
			$this->Errors("Invalid Values");
			return false;
		}
		
		$sp_params = "";
		foreach ($this->params_add as $p) {
		  $sp_params .= "'".$this->$p."',";
		}		
		$sp_params = substr($sp_params,0,-1);
				
		$sql = "call sp_helpdesk_statusmaster_add(".$sp_params.")";				
		$this->debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if ($result) {			
			while ($row = $GLOBALS['db']->FetchArray($result)) {			
				$statusid = $row['StatusID'];
			}
			$this->debug("StatusID : $statusid");
			return True;
		}
		$this->Errors(MessageCatalogue(16));
		return False;
	}
	// CHECK VARS ALL SET FOR REQUIRED METHOD
	private function CheckVarsSet($method) {    
		if ($method == "add") {      
			//echo "ok";
			foreach ($this->params_add as $param) {
				if (!ISSET($this->$param)) {          
					$this->Errors("Parameter $param not set");
					return False;
				}
			}
		}
		elseif ($method == "edit") {      
			//echo "ok";
			foreach ($this->params_edit as $param) {
				if (!ISSET($this->$param)) {          
					$this->Errors("Parameter $param not set");
					return False;
				}
			}
		}
		return True;
	}
	 // CHECK VAR TYPES
	private function CheckVars($v) {
		$count = 0;
		foreach ($v as $var=>$type) {
		  if ($type == "a-z" && !preg_match("/^[\w\s]+$/",$this->$var)) {                
			$this->Errors($var." needs to contain alpha characters only");
			return False;
		  }      
		  if ($type == "numeric" && !IS_NUMERIC($this->$var)) {
			$this->Errors($this->$var." needs to be numeric");
			return False;        
		  }
		  if ($type == "email" && !preg_match("/^\w+@\w+\.\w+$/",$this->$var)) {
			$this->Errors($var." needs to be an email address");
			return False;        
		  }
		  if ($type == "datetime" && !preg_match("/^\d\d\d\d-\d\d-\d\d \d\d:\d\d/",$this->$var)) {
			$this->Errors($var." needs to be an ISO format date curr val is ".$this->$var);
			return False;        
		  }
		  if ($type == "yn") {
			if (!ISSET($this->$var) || $this->$var == "n") {
				$this->$var = "n";
			}
			else {
				$this->$var = "y";
			}
			//$this->Errors($var." needs to be yes or no, value is ".$this->$var);
			//return False;        
		  }
		  $count++;
		}
		return True;
	}
	
	private function Errors($err) {
		$this->errors.=$err."<br>";
	}

	public function ShowErrors() {
		return $this->errors;
	}
	
	private function debug($msg) {
		if ($this->debug) {
			echo $msg."<br />\n";
		}
	}
}
?>