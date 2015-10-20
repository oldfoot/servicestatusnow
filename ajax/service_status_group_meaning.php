<?php

define( '_VALID_DIR_', 1 );
require "../config.php";
require $GLOBALS['dr']."functions/FriendlyDateFromSeconds.php";
require $GLOBALS['dr']."functions/MySQLDateToSeconds.php";

// ANONYMOUS
if (!ISSET($_SESSION['userid'])) { 
	$apicode = "a42e21b8add8b4bc03c62d5bbdbaa2ef";
	$orgid = 1;
}
$orgid = $user->GetVar("OrganisationID");
$apicode = $user->GetVar("APIAuthCode");

$sql = "call sp_service_status_group_meaning('".$orgid."')";
//echo $sql;
$result = $GLOBALS['db']->Query($sql);

if ($result && $GLOBALS['db']->NumRows($result) > 0) {
	$ok = true;
	while($row = $GLOBALS['db']->FetchArray($result)) {		
		if ($row['CodeMeaning'] != "Available") {
			$ok = false;
		}
	}	
}
if ($ok) {
	echo "1";
}
else {
	echo "2";
}
?>
