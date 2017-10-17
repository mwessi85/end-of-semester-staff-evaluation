<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM programs WHERE name LIKE '%$q%' ORDER BY name ASC";
$programs = Program::find_by_sql($sql);
foreach($programs as $program){
	$program_code =  $program->code." - ";
	echo $program->name." | ".$program->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>