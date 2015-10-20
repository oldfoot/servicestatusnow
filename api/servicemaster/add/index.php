<?php
define( '_VALID_DIR_', 1 );
require_once "../../../config.php";
require_once "../../../classes/xml.php";
require_once "../../../classes/service_master.php";

if (!ISSET($_POST['apicode'])) { die("No API code set [Error:004]"); }
if (!ISSET($_POST['categoryid'])) { die("No Category ID set [Error:005]"); }
if (!ISSET($_POST['servicename'])) { die("No Service Name set [Error:006]"); }
if (!ISSET($_POST['orgid'])) { die("No Org ID set [Error:007]"); }

$xml = new xml;
$xml->SetHeader();
$xml->OpenXML("data");
$service = new ServiceMaster;

$service->SetVar("apicode",$_POST['apicode']);
$service->SetVar("categoryid",$_POST['categoryid']);
$service->SetVar("parentid","NULL");
$service->SetVar("servicename",$_POST['servicename']);
$service->SetVar("organisationid",$_POST['orgid']);
//$service->SetVar("debug",true);
$result=$service->Add();
$errors=$service->ShowErrors();
$serviceid=$service->GetVar("serviceid");

$xml->AddRow("serviceid",$serviceid);
$xml->AddRow("Result",$errors);

$xml->CloseXML("data");
$data = $xml->GetVar("content");

echo $data;
?>