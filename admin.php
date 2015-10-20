<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>ServiceStatusNow</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap-3.3.5-dist/css/dashboard.css" rel="stylesheet">
	    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<link rel='stylesheet' href='jqwidgets/styles/jqx.base.css' type='text/css' />						
	
	<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css' type='text/css' />						
	
	
  
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="admin.php">ServiceStatusNow Admin</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
			<form class="navbar-form navbar-right" id="enterform">
				<div class="form-group">
				  <input type="text" placeholder="userlogin" id="userlogin" name="userlogin" class="form-control">
				</div>
				<div class="form-group">
				  <input type="password" id="password" name="password" placeholder="Password" class="form-control">
				</div>
				<button type="submit" class="btn btn-success">Sign in</button>
			</form>
			</li>			
			<li id="currentuser" class="navbar-brand"></li>
			<li id="logout"><a class="navbar-brand" href="#" onClick="logout()">Logout</a></li>
            <li><a href="http://terencelegrange.com/wiki/doku.php?id=wiki:servicestatus" class="navbar-brand">Help</a></li>
          </ul>          
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#" onClick="showDiv('statusdashboard');">Dashboard<span class="sr-only">(current)</span></a></li>
			<li><a href="index.php">My Portal</a></li>
			<li><a href="#" onClick="ShowForm('add_category');">Add Category</a></li>
            <li><a href="#" onClick="ShowForm('all_category');">All Categories</a></li>
            <li><a href="#" onClick="ShowForm('add_service');">Add Service</a></li>
            <li><a href="#" onClick="ShowForm('all_services');">All Services</a></li>			
			<li><a href="#" onClick="ShowForm('add_org');">Organisation</a></li>			
			<li><a href="#" onClick="ShowForm('all_org_users');">Organisation Users</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="#" onClick="ShowForm('add_status');">Add New Status</a></li>
			<li><a href="#" onClick="ShowForm('add_service_status');">Update Service Status</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
		  <div id='response'></div>
		  <div id="statusdashboard">			  			  
		  </div>
          <div id='add_category'>
			<h3>Add Category</h3>
			<div>
				<p>
					<form id='formcategory'>
					Name:	<input type='text' name='categoryname' id='categoryname' value=''><br /><br />
					<input type='submit' value='Add Now'>					
					</form>
				</p>
			</div>
		  </div>
		<div id='all_category'>
			<h3>All Categories</h3>
			<div>
				<p>
					<div id='jqxWidget'>
						<div id='jqxgrid'></div>						
					</div>
				</p>
			</div>
		</div>
		<div id='add_service'>
			<h3>Add Service</h3>
			<div>
				<p>
					<form id='formservice' action='#'>
					Category:	<input type='text' name='search_categoryname' id='search_categoryname' value=''> (wait for drop down options or refresh page for values)<br /><br />
					Service Name:	<input type='text' name='servicename' value=''><br /><br />
					<input type='submit' value='Submit'>
					</form>
				</p>
			</div>
		</div>
		<div id='all_services'>	
			<h3>All Services</h3>
			<div>
				<p>
					<div id='jqxWidget1'>
						<div id='jqxgrid1'></div>						
					</div>
				</p>
			</div>
		</div>
		
		<div id='add_status'>	
			<h3>Add Status</h3>
			<div>
			<p>
			<form id='formicon' action='#'>
								Short Name:	<input type='text' name='servicecodename' id='servicecodename' value=''>e.g Ok<br />
								Description:	<input type='text' name='servicecodedesc' id='servicecodedesc' value=''>e.g. Everything's looking good<br />
								Service Code Icon:	<input type='text' name='servicecodeicon' id='servicecodeicon' value=''> Search for colors e.g 'green' and select the appropriate icon<br />
								Code Meaning: <select name="codemeaning"><option value="Available" />Available</option><option value="UnAvailable" />Unavailable</option><option value="Maintenance" />Maintenance</option><option value="Impacted" />Performance Impacted</option></select><br />
								<input type='submit' value='Submit'>					
								</form>
			</p>
			</div>			
		</div>
		<div id='add_org'>
			<h3>Add Organisation</h3>
			<div>
				<p>
					<form id='formaddorg'>
					Organisation Name:	<input type='text' name='organisationname' id='organisationname' value=''><br /><br />
					<input type='submit' value='Add Now'>					
					</form>
				</p>
			</div>
		  </div>
		<div id='all_org_users'>
			<h3>All Organisation Users</h3>
			<div>
				<p>
					<div id='jqxWidget2'>
						<div id='jqxgrid2'></div>						
					</div>
				</p>
			</div>
		</div>		
		<div id='add_service_status'>	
			<h3>Add Service Status</h3>
			<div>
			<p>
			<form id='formservicestatus' action='#'>
								Service:	<input type='text' name='servicenamestatus' id='servicenamestatus' value=''>Type to see list<br />
								Description:	<input type='text' name='servicecode' id='servicecode' value=''>Type to see list<br />
								Comments:	<input type='text' name='servicedesc' id='servicedesc' value=''>Enter free text<br />								
								<input type='submit' value='Submit'>					
								</form>
			</p>
			</div>			
		</div>
		
        </div>
      </div>
    </div>
	
	
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script type='text/javascript' src='jqwidgets/jqxcore.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxdata.js'></script> 
	<script type='text/javascript' src='jqwidgets/jqxbuttons.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxscrollbar.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxmenu.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxgrid.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxgrid.edit.js'></script>  
	<script type='text/javascript' src='jqwidgets/jqxgrid.selection.js'></script> 
	<script type='text/javascript' src='jqwidgets/jqxlistbox.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxdropdownlist.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxcheckbox.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxcalendar.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxnumberinput.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxdatetimeinput.js'></script>
	<script type='text/javascript' src='jqwidgets/globalization/globalize.js'></script>
	<script type='text/javascript' src='jqwidgets/scripts/gettheme.js'></script>
	<script type='text/javascript' src='jqwidgets/generatedata.js'></script>
	<script type='text/javascript' src='jqwidgets/jqxgrid.pager.js'></script> 
	<script>
	var forms = ["add_category", "all_category", "add_service", "all_services", "add_event", "add_status", "add_org", "all_org_users", "add_service_status"];
	getUsername();
	function HideOthers(current) {
		for (i=0;i<forms.length;i++) {
			if (current != forms[i]) {
				$("#"+forms[i]).hide();
			}
		}
	}
	function ShowForm(form) {
		$("#"+form).show();
		HideOthers(form);
		hideDiv("statusdashboard");
	}
	
	$(document).ready(function() {
		
		console.log('loaded doc');
		for (i=0;i<forms.length;i++) {
			$("#"+forms[i]).hide();
		}
		statusDashboard();
	});
	
	function hideDiv(div) {
		$("#"+div).hide();
	}
	
	function showDiv(div) {		
		$("#"+div).show();
		HideOthers(div);
	}
	
	function getUsername() {
		
		$.ajax({
			type:'get',
			url:'ajax/getusername.php',				
			beforeSend:function(){
				//ShowResponse('Working...',2000);
			},
			complete:function(){
				//ShowResponse('Done...',2000);
			},
			success:function(result){
				//alert(result);
				 $("#currentuser").html(result);
				 if (result == "Welcome, Guest") {
					showDiv("enterform");
					hideDiv("logout");
					statusDashboard();
				 }
				 else {
					hideDiv("enterform");
					showDiv("logout");
					statusDashboard();
				 }
			}
		});
	}
	
	function logout() {
		
		$.ajax({
			type:'get',
			url:'ajax/logout.php',							
			success:function(result){
				getUsername();
				statusDashboard();
				showDiv("enterform")
				hideDiv("logout")
			}
		});
	}
	
	function statusDashboard() {
		
		$.ajax({
			type:'get',
			url:'ajax/dash1.php?r=<?php echo rand(1000,99999);?>',				
			beforeSend:function(){
				//ShowResponse('Working...',2000);
			},
			complete:function(){
				//ShowResponse('Done...',2000);
			},
			success:function(result){
				//alert(result);
				 $("#statusdashboard").html(result);				 
			}
		});
	}
	
	$(function() {
		//$( "#accordion" ).accordion({heightStyle: 'content'});
		
		$('#enterform').submit(function(e) {
			e.preventDefault();
			var a=$('#enterform').serialize();
			$.ajax({
				type:'post',
				url:'ajax/core_user_login.php',
				data:a,
				beforeSend:function(){
					ShowResponse('Working...',2000);
				},
				complete:function(){
					//ShowResponse('Done...',2000);
				},
				success:function(result){					
					 ShowResponse(result,10000);					 
					 getUsername();
				}
			});
		});		
		
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
					 statusDashboard();
				}
			});
		});
		
		$('#formservicestatus').submit(function(e) {			
			e.preventDefault();
			var a=$('#formservicestatus').serialize();
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
					 statusDashboard();
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
		
		$('#formaddorg').submit(function(e) {
			e.preventDefault();
			var a=$('#formaddorg').serialize();
			$.ajax({
				type:'post',
				url:'ajax/core_organisation_master_add.php',
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
		
		
		// AUTO COMPLETE FOR CATEGORY IN ADD CATEGORY FORM
		var myArr = [];

		$.ajax({
			type: "GET",
			url: "ajax/service_category_search.php", // change to full path of file on server
			dataType: "xml",
			//ajaxStart: function() { alert('starting'); },
			
			success: parseXml,
			complete: setupAC,						
			failure: function(data) {
				alert("XML File could not be found");
			}
			
		});

		function parseXml(xml)
		{
			//find every query value			
			$(xml).find("category").each(function()
			{							
				myArr.push($(this).attr("label"));
			});			
		}
		
		function setupAC() {
			
			$("input#search_categoryname").autocomplete({
					source: myArr,
					minLength: 1,
					select: function(event, ui) {									
						$("input#search_categoryname").val(ui.item.value);									
					}
			});
		}
		
		// AUTO COMPLETE FOR ICON IN STATUS FORM
		var myArr1 = [];

		$.ajax({
			type: "GET",
			url: "ajax/service_code_icon_browse.php", // change to full path of file on server
			dataType: "xml",
			success: parseXml1,
			complete: setupAC1,
			failure: function(data) {
				alert("XML File could not be found");
				}
		});

		function parseXml1(xml)
		{
			//find every query value
			$(xml).find("iconname").each(function()
			{
				myArr1.push($(this).attr("label"));
			});	
		}
		
		function setupAC1() {						
			$("input#servicecodeicon").autocomplete({
					source: myArr1,
					minLength: 0,
					select: function(event, ui) {
						$("input#servicecodeicon").val(ui.item.value);									
					}
			});
		}
		
		// AUTO COMPLETE FOR SERVICE IN STATUS FORM
		var myArr2 = [];

		$.ajax({
			type: "GET",
			url: "ajax/service_master_search.php?r=<?php echo rand(1000,99999);?>", // change to full path of file on server
			dataType: "xml",
			success: parseXml2,
			complete: setupAC2,
			failure: function(data) {
				alert("XML File could not be found");
				}
		});

		function parseXml2(xml)
		{
			//find every query value
			$(xml).find("service").each(function()
			{
				myArr2.push($(this).attr("label"));
			});	
		}
		
		function setupAC2() {						
			$("input#servicenameevent").autocomplete({
					source: myArr2,
					minLength: 0,
					select: function(event, ui) {
						$("input#servicenameevent").val(ui.item.value);									
					}
			});
		}
		
		// USE SAME SERVICE STATUS FOR UPDATING A NEW STATUS
		function setupAC2() {						
			$("input#servicenamestatus").autocomplete({
					source: myArr2,
					minLength: 0,
					select: function(event, ui) {
						$("input#servicenamestatus").val(ui.item.value);									
					}
			});
		}
		
		// AUTO COMPLETE FOR SERVICE IN STATUS FORM
		var myArr3 = [];

		$.ajax({
			type: "GET",
			url: "ajax/service_code_browse.php", // change to full path of file on server
			dataType: "xml",
			success: parseXml3,
			complete: setupAC3,
			failure: function(data) {
				alert("XML File could not be found");
				}
		});

		function parseXml3(xml)
		{
			//find every query value
			$(xml).find("code").each(function()
			{
				myArr3.push($(this).attr("label"));
			});	
		}
		
		function setupAC3() {						
			$("input#servicecodenameadd").autocomplete({
					source: myArr3,
					minLength: 1,
					select: function(event, ui) {
						$("input#servicecodenameadd").val(ui.item.value);									
					}
			});
		}
		
		// USE THE ABOVE CODES FOR ADDING A NEW SERVICE STATUS
		function setupAC3() {						
			$("input#servicecode").autocomplete({
					source: myArr3,
					minLength: 0,
					select: function(event, ui) {
						$("input#servicecode").val(ui.item.value);									
					}
			});
		}
		
		var theme = "";

		// prepare the data
		var url = "ajax/service_category_browse.php";

		var source =
		{
			datatype: "xml",
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
			root: "categories",
			record: "category",
			url: url
		};

		var linkrenderer = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
			return html;
		}
		var dataAdapter = new $.jqx.dataAdapter(source);

		// Create jqxGrid.
		$("#jqxgrid").jqxGrid(
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
		$("#jqxgrid").on('cellbeginedit', function (event) {
			var args = event.args;
			$("#cellbegineditevent").text("Event Type: cellbeginedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
		});

		$("#jqxgrid").on('cellendedit', function (event) {
			var args = event.args;
			
			var catid = $("#jqxgrid").jqxGrid('getcellvalue', args.rowindex, 'CategoryID');
			$("#cellendeditevent").text("Event Type: cellendedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", ID: " + catid + ", Value: " + args.value);
			EditCategory(catid,args.value);
			UpdateCategoryGridData();
		});					

		// prepare the data
		var url1 = "ajax/service_master_browse.php?r=<?php echo rand(1000,99999);?>";

		var source =
		{
			datatype: "xml",
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
			root: "services",
			record: "service",
			url: url1
		};

		var linkrenderer = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
			return html;
		}
		var dataAdapter = new $.jqx.dataAdapter(source);
				
		// Create jqxGrid1.
		$("#jqxgrid1").jqxGrid(
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
			  { text: 'Service Name', datafield: 'ServiceName', width: 250 }
		   ]
		});

		// events
		$("#jqxgrid1").on('cellbeginedit', function (event) {
			var args = event.args;
			$("#cellbegineditevent1").text("Event Type: cellbeginedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
		});

		$("#jqxgrid1").on('cellendedit', function (event) {
			var args = event.args;
			
			var srvid = $("#jqxgrid1").jqxGrid('getcellvalue', args.rowindex, 'ServiceID');
			$("#cellendeditevent1").text("Event Type: cellendedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", ID: " + srvid + ", Value: " + args.value);
			EditService(srvid,args.value);
		});
		
		// BROWSE ORG USERS
		// prepare the data
		var url = "ajax/core_organisation_users_browse.php";

		var source =
		{
			datatype: "xml",
			updaterow: function (rowid, rowdata, commit) {
				// synchronize with the server - send update command
				// call commit with parameter true if the synchronization with the server is successful 
				// and with parameter false if the synchronization failder.
				commit(true);
			},
			datafields: [
				{ name: 'UserID', type: 'string' },
				{ name: 'FullName', type: 'string' },
				{ name: 'OrganisationName', type: 'string' },
		   ],
			root: "users",
			record: "user",
			url: url
		};

		var linkrenderer = function (row, column, value) {
			if (value.indexOf('#') != -1) {
				value = value.substring(0, value.indexOf('#'));
			}
			var format = { target: '"_blank"' };
			var html = $.jqx.dataFormat.formatlink(value, format);
			return html;
		}
		var dataAdapter = new $.jqx.dataAdapter(source);
		
		// Create jqxGrid2.
		$("#jqxgrid2").jqxGrid(
		{
			width: 670,
			source: dataAdapter,
			theme: theme,
			pageable: true,
			editable: true,
			autoheight: true,
			columns: [
			  { text: 'ID', editable:false, datafield: 'UserID', width: 150 },
			  { text: 'Full Name', editable:false, datafield: 'FullName', width: 250 },
			  { text: 'Organisation Name', editable:false, datafield: 'OrganisationName', width: 350 }
		   ]
		});

		// events
		$("#jqxgrid2").on('cellbeginedit', function (event) {
			var args = event.args;
			$("#cellbegineditevent2").text("Event Type: cellbeginedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
		});

		$("#jqxgrid1").on('cellendedit', function (event) {
			var args = event.args;
			
			var srvid = $("#jqxgrid2").jqxGrid('getcellvalue', args.rowindex, 'UserID');
			$("#cellendeditevent2").text("Event Type: cellendedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", ID: " + srvid + ", Value: " + args.value);
			//EditService(srvid,args.value);
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
		$( "#response" ).text(resp).show().fadeOut(10000);	
	};

	function UpdateCategoryGridData() {		
		$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		$("#jqxgrid1").jqxGrid('updatebounddata', 'cells');
		$("#jqxgrid2").jqxGrid('updatebounddata', 'cells');
	}
	</script>
	
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap-3.3.5-dist/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>