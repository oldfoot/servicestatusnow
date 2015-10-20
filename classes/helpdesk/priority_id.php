<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

class PriorityID {

	function __construct() {

		$this->errors="";
	}
	public function SetParameters($priority_id) {

		/* SET CHECKING TO FALSE */
		$this->parameter_check=False;

		/* CHECKS */
		if (!IS_NUMERIC($priority_id)) { $this->Errors("Invalid priority"); return False; }

		/* SET SOME COMMON VARIABLES */
		$this->priority_id=$priority_id;

		/* CALL THE priorityID INFORMATION */
		$this->Info($priority_id);

		/* PARAMETER CHECK SUCCESSFUL */
		$this->parameter_check=True;

		return True;
	}

	private function Info() {

		$this->db=$GLOBALS['db'];

		$sql="SELECT priority_name
					FROM ".$GLOBALS['database_prefix']."helpdesk_priority_master
					WHERE priority_id = '".$this->priority_id."'
					";
		//echo $sql."<br>";
		$result = $this->db->Query($sql);
		if ($this->db->NumRows($result) > 0) {
			while($row = $this->db->FetchArray($result)) {
				/* HERE WE CALL THE FIELDS AND SET THEM INTO DYNAMIC VARIABLES */
				$arr_cols=$this->db->GetColumns($result);
				for ($i=1;$i<count($arr_cols);$i++) {
					$col_name=$arr_cols[$i];
					$this->$col_name=$row[$col_name];
				}
			}
		}
	}

	public function GetInfo($v) {
		return $this->$v;
	}

	public function Add($priority_name) {

		/* CHECKS */
		if(!preg_match("([a-zA-Z0-9])",$priority_name))  { $this->Errors("Invalid priority name. Please use only alpha-numeric values!"); return False; }
		if (RowExists("helpdesk_priority_master","priority_name","'".$priority_name."'","AND workspace_id=".$GLOBALS['workspace_id'])) { $this->Errors("priority name exists. Please choose another."); return False; }

		/* DATABASE CONNECTION */
		$db=$GLOBALS['db'];

		$sql="INSERT INTO ".$GLOBALS['database_prefix']."helpdesk_priority_master
					(priority_name,workspace_id,teamspace_id)
					VALUES (
					'".$priority_name."',
					".$GLOBALS['workspace_id'].",
					".$GLOBALS['teamspace_id']."
					)";
		$result=$db->query($sql);
		if ($db->AffectedRows() > 0) {
				//LogHistory($priority_name." added");
				return True;
		}
		else {
			return False;
		}
	}

	public function Edit($priority_name) {

		/* CHECKS */
		if (!$this->parameter_check) { $this->Errors("Parameter check failed"); return False; }
		if(!preg_match("([a-zA-Z0-9])",$priority_name))  { $this->Errors("Invalid priority name. Please use only alpha-numeric values!"); return False; }
		if (RowExists("helpdesk_priority_master","priority_name","'".$priority_name."'","AND workspace_id=".$GLOBALS['workspace_id'])) { $this->Errors("priority name exists. Please choose another."); return False; }

		/* DATABASE CONNECTION */
		$db=$GLOBALS['db'];

		$sql="UPDATE ".$GLOBALS['database_prefix']."helpdesk_priority_master
					SET priority_name = '".$priority_name."'
					WHERE priority_id = ".$this->priority_id."
					";
		$result=$db->query($sql);
		if ($db->AffectedRows() > 0) {
				return True;
		}
		else {
			return False;
		}
	}

	public function Delete() {

		$db=$GLOBALS['db'];

		if ($this->parameter_check) {
			$sql="DELETE
						FROM ".$GLOBALS['database_prefix']."helpdesk_priority_master
						WHERE priority_id = ".$this->priority_id."
						";
			//echo $sql;
			$result=$db->query($sql);
			if ($db->AffectedRows($result) > 0) {
				//LogHistory($this->priority_name." deleted");
				return True;
			}
			else {
				$this->Errors("Failed to delete");
				return False;
			}
		}
		else {
			$this->Errors("Sorry, parameter check failed<br>");
			return False;
		}
	}

	private function Errors($err) {
		$this->errors.=$err."<br>";
	}

	public function ShowErrors() {
		return $this->errors;
	}
}
?>