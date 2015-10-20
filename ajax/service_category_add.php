<?php

define( '_VALID_DIR_', 1 );
require "../config.php";

require $dr."classes/service_category_master.php";

$category = new ServiceCategoryMaster;
// GRAB THE PARAMS DYNAMICALLY
foreach ($_POST as $key=>$val) {	
//foreach ($_GET as $key=>$val) {	// FOR DEBUGGING
	$category->SetVar($key,$val);
}
// NEVER HANDLE THIS IN THE REQUEST SO OVERWRITE AT THE FINAL STAGE. THIS IS ALL SERVER SIDE
$category->SetVar("userid",$_SESSION['userid']);
$orgid = $user->GetVar("OrganisationID");
$category->SetVar("orgid",$orgid);
$apicode = $user->GetVar("APIAuthCode");
$category->SetVar("apicode",$apicode);
//$category->SetVar("debug",true);
// ADD
$result = $category->Add();
if (!$result) {
	echo $category->ShowErrors();
}
else {
	echo $category->ShowErrors();
}
?>