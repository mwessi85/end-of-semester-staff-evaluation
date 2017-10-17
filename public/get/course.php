<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM courses WHERE name LIKE '%$q%' ORDER BY name ASC";
$courses = Course::find_by_sql($sql);
foreach($courses as $course){
	echo $course->name."|".$course->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>