<?php
class dash {

	public function __construct() {
		$this->html = "";
	}	
	
	public function HTML() {
		
		$skins = array("stash","metro");
		//$c = "<a href='index.php?content=dash&skin=stash'>Stash</a> | <a href='index.php?content=dash&skin=metro'>Metro</a> | ";
		$c = "";
		
		
		$template = "stash";
		if (ISSET($_GET['skin']) && in_array($_GET['skin'],$skins)) {		
			$template = $_GET['skin'];
		}					
		
		require_once $GLOBALS['dr']."servicestatus/templates/".$template."/index.php";
		
		$temp = new $template;
		$c .= $temp->show();
		
		$c .= ob_get_clean();		
		
		return $c;
	}	
}
?>