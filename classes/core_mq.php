<?php
class mq {
	public function __construct() {
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
		$this->$v = $val;
	}
	public function InsertMaster() {
		if (ISSET($this->type)) {
			$sql = "CALL sp_mq_master_insert('".$this->type."')";
			$this->debug($sql);
			$result = $GLOBALS['db']->Query($sql);			
			if ($GLOBALS['db']->NumRows($result) > 0) {
				$this->debug('Inserted at least one row into master');
				while($row = $GLOBALS['db']->FetchArray($result)) {
					$this->debug('Returning id');
					$this->masterid = $row['id'];
					return $row['id'];
				}
			}
		}
		$this->debug('No rows inserted');
		return 0;
	}
	public function InsertDetails() {
		if (ISSET($this->masterid) && ISSET($this->name) && ISSET($this->value)) {
			$sql = "CALL sp_mq_detail_insert('".$this->masterid."','".$this->name."','".$this->value."')";
			$this->debug($sql);
			$result = $GLOBALS['db']->Query($sql);
			if ($GLOBALS['db']->NumRows($result) > 0) {
				$this->debug('Inserted at least one row into details');
				while($row = $GLOBALS['db']->FetchArray($result)) {
					$this->debug('Returning id');
					return $row['id'];
				}
			}
		}
	}
	private function debug($msg) {
		if ($this->debug) {
			echo $msg."<br />\n";
		}
	}
}
?>