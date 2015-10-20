<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

ob_start();

/*Menu Items*/
$main_menu_items_guest=array("Home","Service Status","Join","Login","Help");
$main_menu_items_member=array("Dash","Admin","Account","Help","Logout");
/*
$main_menu_items_console=array("Home","Account","OrgUsers","Org","Help");
$main_menu_items_admin=array("Home","Users","Organisations");
$main_menu_items_servicestatus=array("Home","Category","Service","Status","Icons");
*/

// TURN OFF ERRORS IN PRODUCTION
if ($_SERVER['SERVER_NAME'] == "localhost" || preg_match("/tst_/",$_SERVER['SCRIPT_NAME'])) {
	//ini_set("display_errors","Off");	
	error_reporting(E_ALL);	
	//error_reporting(0);
}
else {
	error_reporting(0);
}

require "classes/offline.php";	
$offline = new offline;

if (file_exists("siteoffline")) {
	$offline->SetVar("message_extra","We are doing a bit of maintenance, check back shortly.");
	echo $offline->Show();
	die();
}

require "classes/session.php";	

require_once "site_config.php";

$session = new session();

session_set_save_handler(array($session,"open"),
                         array($session,"close"),
                         array($session,"read"),
                         array($session,"write"),
                         array($session,"destroy"),
                         array($session,"gc")); 

session_start();


require "classes/mysqli.php";	
//require "classes/mysql.php";	



$db = new MySQL;
$dbconn = $db->Connect($database_hostname,$database_user,$database_password,$database_name,$database_port);

require_once "functions/MessageCatalogue.php";

function PrintSafeVar($v) {
	return htmlentities($v, ENT_QUOTES);
}

function GetSafeVar($from,$name) {
	if ($from == "get") {
		if (ISSET($_GET[$name])) {
			return addslashes($_GET[$name]);
		}
	}
	if ($from == "post") {
		if (ISSET($_POST[$name])) {			
			return addslashes($_POST[$name]);
		}
	}
}

function CleanVar($v) {
	return addslashes($v);		
}
// GLOBAL ERROR HANDLING
require_once "classes/errors.php";
$errors = new errors;

// CURRENT LOGGED IN USER DATA
if (ISSET($_SESSION['userid'])) {
	require_once "classes/core_usermaster.php";
	$user = new UserMaster;
	//$user->SetVar("debug",true);
	
	$user->SetParameters($_SESSION['userid']);	
	// ROLE PRIVILEGES
	
	require_once "classes/userroles.php";	
	
	$userroles = new UserRoles;		
	$userroles->SetVar("debug",true);	
	
}

// LOG
$url = "";
if (ISSET($_SERVER['SCRIPT_NAME'])) {
	$url .= $_SERVER['SCRIPT_NAME'];
}
if (ISSET($_SERVER['QUERY_STRING'])) {
	$url .= "?".$_SERVER['QUERY_STRING'];
}
$sessionid = session_id();

$ignore_log_urls = array("cron");

foreach ($ignore_log_urls as $url) {
	if (!preg_match("/$url/",$_SERVER['SCRIPT_NAME'])) {
		$sql = "INSERT INTO core_log (SCRIPT_NAME,DateTimeLogged,SessionID) 
				VALUES (
				'".mysqli_real_escape_string($dbconn,$url)."',
				sysdate(),
				'".$sessionid."'
				)";
		$db->Query($sql);
	}
}
?>