<?php
define( '_VALID_DIR_', 1 );
require_once "../../../config.php";
require_once "../../../classes/xml.php";
require_once "../../../classes/service_category_master.php";

if (!ISSET($_POST['apicode'])) { die("No API code set [Error:001]"); }

$xml = new xml;
$xml->SetHeader();
$xml->OpenXML("data");

$sql = "CALL sp_service_status_codes_browse('".$_POST['apicode']."')";
$result = $GLOBALS['db']->Query($sql);
while ($row = $GLOBALS['db']->FetchArray($result)) {
	$xml->OpenXML("code");
		$xml->AddRow("servicecode",$row['ServiceCode']);
		$xml->AddRow("codename",$row['CodeName']);
		$xml->AddRow("codedesc",$row['CodeDesc']);
		$xml->AddRow("codeicon",$row['CodeIcon']);
	$xml->CloseXML("code");
}

$xml->CloseXML("data");
$data = $xml->GetVar("content");

echo $data;
?>