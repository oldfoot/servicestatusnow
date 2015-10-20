<?php

define( '_VALID_DIR_', 1 );
require "../config.php";

require $dr."classes/service_master.php";

$service = new ServiceMaster;
// GRAB THE PARAMS DYNAMICALLY
foreach ($_POST as $key=>$val) {	
//foreach ($_GET as $key=>$val) {	// FOR DEBUGGING
	$service->SetVar($key,$val);
}
// NEVER HANDLE THIS IN THE REQUEST SO OVERWRITE AT THE FINAL STAGE. THIS IS ALL SERVER SIDE

$apicode = $user->GetVar("APIAuthCode");
$service->SetVar("apicode",$apicode);
//$service->SetVar("debug",true);
// EDIT
$result = $service->Edit();
if (!$result) {
	echo $service->ShowErrors();
}
else {
	echo $service->ShowErrors();
}
?>