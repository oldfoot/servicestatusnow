<?php
//require_once $GLOBALS['dr']."classes/usermaster.php";

class admin {

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
			$um->SetVar("userid",$_SESSION['userid']);
			$result = $um->Delete();
			$GLOBALS['errors']->SetAlert($um->ShowErrors());
			header("location: logout.php");			
		}
		// PROCESS EDITING AND PASSWORD CHANGE
		if (ISSET($_POST['fullname'])) {
			//echo "ok";
			$um = new UserMaster;
			//$um->SetVar("debug",true);
			$um->SetVar("fullname",$_POST['fullname']);
			$um->SetVar("timezone",$_POST['timezone']);
			$um->SetVar("contactdetails",$_POST['contactdetails']);
			//$um->SetVar("password",$_POST['password']);
			
			$um->SetVar("userid",$_SESSION['userid']);
			$result = $um->Edit();
			if (!$result) {
				$GLOBALS['errors']->SetAlert($um->ShowErrors());
			}
			else {
				if (ISSET($_POST['password']) && !EMPTY($_POST['password'])) {
					$um->SetVar("password",$_POST['password']);
					$result_ch_pw = $um->ChangePassword();					
				}
				$GLOBALS['errors']->SetAlert($um->ShowErrors());
			}				
		}
		// INSTANTIATE THE USER OBJECT
		$um = new UserMaster;
		$um->SetParameters($_SESSION['userid']);
		$fullname = $um->GetVar("FullName");
		$timezone = $um->GetVar("Timezone");
		$userlogin = $um->GetVar("UserLogin");
		$contactdetails = $um->GetVar("ContactDetails");
		
		$options = "<option value='GMT'>GMT</option>\n";
		$sql = "CALL sp_timezones_browse()";
		//echo $sql;
		$result = $GLOBALS['db']->Query($sql);
		while ($row =  $GLOBALS['db']->FetchArray($result)) {
			if ($timezone == $row['Name']) { $selected = "selected"; } else { $selected = ""; }
			$options .= "<option value='".$row['Name']."' $selected>".$row['Name']."</option>\n";
		}
		
		$this->html .= "
			 <script>
				$(function() {
					$( \"#accordion\" ).accordion({heightStyle: 'content'});
					
					$('#formcategory').submit(function(e) {
						e.preventDefault();
						var a=$('#formcategory').serialize();
						$.ajax({
							type:'post',
							url:'ajax/service_category_add.php',
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
					
					$('#formservice').submit(function(e) {
						e.preventDefault();
						var a=$('#formservice').serialize();
						$.ajax({
							type:'post',
							url:'ajax/service_master_add.php',
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
					
					$('#formevent').submit(function(e) {
						e.preventDefault();
						var a=$('#formevent').serialize();
						$.ajax({
							type:'post',
							url:'ajax/service_status_add.php',
							data:a,
							beforeSend:function(){
								ShowResponse('Working...',2000);
							},
							complete:function(){
								//ShowResponse('Done...',2000);
							},
							success:function(result){
								 ShowResponse(result,10000);
								 //UpdateCategoryGridData();
							}
						});
					});
					
					$('#formicon').submit(function(e) {
						e.preventDefault();
						var a=$('#formicon').serialize();
						$.ajax({
							type:'post',
							url:'ajax/service_icon_add.php',
							data:a,
							beforeSend:function(){
								ShowResponse('Working...',2000);
							},
							complete:function(){
								//ShowResponse('Done...',2000);
							},
							success:function(result){
								 ShowResponse(result,10000);
								 //UpdateCategoryGridData();
							}
						});
					});
					
					// AUTO COMPLETE FOR CATEGORY IN ADD SERVICE FORM
					var myArr = [];
	
					$.ajax({
						type: \"GET\",
						url: \"ajax/service_category_search.php\", // change to full path of file on server
						dataType: \"xml\",
						//ajaxStart: function() { alert('starting'); },
						success: parseXml,
						complete: setupAC,						
						failure: function(data) {
							alert(\"XML File could not be found\");
							}
					});
				
					function parseXml(xml)
					{
						//find every query value
						$(xml).find(\"category\").each(function()
						{							
							myArr.push($(this).attr(\"label\"));
						});	
					}
					
					function setupAC() {						
						$(\"input#search_categoryname\").autocomplete({
								source: myArr,
								minLength: 1,
								select: function(event, ui) {									
									$(\"input#search_categoryname\").val(ui.item.value);									
								}
						});
					}
					
					// AUTO COMPLETE FOR ICON IN STATUS FORM
					var myArr1 = [];
	
					$.ajax({
						type: \"GET\",
						url: \"ajax/service_code_icon_browse.php\", // change to full path of file on server
						dataType: \"xml\",
						success: parseXml1,
						complete: setupAC1,
						failure: function(data) {
							alert(\"XML File could not be found\");
							}
					});
				
					function parseXml1(xml)
					{
						//find every query value
						$(xml).find(\"iconname\").each(function()
						{
							myArr1.push($(this).attr(\"label\"));
						});	
					}
					
					function setupAC1() {						
						$(\"input#servicecodeicon\").autocomplete({
								source: myArr1,
								minLength: 0,
								select: function(event, ui) {
									$(\"input#servicecodeicon\").val(ui.item.value);									
								}
						});
					}
					
					// AUTO COMPLETE FOR SERVICE IN STATUS FORM
					var myArr2 = [];
	
					$.ajax({
						type: \"GET\",
						url: \"ajax/service_master_search.php\", // change to full path of file on server
						dataType: \"xml\",
						success: parseXml2,
						complete: setupAC2,
						failure: function(data) {
							alert(\"XML File could not be found\");
							}
					});
				
					function parseXml2(xml)
					{
						//find every query value
						$(xml).find(\"service\").each(function()
						{
							myArr2.push($(this).attr(\"label\"));
						});	
					}
					
					function setupAC2() {						
						$(\"input#servicenameevent\").autocomplete({
								source: myArr2,
								minLength: 0,
								select: function(event, ui) {
									$(\"input#servicenameevent\").val(ui.item.value);									
								}
						});
					}
					
					// AUTO COMPLETE FOR SERVICE IN STATUS FORM
					var myArr3 = [];
	
					$.ajax({
						type: \"GET\",
						url: \"ajax/service_code_browse.php\", // change to full path of file on server
						dataType: \"xml\",
						success: parseXml3,
						complete: setupAC3,
						failure: function(data) {
							alert(\"XML File could not be found\");
							}
					});
				
					function parseXml3(xml)
					{
						//find every query value
						$(xml).find(\"code\").each(function()
						{
							myArr3.push($(this).attr(\"label\"));
						});	
					}
					
					function setupAC3() {						
						$(\"input#servicecodenameadd\").autocomplete({
								source: myArr3,
								minLength: 1,
								select: function(event, ui) {
									$(\"input#servicecodenameadd\").val(ui.item.value);									
								}
						});
					}
					
					var theme = \"\";

					// prepare the data
					var url = \"ajax/service_category_browse.php\";

					var source =
					{
						datatype: \"xml\",
						updaterow: function (rowid, rowdata, commit) {
							// synchronize with the server - send update command
							// call commit with parameter true if the synchronization with the server is successful 
							// and with parameter false if the synchronization failder.
							commit(true);
						},
						datafields: [
							{ name: 'CategoryID', type: 'string' },
							{ name: 'CategoryName', type: 'string' },
					   ],
						root: \"categories\",
						record: \"category\",
						url: url
					};

					var linkrenderer = function (row, column, value) {
						if (value.indexOf('#') != -1) {
							value = value.substring(0, value.indexOf('#'));
						}
						var format = { target: '\"_blank\"' };
						var html = $.jqx.dataFormat.formatlink(value, format);
						return html;
					}
					var dataAdapter = new $.jqx.dataAdapter(source);

					// Create jqxGrid.
					$(\"#jqxgrid\").jqxGrid(
					{
						width: 670,
						source: dataAdapter,
						theme: theme,
						pageable: true,
						editable: true,
						autoheight: true,
						columns: [
						  { text: 'ID', editable:false, datafield: 'CategoryID', width: 150 },
						  { text: 'Category Name', datafield: 'CategoryName', width: 450 }
					   ]
					});

					// events
					$(\"#jqxgrid\").on('cellbeginedit', function (event) {
						var args = event.args;
						$(\"#cellbegineditevent\").text(\"Event Type: cellbeginedit, Column: \" + args.datafield + \", Row: \" + (1 + args.rowindex) + \", Value: \" + args.value);
					});

					$(\"#jqxgrid\").on('cellendedit', function (event) {
						var args = event.args;
						
						var catid = $(\"#jqxgrid\").jqxGrid('getcellvalue', args.rowindex, 'CategoryID');
						$(\"#cellendeditevent\").text(\"Event Type: cellendedit, Column: \" + args.datafield + \", Row: \" + (1 + args.rowindex) + \", ID: \" + catid + \", Value: \" + args.value);
						EditCategory(catid,args.value);
					});					

					// prepare the data
					var url1 = \"ajax/service_master_browse.php\";

					var source =
					{
						datatype: \"xml\",
						updaterow: function (rowid, rowdata, commit) {
							// synchronize with the server - send update command
							// call commit with parameter true if the synchronization with the server is successful 
							// and with parameter false if the synchronization failder.
							commit(true);
						},
						datafields: [
							{ name: 'ServiceID', type: 'string' },
							{ name: 'CategoryName', type: 'string' },
							{ name: 'ServiceName', type: 'string' },
					   ],
						root: \"services\",
						record: \"service\",
						url: url1
					};

					var linkrenderer = function (row, column, value) {
						if (value.indexOf('#') != -1) {
							value = value.substring(0, value.indexOf('#'));
						}
						var format = { target: '\"_blank\"' };
						var html = $.jqx.dataFormat.formatlink(value, format);
						return html;
					}
					var dataAdapter = new $.jqx.dataAdapter(source);

					// Create jqxGrid.
					$(\"#jqxgrid1\").jqxGrid(
					{
						width: 670,
						source: dataAdapter,
						theme: theme,
						pageable: true,
						editable: true,
						autoheight: true,
						columns: [
						  { text: 'ID', editable:false, datafield: 'ServiceID', width: 150 },
						  { text: 'Category Name', editable:false, datafield: 'CategoryName', width: 250 },
						  { text: 'Service Name', datafield: 'ServiceName', width: 450 }
					   ]
					});

					// events
					$(\"#jqxgrid1\").on('cellbeginedit', function (event) {
						var args = event.args;
						$(\"#cellbegineditevent1\").text(\"Event Type: cellbeginedit, Column: \" + args.datafield + \", Row: \" + (1 + args.rowindex) + \", Value: \" + args.value);
					});

					$(\"#jqxgrid1\").on('cellendedit', function (event) {
						var args = event.args;
						
						var srvid = $(\"#jqxgrid1\").jqxGrid('getcellvalue', args.rowindex, 'ServiceID');
						$(\"#cellendeditevent1\").text(\"Event Type: cellendedit, Column: \" + args.datafield + \", Row: \" + (1 + args.rowindex) + \", ID: \" + srvid + \", Value: \" + args.value);
						EditService(srvid,args.value);
					});	
					
				});								
				
				function EditCategory(id,val) {
					$.ajax({
						type:'post',
						url:'ajax/service_category_edit.php',
						data: { categoryid: id, categoryname: val },
						beforeSend:function(){
							ShowResponse('Working...',2000);
						},
						complete:function(){
							//ShowResponse('Done...',2000);
						},
						success:function(result){
							 ShowResponse(result,2000);
						}
					});
				}
				
				function EditService(id,val) {
					$.ajax({
						type:'post',
						url:'ajax/service_master_edit.php',
						data: { serviceid: id, servicename: val },
						beforeSend:function(){
							ShowResponse('Working...',4000);
						},
						complete:function(){
							//ShowResponse('Done...',10000);
						},
						success:function(result){
							//alert(result);
							 ShowResponse(result,10000);
						}
					});
				}
				
				function ShowResponse(resp,timeout) {					
					$( \"#response\" ).text(resp).show().fadeOut(10000);	
				};
				
				function UpdateCategoryGridData() {
					$(\"#jqxgrid\").jqxGrid('updatebounddata', 'cells');
				}
			</script>
			<div id='response'>waiting</div>
			<div id='accordion'>
				<h3>Add Category</h3>
				<div>
					<p>
						<form id='formcategory'>
						Name:	<input type='text' name='categoryname' id='categoryname' value=''><br /><br />
						<input type='submit' value='Add Now'>					
						</form>
					</p>
				</div>
				
				<h3>All Categories</h3>
				<div>
					<p>
						<div id='jqxWidget'>
							<div id='jqxgrid'></div>
							<div style=\"'font-size: 12px; font-family: Verdana, Geneva, 'DejaVu Sans', sans-serif; margin-top: 10px; \">
								<div id='cellbegineditevent'></div>
								<div style=\"margin-top: 10px;\" id='cellendeditevent'></div>
						   </div>
						</div>
					</p>
				</div>
				
				<h3>Add Service</h3>
				<div>
					<p>
						<form id='formservice' action='#'>
						Category:	<input type='text' name='search_categoryname' id='search_categoryname' value=''><br /><br />
						Service Name:	<input type='text' name='servicename' value=''><br /><br />
						<input type='submit' value='Submit'>
						</form>
					</p>
				</div>
				
				<h3>All Services</h3>
				<div>
					<p>
						<div id='jqxWidget1'>
							<div id='jqxgrid1'></div>
							<div style=\"'font-size: 12px; font-family: Verdana, Geneva, 'DejaVu Sans', sans-serif; margin-top: 10px; \">
								<div id='cellbegineditevent'></div>
								<div style=\"margin-top: 10px;\" id='cellendeditevent1'></div>
						   </div>
						</div>
					</p>
				</div>
				
				<h3>Add Event</h3>
				<div>
				<p>
				<form id='formevent' action='#'>
									Service:	<input type='text' name='servicenameevent' id='servicenameevent' value=''><br /><br />
									Service Code:	<input type='text' name='codename' id='servicecodenameadd' value=''><br /><br />
									Description:	<input type='text' name='servicedesc' id='service_desc' value=''><br /><br />
									<input type='submit' value='Submit'>					
									</form>
				</p>
				</div>
				
				<h3>Add Icon</h3>
				<div>
				<p>
				<form id='formicon' action='#'>
									Short Name:	<input type='text' name='servicecodename' id='servicecodename' value=''>e.g Ok<br />
									Description:	<input type='text' name='servicecodedesc' id='servicecodedesc' value=''>e.g. Everything's looking good<br />
									Service Code Icon:	<input type='text' name='servicecodeicon' id='servicecodeicon' value=''> Search for colors e.g 'green' and select the appropriate icon<br />
									<input type='submit' value='Submit'>					
									</form>
				</p>
				</div>
				
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