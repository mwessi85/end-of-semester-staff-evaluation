<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM departments WHERE name LIKE '%$q%' ORDER BY name ASC";
$departments = Department::find_by_sql($sql);
foreach($departments as $department){
	echo $department->name." | ".$department->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>