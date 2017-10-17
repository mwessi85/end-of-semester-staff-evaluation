<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <link rel='stylesheet' href='css/jquery.autocomplete.css' type='text/css' />
    <script type="text/javascript" src="js/jquery.js"></script>
	<script type='text/javascript' src='js/jquery.autocomplete.js'></script>
    <script type='text/javascript' src='js/get.js'></script>
    <script type="text/javascript" src="js/canvasjs.min.js"></script></head>
    <title>Course Evaluation</title>
    <script language=javascript type='text/javascript'>
		<!--
			function areYouSure (msg) {
				var bool = window.confirm(msg);
				return bool;
			}
		-->
</script>	
</head>
<body 	
<section> 
	<header>
        <h1 id="title">Course Evaluation</h1>
    </header>
    <article>
    <div style="text-align:right;">
	<?php 
	if(isset($session->session_no)){
		show_logout($session->user_id);
	}
	?>
    </div>