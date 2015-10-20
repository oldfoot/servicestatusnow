<?php

define( '_VALID_DIR_', 1 );
require "../config.php";
require $GLOBALS['dr']."functions/FriendlyDateFromSeconds.php";
require $GLOBALS['dr']."functions/MySQLDateToSeconds.php";

// ANONYMOUS
if (!ISSET($_SESSION['userid'])) { 
	$apicode = "a42e21b8add8b4bc03c62d5bbdbaa2ef";
}
else {
	$orgid = $user->GetVar("OrganisationID");
	$apicode = $user->GetVar("APIAuthCode");
}

$sql = "call sp_service_status_recent10('".$apicode."')";
//echo $sql;
$result = $GLOBALS['db']->Query($sql);

if ($result && $GLOBALS['db']->NumRows($result) > 0) {
	echo "<ul class=\"list-group\">\n";
	while($row = $GLOBALS['db']->FetchArray($result)) {		
		$tm = $row['unixtime'];
		echo "<li class=\"list-group-item\">".time_ago($tm)." ago - ".$row['ServiceName']."</li>\n";		
	}
	echo "</ul>\n";
}
?>
