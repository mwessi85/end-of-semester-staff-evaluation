<?php 
$restricted = true;
check_restriction();
?>

<h1>Change Passsowrd</h1>  

<?php 	
user_admin_action($user_id);

require_once("forms/password.php"); 

?>