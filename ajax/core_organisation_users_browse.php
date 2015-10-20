<?php
header('Content-type: application/xml');
define( '_VALID_DIR_', 1 );
require "../config.php";

$orgid = $user->GetVar("OrganisationID");
$apicode = $user->GetVar("APIAuthCode");

$sql = "call sp_core_organisation_users('".$apicode."','".$orgid."')";				
$result = $GLOBALS['db']->Query($sql);

$c = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$c .= "<users>\n";
if ($result && $GLOBALS['db']->NumRows($result) > 0) {
	while($row = $GLOBALS['db']->FetchArray($result)) {
		$c .= "<user>\n";
			$c .= "<UserID>".$row['UserID']."</UserID>\n";
			$c .= "<FullName>".htmlentities($row['FullName'])."</FullName>\n";
			$c .= "<OrganisationName>".htmlentities($row['OrganisationName'])."</OrganisationName>\n";
		$c .= "</user>\n";
	}
}
$c .= "</users>\n";

echo $c;
?>
