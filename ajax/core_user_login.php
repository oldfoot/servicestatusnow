<?php

define( '_VALID_DIR_', 1 );
require "../config.php";

require_once $dr."classes/core_usermaster.php";
require_once $dr."classes/organisation_master.php";

if (!ISSET($_POST['userlogin']) || !ISSET($_POST['password'])) { die("Invalid Params"); }
$username = CleanVar($_POST['userlogin']);
$password = CleanVar($_POST['password']);

$um = new UserMaster;
//$um->SetVar("debug",true);
$um->SetVar("userlogin",$username);
$um->SetVar("password",$password);

// exists
if ($um->Exists()) {
	$result = $um->Login();
}
else {
	$um->SetVar("fullname",$username);
	$result = $um->Add();
	if (!preg_match("/@/",$username)) {
		echo "Invalid username, must be an email";
		die();
	}
	$om = new OrganisationMaster;
	//$om->SetVar("debug",true);
	$pieces = explode("@",$username);
	$domain = $pieces[1];
	if (!preg_match("/\./",$domain)) {
		echo "Invalid username, must be an email";
		die();
	}
	$domain_pieces = explode(".",$domain);
	$organisation = $domain_pieces[0];
	//echo "Organisation: $organisation <br />";
	$om->SetVar("organisation",$organisation);
	$om->SetVar("userid",$um->GetVar("UserID"));
	$om->SetVar("api_auth_code",$um->GetVar("APIAuthCode"));
	$organisationid = $om->OrganisationExists();
	//echo "ORG ID: $organisationid <br />";
	// ADD TO EXISTING ORGANISATION BUT NOT APPROVED SINCE SOMEONE ELSE HAS ALREADY ADDED IT
	if ($organisationid > 1) {
		//echo "Adding to existing org <br />";
		$om->SetVar("approved","n");
		$om->SetVar("organisationid",$organisationid);
		$om->SetVar("orgroleid",1);
		$om->UserAdd();
	}
	else {
		// NO ORG, SO ADD IT
		//echo "NO ORG, Add Org and then User<br />";
		//$om->SetVar("debug",true);
		$om->SetVar("organisationname",$organisation);		
		$om->SetVar("userid",$um->GetVar("userid"));
		$om->SetVar("api_auth_code",$um->GetVar("APIAuthCode"));		
		$om->Add();
		$organisationid = $om->GetVar("organisation_id");
		// ADD USER
		$organisationid = $om->GetVar("organisation_id");
		$om->SetVar("api_auth_code",$um->GetVar("APIAuthCode"));
		$om->SetVar("organisationid",$organisationid);
		$om->SetVar("userid",$um->GetVar("userid"));
		$om->SetVar("orgroleid","1");
		$om->SetVar("approved","y");		
		$om->UserAdd();
		
		/*echo "Adding to default org<br/>";
		$om->SetVar("organisation","Demo Organisation");		
		$om->SetVar("debug",true);
		$om->AddDefault();
		*/
	}
	
}

if ($result) {
	//echo "Setting session";
	$_SESSION['userid'] = $um->GetVar("userid");
	$_SESSION['username'] = $username;
}
$res = $um->ShowErrors();
$res = str_replace("\n","",$res);

echo $res;

?>