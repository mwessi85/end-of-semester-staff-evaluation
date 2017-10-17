<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM course_units WHERE name LIKE '%$q%' ORDER BY name ASC";
$course_units = Course_unit::find_by_sql($sql);
foreach($course_units as $course_unit){
	$code = strtoupper($course_unit->code).": ";
	echo $course_unit->name." | ".$course_unit->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>