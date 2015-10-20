<?php 
define( '_VALID_DIR_', 1 );

require "config.php";
/*
require "classes/stats.php";

$stats = new Stats;
if (!ISSET($_SESSION['userid'])) { 	
	$orgid = "1";
}
else {
	$orgid = $GLOBALS['user']->GetVar("OrganisationID");
}
$stats->SetVar("orgid",$orgid);
echo "UserID:".$_SESSION['userid']."<br />";
*/

?>
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

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap-3.3.5-dist/css/dashboard.css" rel="stylesheet">
	<link href="bootstrap-3.3.5-dist/css/trafficlight.css" rel="stylesheet">
    
	 <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization',
       'version':'1','packages':['timeline']}]}"></script>
<script type="text/javascript">

</script>
	
  </head>

<body>
<div id="alert" style="visibility:hidden" class="alert alert-danger fade in">
        
 </div>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Welcome to ServiceStatusNow</a>
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
				<button type="submit" class="btn btn-success">Register/Sign in</button>
			</form>
			</li>			
			<li id="currentuser" class="navbar-brand"></li>
			<li id="logout"><a class="navbar-brand" href="#" onClick="logout()">Logout</a></li>
			<li id="admin"><a class="navbar-brand" href="admin.php">Admin</a></li>
            <li><a href="http://terencelegrange.com/wiki/doku.php?id=wiki:servicestatus" class="navbar-brand">Help</a></li>
          </ul>          
        </div>
      </div>
    </nav>
	
    <div class="container" style='text-align:center'>
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
			<center><h3><span id="systemhealth"></span></h3></center>
			<div id="light">				
				<span id="green"></span>
			</div>			
        </div>
        <div class="col-md-4">
          <center>
		  <h3>SLA's</h3>
		  <div id="chart_div" style="width: 400px; height: 120px;"></div>		  
		  </center>
       </div>
		<div class="col-md-4">
			<h3>Recent outages</h3>
			<div id="recentoutages"></div>			
        </div>
      </div>
	</div>
      
	<div class="container">
		<div class="row">
			<div class="item" style="height: 400px;">
				<div id="statusdashboard"></div>
			</div>	
		</div>
	</div>
	<div class="container">
      <footer>      
      </footer>
	</div>    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script>
	function showAlert(msg,type,fade) {
		$("#alert").html(msg).show();
		msg = "<img src='images/"+type+".png'>"+msg;
		msg = msg + "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
		$("#alert").css("visibility","visible");
		if (fade) {
			$("#alert").html(msg);
		}
		else {
			$("#alert").html(msg).fadeOut(5000);
		}
		
	}
	getUsername();
	getRecentOutages();
	statusDashboard();
	getSystemHealth();
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
					//alert("*"+result+"*");					
					if (result == "9 - Failed to login") {		
						showAlert("Failed to login","error",false);						
					}
					
					showAlert(result,"success",true);
					getUsername();
					getRecentOutages();
					statusDashboard();
					getSystemHealth();
					getSLACurrentYear();						
					
				}
			});
		});	
	});	
	function hideDiv(div) {
		$("#"+div).hide();
	}
	
	function showDiv(div) {		
		$("#"+div).show();		
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
					hideDiv("admin");
				 }
				 else {
					hideDiv("enterform");					
					showDiv("logout");
					showDiv("admin");
				 }
			}
		});
	}
	function getSystemHealth() {
		
		$.ajax({
			type:'get',
			url:'ajax/service_status_group_meaning.php',				
			beforeSend:function(){
				//ShowResponse('Working...',2000);
			},
			complete:function(){
				//ShowResponse('Done...',2000);
			},
			success:function(result){
				//alert(result);
				 if (result == "1") {					
					$("#systemhealth").html("All Ok");	
					$("#green").css("background-color","green");
				 }
				 else {
					$("#systemhealth").html("System Issues");
					$("#green").css("background-color","yellow");
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
				getRecentOutages();
				statusDashboard();
				getSystemHealth();
				getSLACurrentYear();
				showDiv("enterform")
				hideDiv("logout")
			}
		});
	}
	function ShowResponse(resp,timeout) {					
		$( "#response" ).text(resp).show().fadeOut(10000);	
	};
	function getRecentOutages() {
		
		$.ajax({
			type:'get',
			url:'ajax/service_status_recent10.php?r=<?php echo rand(1000,99999);?>',				
			beforeSend:function(){
				//ShowResponse('Working...',2000);
			},
			complete:function(){
				//ShowResponse('Done...',2000);
			},
			success:function(result){
				//alert(result);
				//alert(result);
				 $("#recentoutages").html(result);				 
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
	function getSLACurrentYear() {
		
		$.ajax({
			type:'get',
			url:'ajax/service_sla_current_year.php?r=<?php echo rand(1000,99999);?>',				
			beforeSend:function(){
				//ShowResponse('Working...',2000);
			},
			complete:function(){
				//ShowResponse('Done...',2000);
			},
			success:function(result){
				//alert(result);				
				 UpdateChart(result);
			}
		});
	}
	
	google.load("visualization", "1", {packages:["gauge"]});
	google.setOnLoadCallback(drawChart);
	//getSLA("year");
	var chart;
	var data;
	var options;
	function drawChart() {
				
		data = google.visualization.arrayToDataTable([
			  ['Label', 'Value'],
			  ['Year',0]
			]);

		
		options = {
		  width: 400, height: 120,
		  redFrom: 0, redTo: 95,
		  yellowFrom:96, yellowTo: 100,
		  minorTicks: 1
		};

		chart = new google.visualization.Gauge(document.getElementById('chart_div'));
		
		//data.setValue(0, 1, 99);
		chart.draw(data, options);
		
		//refreshData();	

	}
	function UpdateChart(val) {
		data.setValue(0, 1, val);
		chart.draw(data, options);
	}	
	
	</script>
		
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap-3.3.5-dist/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
