<?php

define( '_VALID_DIR_', 1 );
require "../config.php";

if (!ISSET($_GET['serviceid']) || !IS_NUMERIC($_GET['serviceid'])) { die("Invalid service provided"); }
$orgid = $user->GetVar("OrganisationID");
$apicode = $user->GetVar("APIAuthCode");

$sql = "call sp_service_status_browse('".$apicode."','".$_GET['serviceid']."')";				
$result = $GLOBALS['db']->Query($sql);

if ($result && $GLOBALS['db']->NumRows($result) > 0) {
	while($row = $GLOBALS['db']->FetchArray($result)) {
		echo htmlentities($row['ServiceDesc'])."\n";		
	}
}
?>
