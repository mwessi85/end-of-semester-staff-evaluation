<?php
if(isset($session)){
	$session->logout();
}	
redirect_to("index.php");
?>
