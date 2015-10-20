<?php
define( '_VALID_DIR_', 1 );
require_once "../../../config.php";
require_once "../../../classes/xml.php";
require_once "../../../classes/service_category_master.php";
//print_r($_POST);
//echo "<hr>";
//print_r($_POST);
if (!ISSET($_POST['apicode'])) { die("No API code set [Error:001]"); }
if (!ISSET($_POST['categoryname'])) { die("No Category set [Error:002]"); }
if (!ISSET($_POST['orgid'])) { die("No Org set [Error:003]"); }

$xml = new xml;
$xml->SetHeader();
$xml->OpenXML("data");
$servicecategory = new ServiceCategoryMaster;

$servicecategory->SetVar("apicode",$_POST['apicode']);
$servicecategory->SetVar("categoryname",$_POST['categoryname']);
$servicecategory->SetVar("orgid",$_POST['orgid']);
//$servicecategory->SetVar("debug",true);
$result=$servicecategory->Add();
$errors=$servicecategory->ShowErrors();
$categoryid=$servicecategory->GetVar("categoryid");
//if ($categoryid == 0) { die("Failed: $result"); } else { echo "Success: $result (categoryid=$categoryid)"; }
//$unittest->Run("Adding Service Category", $categoryid, "bool", true);

$xml->AddRow("categoryid",$categoryid);
$xml->AddRow("Result",$errors);

$xml->CloseXML("data");
$data = $xml->GetVar("content");

echo $data;
?>