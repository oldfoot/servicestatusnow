<?php
require_once $GLOBALS['dr']."classes/usermaster.php";

class account {

	public function __construct() {
		$this->html = "";
	}	
	
	public function HTML() {
		// LOGGED IN?
		if (!ISSET($_SESSION['userid'])) {
			header("Location: login.php");
		}
		// PROCESS DELETION
		if (ISSET($_GET['delete'])) {
			$um = new UserMaster;
			//$um->SetVar("debug",true);
			$um->SetVar("userid",$_SESSION['userid']);
			$result = $um->Delete();
			$GLOBALS['errors']->SetAlert($um->ShowErrors());
			header("location: logout.php");			
		}
		
		$this->html .= "
			 <script>
				$(function() {					
					$('#accountform').submit(function(e) {						
						e.preventDefault();
						var a=$('#accountform').serialize();
						$.ajax({
							type:'post',
							url:'ajax/usermaster_edit.php',
							data:a,
							beforeSend:function(){
								ShowResponse('Working...',2000);
							},
							complete:function(){
								//ShowResponse('Done...',2000);
							},
							success:function(result){
								 ShowResponse(result,10000);
								 UpdateCategoryGridData();
							}
						});
					});
				});
				function ShowResponse(resp,timeout) {					
					$( \"#response\" ).text(resp).show();	
				};
			</script>
			";
		
		// INSTANTIATE THE USER OBJECT
		$um = new UserMaster;
		$um->SetParameters($_SESSION['userid']);
		$fullname = $um->GetVar("FullName");
		$timezone = $um->GetVar("Timezone");
		$userlogin = $um->GetVar("UserLogin");		
		$apicode = $um->GetVar("APIAuthCode");
		
		$options = "<option value='GMT'>GMT</option>\n";
		$sql = "CALL sp_timezones_browse()";
		//echo $sql;
		$result = $GLOBALS['db']->Query($sql);
		while ($row =  $GLOBALS['db']->FetchArray($result)) {
			if ($timezone == $row['Name']) { $selected = "selected"; } else { $selected = ""; }
			$options .= "<option value='".$row['Name']."' $selected>".$row['Name']."</option>\n";
		}
		
		// ORG INFO
		$sql = "CALL sp_core_organisation_user_get('$apicode','".$_SESSION['userid']."')";
		//echo $sql;
		$result = $GLOBALS['db']->Query($sql);
		while ($row =  $GLOBALS['db']->FetchArray($result)) {			
			$orgdata = "<div class='wrapper'>
							OrgName: ".$row['OrganisationName']." <a href='public/?".$row['OrganisationName']."'>Click for public service status board</a>
						</div>\n			
						";
		}
		
		$this->html .= "
			<div id='response'></div>
			<div class='pad'>
				<div class='wrapper'>
					<article class='col1'><h2>My Account</h2></article>
				</div>
			</div>	
			<div style='width:600px;padding:20px 20px 20px 20px'>	
				<form id='accountform'>
					<div>
						<h3>Editable Information</h3>
						<div class='wrapper'>
							<div class='bg'>Name: <input type='text' name='fullname' id='fullname' value='$fullname'></div>
						</div>
						<div class='wrapper'>
							<div class='bg'>Change Password:<input type='password' id='password' name='password'></div>
						</div>
						<div class='wrapper'>
							<div class='bg'>Timezone:<select name='timezone' id='timezone'>$options</select></div>
						</div>						
						<input type=submit value='Update' />
						<div class='wrapper'>
							<article class='col1'><h2>My Organisation</h2></article>
						</div>
						$orgdata
						<div class='wrapper'>
							<article class='col1'><h2>Non-editable Information</h2></article>
						</div>
						<div class='wrapper'>
							Email Address: $userlogin
						</div>
						<div class='wrapper'>
							<article class='col1'><h2>API Access</h2></article>
						</div>
						<div class='wrapper'>
							API Code: $apicode
						</div>
						<div class='wrapper'>
							<article class='col1'><h2>Account Removal</h2></article>
						</div>
						You're free at any time to remove your account. This involves deactivating your account and then removing
						all service status data from your account.<a href='#' class='button' onclick=\"document.location.href='index.php?content=account&delete=y'\">Delete</a>
					</div>
				</form>
			</div>
			";
		return $this->html;
	}
	public function Process() {
		$c = "";
		
		$um = new UserMaster;
		
	}
}
?>