<?php
define( '_VALID_DIR_', 1 );
require_once "../../../config.php";
require_once "../../../classes/xml.php";
require_once "../../../classes/service_status_master.php";

if (!ISSET($_POST['apicode'])) { die("No API code set [Error:008]"); }
if (!ISSET($_POST['serviceid'])) { die("No Service ID set [Error:009]"); }
if (!ISSET($_POST['servicecode'])) { die("No Service Code set [Error:010]"); }
if (!ISSET($_POST['servicedesc'])) { die("No Service Description set [Error:011]"); }

$xml = new xml;
$xml->SetHeader();
$xml->OpenXML("data");
$status = new ServiceStatusMaster;

$status->SetVar("apicode",$_POST['apicode']);
$status->SetVar("serviceid",$_POST['serviceid']);
$status->SetVar("servicecode",$_POST['servicecode']);
$status->SetVar("servicedesc",$_POST['servicedesc']);
$status->SetVar("debug",true);
$result=$status->Add();
$errors=$status->ShowErrors();
$statusid=$status->GetVar("statusid");

$xml->AddRow("statusid",$statusid);
$xml->AddRow("Result",$errors);

$xml->CloseXML("data");
$data = $xml->GetVar("content");

echo $data;
?>