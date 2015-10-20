<?php
class metro {
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
		$c .= "<table style='background-color:#ffffff;width:100%'>\n";
		$category   = "whatever";
		$breakafter = 4;
		$count      = 0;
		if ($GLOBALS['db']->NumRows($result) == 0) {
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
		}
		$c = "
		<script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>
		<script type=\"text/javascript\">
		  google.load(\"visualization\", \"1\", {packages:[\"gauge\"]});
		  google.setOnLoadCallback(drawChart);
		  function drawChart() {

			var data = google.visualization.arrayToDataTable([
			  ['Label', 'Value'],
			  ['Memory', 80],
			  ['CPU', 55],
			  ['Network', 68]
			]);

			var options = {
			  width: 400, height: 120,
			  greenFrom: 0, redTo: 50,
			  redFrom: 50, redTo: 100,			  
			  minorTicks: 5
			};

			var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

			chart.draw(data, options);

			
		  }
		</script>
		
		<body>
		<div id=\"chart_div\" style=\"width: 400px; height: 120px;\"></div>
		</body>
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