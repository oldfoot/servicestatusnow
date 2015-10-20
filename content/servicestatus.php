<?php
//require_once $GLOBALS['dr']."classes/usermaster.php";

class servicestatus {

	public function __construct() {
		$this->html = "";
	}	
	
	public function HTML() {
		
		$c = "<div style='font-size:25px;padding:10px 10px 10px 10px'>Example of a dashboard</div>";
		
		$skins = array("stash","googletimeline","heroku");
		
		$template = "stash";
		if (ISSET($_GET['skin']) && in_array($_GET['skin'],$skins)) {		
			$template = $_GET['skin'];
		}		
		
		require_once $GLOBALS['dr']."servicestatus/templates/".$template."/index.php";		
			
		$temp = new $template;
		$c .= $temp->show();
		
		return $c;
	}
}
?>