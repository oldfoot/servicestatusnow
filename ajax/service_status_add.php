<?php

define( '_VALID_DIR_', 1 );
require "../config.php";

require $dr."classes/service_status_master.php";
require $dr."classes/service_master.php";
require $dr."classes/service_code_master.php";

// GET SERVICE CODE FROM NAME
$service = new ServiceMaster;
//$service->SetVar("debug",true);
$apicode = $user->GetVar("APIAuthCode");
$service->SetVar("apicode",$apicode);

if (ISSET($_POST['servicenamestatus'])) {	
	$service->SetVar("servicename",$_POST['servicenamestatus']);
}
$orgid = $user->GetVar("OrganisationID");
//echo $orgid;
$service->SetVar("orgid",$orgid);
$serviceid = $service->GetServiceIDFromName();

// GET CODE ID FROM NAME
$scm = new ServiceCodeMaster;
//$scm->SetVar("debug",true);

$scm->SetVar("apicode",$apicode);
if (ISSET($_POST['servicecode'])) {	
	$scm->SetVar("codename",$_POST['servicecode']);
}
$orgid = $user->GetVar("OrganisationID");
$scm->SetVar("orgid",$orgid);
$servicecode = $scm->GetServiceCodeFromName();
//echo "service code: $servicecode <br>";;

// ADD EVENT

//echo "Service ID: $serviceid<br/>";
$servicestatus = new ServiceStatusMaster;
$servicestatus->SetVar("apicode",$apicode);
$servicestatus->SetVar("serviceid",$serviceid);
$servicestatus->SetVar("servicecode",$servicecode);
// GRAB THE PARAMS DYNAMICALLY
//foreach ($_POST as $key=>$val) {
//foreach ($_GET as $key=>$val) {	// FOR DEBUGGING
	//$servicestatus->SetVar($key,$val);
//}
$servicestatus->SetVar("servicedesc",CleanVar($_POST['servicedesc']));
//$servicestatus->SetVar("debug",true);
// ADD
$result = $servicestatus->Add();

if (!$result) {
	echo $servicestatus->ShowErrors();	
}
else {
	echo $servicestatus->ShowErrors();
}
?>