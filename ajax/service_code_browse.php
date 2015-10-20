<?php
header('Content-type: application/xml');
define( '_VALID_DIR_', 1 );
require "../config.php";

$orgid = $user->GetVar("OrganisationID");
$apicode = $user->GetVar("APIAuthCode");

$sql = "call sp_service_code_browse('".$apicode."','".$orgid."')";				
$result = $GLOBALS['db']->Query($sql);

$c = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$c .= "<codes>\n";
if ($result && $GLOBALS['db']->NumRows($result) > 0) {
	while($row = $GLOBALS['db']->FetchArray($result)) {
		//$c .= "<codes>\n";
			//$c .= "<ServiceCode>".$row['ServiceCode']."</ServiceCode>\n";
			$c .= "<code label='".$row['CodeName']."' />\n";
			//$c .= "<CodeDesc>".$row['CodeDesc']."</CodeDesc>\n";
			//$c .= "<CodeIcon>".$row['CodeIcon']."</CodeIcon>\n";			
		//$c .= "</codes>\n";
	}
}
$c .= "</codes>\n";

echo $c;
?>
