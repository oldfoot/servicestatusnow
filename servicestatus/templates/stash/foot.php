<?php
//define( '_VALID_DIR_', 1 );
//require_once "../../config.php";
if (ISSET($_SESSION['userid'])) {
	$user = $GLOBALS['user'];
	$orgid = $user->GetVar("OrganisationID");
	$apicode = $user->GetVar("APIAuthCode");
}
else {
	$orgid = 1;
	$apicode = "a42e21b8add8b4bc03c62d5bbdbaa2ef";
}
?>
<div id="legend" style="border:1px solid gray">
	<h4> Status Legend </h4>
	<ul>
	<?php

	$sql = "call sp_service_code_browse('".$apicode."',$orgid)";				
	$result = $GLOBALS['db']->Query($sql);


	if ($result && $GLOBALS['db']->NumRows($result) > 0) {
		while($row = $GLOBALS['db']->FetchArray($result)) {	
  
	?>    
    <li>
      <img src="images/servicestatus/<?php echo $row['CodeIcon'];?>" alt="<?php echo $row['CodeDesc'];?>"><?php echo $row['CodeDesc'];?>
    </li>
    <?php
		}
	}
	?>    
  </ul>
</div>
      </div>
      
    </div>
    
    
    
  </body>
</html>
