<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <script type="text/javascript" src="js/jquery.js"></script>
	<script type='text/javascript' src='js/jquery.autocomplete.js'></script>
    <script type='text/javascript' src='js/get.js'></script>
    <title>Staff System</title>	
</head>
<body>
<section id="content"> 
    <header>Staff System</header>
    <article class="content">
    <div style="text-align:right;">
	<?php 
	if(isset($_SESSION['st_user_id'])){
		show_logout($_SESSION['st_user_id']);
	}
	?>
    </div>
       	