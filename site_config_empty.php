<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_DIR_' ) or die( 'Direct Access to this location is not allowed.' );

ini_set("include_path", "c:/xampp/htdocs/servicestatusnow/pear/");
/*Website URL*/
$wb="http://localhost/servicestatusnow/";
/*Website Directory*/
$dr="c:/xampp/htdocs/servicestatusnow/";

/*Database Type*/
$database_type="mysql";
/*Authentication Type*/
$authentication_type="mysql";
/*Database Server*/
$database_hostname="localhost";
/*Database Port*/
$database_port="3306";
/*Database User*/
$database_user="root";
/*Database Password*/
$database_password="root";
/*Database Name*/
$database_name="servicestatusnow";
/*Database Prefix*/
$database_prefix="servicestatusnow.";

$environment = "dev";

/*Mail Type either PHP's mail function or SMTP*/
$mail_type="smtp";
/*SMTP Server*/
$smtp_server="smtp.gmail.com";
$smtp_port=465;
$smtp_require_auth=true;
$smtp_user="yoursite@gmail.com";
$smtp_password="";

/*Who should emails be sent from?*/
$email_recover_password_from="general@yoursite.com";

/*Register email from*/
$register_email_from="general@yoursite.com";

/* OTHER CONFIG */
$register_email_subject = "[yoursite] Registration";
$register_email_body    = "Welcome %username%,
You have been registered for yoursite.com, so please activate your account by clicking here:
".$wb."activate.php?content=login&code=%code% 
%extra%
If you did not register, please ignore this email.

Regards, 
yoursite.com";
							
$forgot_email_subject = "[yoursite] Password Recovery";
$forgot_email_body    = "Hi,

Someone, perhaps you, requested your password to be recovered.
Click on this link ".$wb."index.php?content=reset&code=%code%

If you did not request this, please ignore this email. 

Regards,
yoursite.com";	

$invite_email_subject = "[yoursite] Invitation ";
$invite_email_body    = "Hi,

%friendname%, someone you may know, suggested you join yoursite.com where you can check how good your servicedesk numbers are.
Click on this link ".$wb."index.php to register and start choosing better numbers

If you do not know this person, please ignore this email.

Regards,
yoursite.com";	
?>
