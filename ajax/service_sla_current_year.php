<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Oct 2013 05:00:00 GMT');
header('Content-type: application/json');

define( '_VALID_DIR_', 1 );
require "../config.php";
require $GLOBALS['dr']."functions/FriendlyDateFromSeconds.php";
require $GLOBALS['dr']."functions/MySQLDateToSeconds.php";

// ANONYMOUS
if (!ISSET($_SESSION['userid'])) { 
	$apicode = "a42e21b8add8b4bc03c62d5bbdbaa2ef";
	$orgid = "1";
}
else {
	$orgid = $user->GetVar("OrganisationID");
	$apicode = $user->GetVar("APIAuthCode");
}

$sql = "call sp_service_sla_current_year('".$orgid."')";
$result = $GLOBALS['db']->Query($sql);

$available = 0;
$unavailable = 0;
$maintenance = 0;
$impacted = 0;

if ($result && $GLOBALS['db']->NumRows($result) > 0) {	
	while($row = $GLOBALS['db']->FetchArray($result)) {				
		if ($row['CodeMeaning'] == "Unavailable") {
			$unavailable = $row['diff']/$row['seconds_year'];
		}
	}
}
echo round(100-$unavailable,3);
?>
