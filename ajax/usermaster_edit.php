<?php
define( '_VALID_DIR_', 1 );
require "../config.php";

require_once $dr."classes/usermaster.php";

$um = new UserMaster;
// GRAB THE PARAMS DYNAMICALLY
foreach ($_POST as $key=>$val) {	
//foreach ($_GET as $key=>$val) {	// FOR DEBUGGING
	$um->SetVar($key,$val);
}
// NEVER HANDLE THIS IN THE REQUEST SO OVERWRITE AT THE FINAL STAGE. THIS IS ALL SERVER SIDE

$um->SetVar("userid",$_SESSION['userid']);
//$um->SetVar("debug",true);
// EDIT
$result = $um->Edit();
echo $um->ShowErrors();

if (ISSET($_POST['password']) && !EMPTY($_POST['password'])) {
	$um->SetVar("password",$_POST['password']);
	$result_ch_pw = $um->ChangePassword();					
	echo $um->ShowErrors();
}

?>