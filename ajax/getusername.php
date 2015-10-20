<?php
define( '_VALID_DIR_', 1 );
require "../config.php";

//require "../classes/usermaster.php";

if (ISSET($_SESSION['userid'])) {
	$um = new UserMaster;
	$um->SetParameters($_SESSION['userid']);
	echo "Welcome, ".$um->GetVar("FullName");
}
else {
	echo "Welcome, Guest";
}
?>