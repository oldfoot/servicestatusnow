<?php
/** ensure this file is being included by a parent file */
//defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );
//require_once $GLOBALS['dr']."classes/email.php";

class ConfigurationItem {

	public $methods = array("add","edit","delete"); 

	function __construct() {
		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;
		$this->params_add = array("name","dependencyid");
		$this->vartypes_add = array("name"=>"varchar","dependencyid"=>"optional-numeric");
		$this->params_edit = array("configurationid","name","categoryid");
		$this->vartypes_edit = array("configurationid"=>"numeric","name"=>"a-z","categoryid"=>"numeric");
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

	public function SetParameters($itemid) {

		/* CHECKS */
		if (!IS_NUMERIC($itemid)) { $this->Errors("Invalid configuration id"); return False; }

		/* SET SOME COMMON VARIABLES */
		$this->itemid=$itemid;

		/* CALL THE INFORMATION METHOD */
		$this->Info();

		/* PARAMETER CHECK SUCCESSFUL */
		$this->parameter_check=True;

		return True;
	}

	private function Info() {
		$db=$GLOBALS['db'];
		$sql="CALL sp_cmdb_configurationitem_browse('".$this->itemid."')";
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
	$db=$GLOBALS['db'];
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
		  $sp_params .= "'".$this->$p."',";
		}
		$sp_params = substr($sp_params,0,-1);
		
		$sql = "call sp_cmdb_configurationitem_add($sp_params)";
		$this->debug($sql);
		$result = $GLOBALS['db']->Query($sql);
		if (!$result) {
			$this->Errors(MessageCatalogue(1));
			return false;				
		}
		else {			
			$this->configurationid = $db->LastInsertID();
			
			$this->Errors(MessageCatalogue(4));
			return true;				
		}

	}
	public function Edit() {
		$this->debug("Edit Method");
		if (!$this->CheckVarsSet("edit")) {
			$this->debug("Failed to provide correct params");
			return false;
		}
		
		if (!$this->CheckVars($this->vartypes_edit)) {
			$this->debug("Invalid data types");
			$this->Errors("Invalid data");
			return false;
		}		
		
		$sp_params = "";
		foreach ($this->params_edit as $p) {
		  $sp_params .= "'".$this->$p."',";
		}		
		$sp_params = substr($sp_params,0,-1);
		// DOES THS USER EXIST?
		
		$sql = "call sp_cmdb_configurationitem_edit($sp_params)";
		
		$this->debug($sql);
		
		$result = $GLOBALS['db']->Query($sql);
		
		if ($result) {					
			$this->Errors(MessageCatalogue(44));			
			return true;
		}		
		else {
			$this->Errors(MessageCatalogue(45));			
			return false;
		}			
		
	}	
	public function Exists() {
		if (ISSET($this->name)) {
			$sql = "call sp_cmdb_configurationitem_exists('".$this->name."')";	
			$result = $GLOBALS['db']->Query($sql);
			// ERROR
			if (!$result) {
				return false;
			}
			$exists = false;
			// EMAIL ADDRESS EXISTS
			while ($row = $GLOBALS['db']->FetchArray($result)) {		
				if ($row['Total'] > 0) {
					return true;					
				}
			}
		}
		return false;
	}	
	public function Delete() {

		$db=$GLOBALS['db'];

		if (ISSET($this->configurationid)) {
			$sql="CALL sp_cmdb_configurationitem_delete(".$this->configurationid.")";
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
			$this->debug("Deletion values not set");
			$this->Errors(MessageCatalogue(51));
			return False;
		}
	}
	public function DependencyAdd() {
		if (ISSET($this->configurationid) && ISSET($this->parentconfigurationid)) {
			$sql="CALL sp_cmdb_configurationitemdependency_add(".$this->configurationid.",".$this->parentconfigurationid.")";
			$this->debug($sql);
			$result = $GLOBALS['db']->Query($sql);			
			if ($result) {
				$this->debug("CI Dependency Added");
				$this->Errors(MessageCatalogue(49));
				return true;
			}
			else {
				$this->debug("Failed to add: ".mysql_error());
				$this->Errors(MessageCatalogue(50));
				return false;
			}
		}
		else {
			$this->debug("Values not set");
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
	  if ($type == "email" && !preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i",$this->$var)) {
        $this->Errors($var." needs to be an email address, you provided: ".$this->$var);
		$this->debug($var." needs to be $type, you provided: ".$this->$var);
        return False;        
      }
	  if ($type == "optional-numeric") {
		if (!EMPTY($var) && !IS_NUMERIC($var)) {
			$this->Errors($var." needs to be an optional number, you provided: ".$this->$var);
			$this->debug($var." needs to be $type, you provided: ".$this->$var);
			return False;        
		}
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