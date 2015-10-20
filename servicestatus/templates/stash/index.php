<?php
class stash {
	public function __construct() {
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
		$v = strtolower($v);
		$this->$v = $val;
	}
	public function show() {
		
		if (!ISSET($this->orgid) && ISSET($_SESSION['userid'])) {		
			$this->orgid = $GLOBALS['user']->GetVar("OrganisationID");
			$this->apicode = $GLOBALS['user']->GetVar("APIAuthCode");
			//echo "Ord ID: $orgid";	
			if (empty($this->orgid)) {		
				$this->errors("No org set. Can't proceed");
				return false;
			}
		}
		elseif (!ISSET($this->orgid)) {
			//echo "Browsing public";
			$this->apicode = "a42e21b8add8b4bc03c62d5bbdbaa2ef";
			$this->orgid = "1";
		}
		// ELSE THE orgid IS SET
		else {
			//echo "Browsing public 2";
		}
		$sql = "CALL sp_service_organisationid_status(".$this->orgid.")";
		//echo $sql;
		$result = $GLOBALS['db']->Query($sql);

		$c = "
		<script type=\"text/javascript\">
			function openDialog(title,url) {
				$('.opened-dialogs').dialog(\"close\");

				$('<div class=\"opened-dialogs\">').html('loading...').dialog({
					position:  ['center',20],
					open: function () {
						$(this).load(url);

					},
					close: function(event, ui) {
							$(this).remove();
					},

					title: title,
					minWidth: 600            
				});

				return false;
			}
		</script>

		";
		$c .= "<table style='background-color:#ffffff;width:100%'>\n";
		$category   = "whatever";
		$breakafter = 4;
		$count      = 0;
		if ($GLOBALS['db']->NumRows($result) == 0) {
			$c.="<tr>\n";
				$c.="<td style='font-size:20px;'>No data configured for this Organisation yet</td>\n";
			$c.="</tr>\n";
		}
		while ($row = $GLOBALS['db']->FetchArray($result)) {
			
			if ($category != $row['CategoryName']) {
				$count = 0;
				$c.="<tr>\n";
					$c.="<td colspan=$breakafter style='font-size:20px;'>".$row['CategoryName']."</td>\n";
				$c.="</tr>\n";
			}
			if ($count == 0) {
				$c.="<tr>\n";		
			}		
				
				$c.="<td>";		
				$c.="<img src='".$GLOBALS['wb']."images/servicestatus/".$row['CodeIcon']."' alt='".htmlspecialchars($row['CodeDesc'], ENT_QUOTES)."' title='".htmlspecialchars($row['CodeDesc'], ENT_QUOTES)."'><span onClick=\"openDialog('New Type','ajax/service_status_master.php?serviceid=".$row['ServiceID']."')\">".$row['ServiceName']."</span>";		
				$c.="</td>\n";		
				//$c.="<td></td>\n";
				
			$count++;
			if ($count == $breakafter) {
				$c.="</tr>\n";
				$count=0;
			}
			$category = $row['CategoryName'];
			
		}
		$c.="</table>\n";
		
		$c .= $this->foot();
		
		return $c;
	}
	
	public function foot() {
		$c = "<div id='legend' style='border:1px solid gray'>
				<h4> Status Legend </h4>
				<ul>
				
		";
		$sql = "call sp_service_code_browse_napi($this->orgid)";				
		//echo $sql;
		$result = $GLOBALS['db']->Query($sql);


		if ($result && $GLOBALS['db']->NumRows($result) > 0) {
			while($row = $GLOBALS['db']->FetchArray($result)) {	
				//$c .= "<li>\n";
					$c .= "&nbsp;&nbsp;&nbsp;<img src='".$GLOBALS['wb']."images/servicestatus/".$row['CodeIcon']."' alt='".$row['CodeDesc']."'>".$row['CodeDesc'];
				//$c .= "</li>\n";		
			}
		}
		  
		$c .= "</ul>
			</div>
		  </div>		  
		</div>
		";
		return $c;
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