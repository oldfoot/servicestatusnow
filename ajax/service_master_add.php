<?php

define( '_VALID_DIR_', 1 );
require "../config.php";

require $dr."classes/service_category_master.php";
require $dr."classes/service_master.php";

//foreach ($_POST as $key=>$val) {
	//echo $_POST[$key];
//}

$category = new ServiceCategoryMaster;
//$category->SetVar("debug",true);
$apicode = $user->GetVar("APIAuthCode");
$category->SetVar("apicode",$apicode);
if (ISSET($_POST['search_categoryname'])) {	
	$category->SetVar("categoryname",$_POST['search_categoryname']);
}
$orgid = $user->GetVar("OrganisationID");
$category->SetVar("orgid",$orgid);
$categoryid = $category->GetCategoryIDFromName();

$service = new ServiceMaster;
// GRAB THE PARAMS DYNAMICALLY
foreach ($_POST as $key=>$val) {
//foreach ($_GET as $key=>$val) {	// FOR DEBUGGING
	$service->SetVar($key,$val);
}
// NEVER HANDLE THIS IN THE REQUEST SO OVERWRITE AT THE FINAL STAGE. THIS IS ALL SERVER SIDE
//$service->SetVar("userid",$_SESSION['userid']);
$apicode = $user->GetVar("APIAuthCode");
$service->SetVar("apicode",$apicode);

$service->SetVar("categoryid",$categoryid);
$service->SetVar("parentid",0); // not implemented

$orgid = $user->GetVar("OrganisationID");
//echo "<br />ORD ID: $orgid<br />";
$service->SetVar("organisationid",$orgid);


//$service->SetVar("debug",true);
// ADD
$result = $service->Add();
if (!$result) {
	echo $service->ShowErrors();
}
else {
	echo $service->ShowErrors();
}
?>