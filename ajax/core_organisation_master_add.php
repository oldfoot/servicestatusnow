<?php

define( '_VALID_DIR_', 1 );
require "../config.php";

require $dr."classes/organisation_master.php";

$org = new OrganisationMaster;
// GRAB THE PARAMS DYNAMICALLY
foreach ($_POST as $key=>$val) {	
//foreach ($_GET as $key=>$val) {	// FOR DEBUGGING
	$org->SetVar($key,$val);
}
// NEVER HANDLE THIS IN THE REQUEST SO OVERWRITE AT THE FINAL STAGE. THIS IS ALL SERVER SIDE
$org->SetVar("userid",$_SESSION['userid']);
$apicode = $user->GetVar("APIAuthCode");
$org->SetVar("api_auth_code",$apicode);
//$org->SetVar("debug",true);
// ADD
$result = $org->Add();
if (!$result) {
	echo $org->ShowErrors();
}
else {
	//$_SESSION['orgid'] = $org->GetVar("organisation_id");
	echo $org->ShowErrors();
}
?>