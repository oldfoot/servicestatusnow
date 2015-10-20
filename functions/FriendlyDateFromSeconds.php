<?php
function FriendlyDateFromSeconds($dt,$onlytime=false,$showposneg=false) {
	//echo $dt."<br />"; // DEBUG
	$showsymbol = "";
	if ($showposneg) {
		if ($dt < 0) {
			$showsymbol = "-";
		}	
		else {
			$showsymbol = "+";
		}
	}
	$dt = abs($dt);
	if ($dt == 0) {
		return false;
	}
	elseif ($dt < 60) {
		if ($onlytime) {
			return "$dt secs";
		}
		else {
			return "< 1 min ago";
		}
	}
	elseif ($dt < 3600) {
		$min = round(($dt / 60),0);
		$plural = "";
		if ($min > 1) {
			$plural = "s";
		}		
		if ($onlytime) {
			return "$showsymbol$min mins";
		}
		else {
			return "$min min$plural ago";
		}
	}
	elseif ($dt < 86400) {
		$hour = round(($dt / 3600),0);
		$plural = "";
		if ($hour > 1) {
			$plural = "s";
		}		
		if ($onlytime) {
			return "$showsymbol$hour hour$plural";
		}
		else {
			return "$hour hour$plural ago";
		}
	}
	else {
		$days = round(($dt / 86400),0);		
		$plural = "";
		if ($days > 1) {
			$plural = "s";
		}		
		if ($onlytime) {
			return "$showsymbol$days day$plural";
		}
		else {
			return "$days day$plural ago";
		}
	}
}
function ago($time)
{
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j] ago ";
}
function time_ago($tm,$rcs = 0) {
	//echo "<br />$tm & TIME: ".time(). "</br>";
   $cur_tm = time(); $dif = $cur_tm-$tm;
   
   $pds = array('second','minute','hour','day','week','month','year','decade');
   $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
   for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

   $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
   if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
   return $x;
}
?>