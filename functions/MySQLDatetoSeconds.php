<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

function MySQLDateToSeconds($dt) {
	$tempdate = explode(" ",$dt);
        $ymd = explode("-",$tempdate[0]);
        if (preg_match("/:/",$dt)) {
            $hms = explode(":",$tempdate[1]);
            $hour = $hms[0];
            $minute = $hms[1];
            $second = $hms[2];
        }
	$year = $ymd[0];
	$month = $ymd[1];
	$daynum = $ymd[2];

	if (STRLEN($dt) < 19) {
		$hour="00";
		$minute="00";
		$second="00";
	}
	
	return mktime($hour,$minute,$second,$month,$daynum,$year);
}
?>