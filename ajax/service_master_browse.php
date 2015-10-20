<?php
header('Content-type: application/xml');
define( '_VALID_DIR_', 1 );
require "../config.php";

$orgid = $user->GetVar("OrganisationID");
$apicode = $user->GetVar("APIAuthCode");

$sql = "call sp_service_master_browse('".$apicode."','".$orgid."')";				
//echo $sql;
$result = $GLOBALS['db']->Query($sql);

$c = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$c .= "<services>\n";
if ($result && $GLOBALS['db']->NumRows($result) > 0) {
	while($row = $GLOBALS['db']->FetchArray($result)) {
		$c .= "<service>\n";
			$c .= "<ServiceID>".$row['ServiceID']."</ServiceID>\n";
			$c .= "<CategoryName>".$row['CategoryName']."</CategoryName>\n";
			$c .= "<ServiceName>".htmlentities($row['ServiceName'])."</ServiceName>\n";
		$c .= "</service>\n";
	}
}
$c .= "</services>\n";

echo $c;
?>
