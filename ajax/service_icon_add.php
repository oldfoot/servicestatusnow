<?php

define( '_VALID_DIR_', 1 );
require "../config.php";

require $dr."classes/service_code_master.php";
/*
foreach ($_POST as $key=>$val) {
	echo $_POST[$key];
}
*/
$code = new ServiceCodeMaster;
//$code->SetVar("debug",true);
$apicode = $user->GetVar("APIAuthCode");
$code->SetVar("apicode",$apicode);
if (ISSET($_POST['search_categoryname'])) {	
	$code->SetVar("categoryname",$_POST['search_categoryname']);
}
$orgid = $user->GetVar("OrganisationID");
$code->SetVar("orgid",$orgid);

// GRAB THE PARAMS DYNAMICALLY
foreach ($_POST as $key=>$val) {
//foreach ($_GET as $key=>$val) {	// FOR DEBUGGING
	$code->SetVar($key,$val);
}

// ADD
$result = $code->Add();
if (!$result) {
	echo $code->ShowErrors();
}
else {
	echo $code->ShowErrors();
}
?>