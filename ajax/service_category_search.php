<?php
header('Content-type: application/xml');
define( '_VALID_DIR_', 1 );
require "../config.php";

$orgid = $user->GetVar("OrganisationID");
$apicode = $user->GetVar("APIAuthCode");

$sql = "call sp_service_category_browse('".$apicode."','".$orgid."')";				
$result = $GLOBALS['db']->Query($sql);

$c = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$c .= "<categories>\n";
if ($result && $GLOBALS['db']->NumRows($result) > 0) {
	while($row = $GLOBALS['db']->FetchArray($result)) {
		$c .= "<category label=\"".htmlentities($row['CategoryName'])."\" value=\"".$row['CategoryID']."\"/>\n";
	}
}
$c .= "</categories>\n";

echo $c;
?>
