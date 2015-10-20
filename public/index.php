<?php
define( '_VALID_DIR_', 1 );
require "../config.php";

require_once $GLOBALS['dr']."/classes/organisation_master.php";
require_once $GLOBALS['dr']."/servicestatus/templates/stash/index.php";

foreach ($_GET as $key=>$val) {
	echo "<H1>".PrintSafeVar($key)." - Public Service Status Now</h1>\n";
	break;
}
$org = new OrganisationMaster;
$org->SetVar("organisation",$key);
//$org->SetVar("debug",true);
$orgid = $org->GetOrgIDFromName();
//echo $orgid;
if (!IS_NUMERIC($orgid)) { die("Invalid organisation"); }

$data = new stash;
$data->SetVar("orgid",$orgid);
echo $data->show();
?>