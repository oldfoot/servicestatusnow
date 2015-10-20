<?php
define( '_VALID_DIR_', 1 );
require "../config.php";
// NO USER
if (!ISSET($_SESSION['orgid'])) {	
	$apicode = "a42e21b8add8b4bc03c62d5bbdbaa2ef";
	$_SESSION['orgid'] = "1";
}
if (ISSET($_SESSION['userid'])) {		
	//echo "Got a user";
	$_SESSION['orgid'] = $GLOBALS['user']->GetVar("OrganisationID");
	//echo $_SESSION['orgid']."<br />";
	$apicode = $GLOBALS['user']->GetVar("APIAuthCode");
}
/*
echo $apicode;
echo "ok";
echo $_SESSION['orgid'];
echo "<br />UserID: ".$_SESSION['userid']."<br />";
*/


$sql = "CALL sp_service_organisationid_status(".$_SESSION['orgid'].")";
//echo $sql;
$result = $GLOBALS['db']->Query($sql);

$c = "";
$category   = "whatever";
$breakafter = 3;
$count      = 0;
$break_count= 0;
if ($GLOBALS['db']->NumRows($result) == 0) {
	$c.="No data configured for this Organisation yet\n";
}
while ($row = $GLOBALS['db']->FetchArray($result)) {
	
	if ($category != $row['CategoryName']) {
		$count = 0;
		$c.="<div><h3>";
			$c.=$row['CategoryName'];
		$c.="</h3></div>\n";
		
	}
	if ($count == 0) {
		$c.="<div class='row'>\n";
	}		
		
		$c.="<div class='col-md-4'>";
		$c.="<img src='".$GLOBALS['wb']."images/servicestatus/".$row['CodeIcon']."' alt='".htmlspecialchars($row['CodeDesc'], ENT_QUOTES)."' title='".htmlspecialchars($row['CodeDesc'], ENT_QUOTES)."'><span onClick=\"openDialog('New Type','ajax/service_status_master.php?serviceid=".$row['ServiceID']."')\">".$row['ServiceName']."</span>";		
		$c.="</div>\n";
		
		$count++;
	if ($count == $breakafter) {
		$break_count++;
		$c.="</div>\n";
		$count=0;
	}
	if ($count == $breakafter || $category != $row['CategoryName']) {
		//$c.="</div>\n";
		//$count=0;
	}
	$category = $row['CategoryName'];	
	
}
$missing_rows = $breakafter - $break_count;
//echo $missing_rows;
for ($i=0;$i<$missing_rows;$i++) {
	$c.="<div class='col-md-4'></div>\n";
}

$c.="</div>\n";

//$c .= foot();


echo $c;


function foot() {
	$c = "<div id='legend' style='border:1px solid gray'>
			<h4> Status Legend </h4>
			<ul>
			
	";
	$sql = "call sp_service_code_browse_napi(".$_SESSION['orgid'].")";
	//echo $sql;
	$result = $GLOBALS['db']->Query($sql);


	if ($result && $GLOBALS['db']->NumRows($result) > 0) {
		while($row = $GLOBALS['db']->FetchArray($result)) {	
			//$c .= "<li>\n";
				$c .= "&nbsp;&nbsp;&nbsp;<img src='".$GLOBALS['wb']."images/servicestatus/".$row['CodeIcon']."' alt='".$row['CodeDesc']."'>".$row['CodeDesc'];
			//$c .= "</li>\n";		
		}
	}
}  

?>