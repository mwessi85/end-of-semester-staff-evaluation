<?php require_once("../initialize.php");?>
<?php 
//$restricted = false; 
?>
<?php
$control_dir = "controllers";

if(isset($_GET['logout'])){
	include($control_dir."/logout.inc.php");	
}
if(!empty($_GET['c'])){
	$c = $_GET['c'];
	//echo $c;
	if($c != 'users' && $c != 'login'){
		if(!isset($session->user_id)){
			redirect_to("index.php?logout=true");	
		}
	}
	
	$controllers = scandir($control_dir, 0);
	unset($controllers[0], $controllers[1]);
	if(in_array($c.".inc.php", $controllers)){
		include($control_dir."/".$c.".inc.php");
	}else{
		header("location: index.php");	
	}
}
?>
<?php include("includes/header.php");?>
<div><?php echo output_message($message);?></div>   
<?php 
$pages_dir = "pages";
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;

if(!empty($_GET['p'])){
	$p = $_GET['p'];
	$pages = scandir($pages_dir, 0);
	unset($pages[0], $pages[1]);
	if(in_array($p.".inc.php", $pages)){
		include($pages_dir."/".$p.".inc.php");
	}else{
		echo "Sorry Page not found";	
	}
}else{
	include($pages_dir."/default.inc.php");	
}
?>

<?php include("includes/footer.php");?>