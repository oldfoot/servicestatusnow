<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class Stats {

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
		$this->$v = trim($val);
	}
	
	public function ServiceSLACurrentYear() {
		if (!ISSET($this->orgid)) { $this->Errors("Invalid Org"); return false; }
		
		$sql = "call sp_service_sla_current_year('".$this->orgid."')";
		$result = $GLOBALS['db']->Query($sql);

		$unavailable = 0;

		if ($result && $GLOBALS['db']->NumRows($result) > 0) {	
			while($row = $GLOBALS['db']->FetchArray($result)) {				
				if ($row['CodeMeaning'] == "Unavailable") {
					$unavailable = $row['diff']/$row['seconds_year'];
				}
			}
		}
		return round(100-$unavailable,3);
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