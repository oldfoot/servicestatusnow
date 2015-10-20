<?php
/** ensure this file is being included by a parent file */
//defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );
//require_once $GLOBALS['dr']."classes/email.php";

class ProblemStream {

	public $methods = array("add","delete"); 

	function __construct() {
		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;
		$this->params_add = array("description","configurationid","userid");
		$this->vartypes_add = array("description"=>"varchar","configurationid"=>"integer","userid"=>"integer");
		$this->params_add_details = array("problemid","message","datetimesent","userid","messagetype");
		$this->vartypes_add_details = array("problemid"=>"integer","message"=>"varchar","datetimesent"=>"datetime","userid"=>"integer","messagetype"=>"varchar");
		$this->errors = "";
		$this->debug  = false;
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

	public function SetParameters($problemid) {

		/* CHECKS */
		if (!IS_NUMERIC($problemid)) { $this->Errors("Invalid message id"); return False; }

		/* SET SOME COMMON VARIABLES */
		$this->problemid=$problemid;

		/* CALL THE INFORMATION METHOD */
		$this->Info();

		/* PARAMETER CHECK SUCCESSFUL */
		$this->parameter_check=True;

		return True;
	}

	private function Info() {
		$db=$GLOBALS['db'];
		$sql="CALL sp_problemstream_browse('".$this->problemid."')";
		$this->debug($sql);
		//echo $sql;
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
		$this->debug("Add Method");
		if (!$this->CheckVarsSet("add")) {
			$this->debug("Failed to provide correct params");
			return false;
		}
		
		if (!$this->CheckVars($this->vartypes_add)) {
			$this->debug("Invalid data types");
			$this->Errors("Invalid data");
			return false;
		}		
		
		$sp_params = "";
		foreach ($this->params_add as $p) {
		  $sp_params .= "'".Safe($this->$p)."',";
		}
		$sp_params = substr($sp_params,0,-1);
		$sql = "call sp_problemstream_add($sp_params)";
		$this->debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if (!$result) {
			$this->Errors(MessageCatalogue(1));
			return false;				
		}
		else {
				$this->Errors(MessageCatalogue(4));
				return true;		
		}
	}
	public function AddDetails() {
		$this->debug("Add Details Method");
		if (!$this->CheckVarsSet("add_details")) {
			$this->debug("Failed to provide correct params");
			return false;
		}
		
		if (!$this->CheckVars($this->vartypes_add_details)) {
			$this->debug("Invalid data types");
			$this->Errors("Invalid data");
			return false;
		}		
		
		$sp_params = "";
		foreach ($this->params_add_details as $p) {
		  $sp_params .= "'".Safe($this->$p)."',";
		}
		$sp_params = substr($sp_params,0,-1);
		$sql = "call sp_problemstream_details_add($sp_params)";
		$this->debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if (!$result) {
			$this->Errors(MessageCatalogue(1));
			return false;				
		}
		else {
				$this->Errors(MessageCatalogue(4));
				return true;		
		}
	}	
	public function Delete() {

		$db=$GLOBALS['db'];

		if (ISSET($this->itemid)) {
			$sql="CALL sp_problemstream_delete(".$this->problemid.")";
			$this->debug($sql);
			$result = $db->Query($sql);			
			if ($result) {
				$this->debug("Item Deleted");
				$this->Errors(MessageCatalogue(49));
				return true;
			}
			else {
				$this->debug("failed to delete: ".mysql_error());
				$this->Errors(MessageCatalogue(50));
				return false;
			}
		}
		else {
			$this->debug("values not set");
			$this->Errors(MessageCatalogue(51));
			return False;
		}
	}

	// CHECK VARS ALL SET FOR REQUIRED METHOD
	private function CheckVarsSet($method) {    
		if ($method == "add") {			
			foreach ($this->params_add as $param) {
				if (!ISSET($this->$param)) {
					$this->Errors("Parameter $param not set");
					return False;
				}
			}
		}
		if ($method == "edit") {
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
  private function CheckVars($vartypes) {
	$count = 0;
    foreach ($vartypes as $var=>$type) {	
      if ($type == "a-z" && !preg_match("/^[A-Z0-9._%+-@ ]*$/i",$this->$var)) {                
        $this->Errors($var." needs to contain alpha characters only");
		$this->debug($var." needs to be $type, you provided: ".$this->$var);
        return False;
      }      
      if ($type == "numeric" && !IS_NUMERIC($this->$var)) {
        $this->Errors($this->$var." needs to be numeric");
		$this->debug($var." needs to be $type, you provided: ".$this->$var);
        return False;        
      }	
		if ($type == "datetime" && !PREG_MATCH("/\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d/",$this->$var)) {
        $this->Errors($this->$var." needs to be date and time");
		$this->debug($var." needs to be $type, you provided: ".$this->$var);
        return False;        
      }		  
	  // for any
	  return true;
	  $count++;
    }
    return True;
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