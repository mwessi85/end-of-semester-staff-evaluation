<?php 
$update = Input::get('update');
$respondent_id = urldecode(base64_decode(Input::get('respondent_id')));
?>

<!--<h1>System Users</h1>  -->


<?php 
require_once("displays/students_completion.php");	
?>