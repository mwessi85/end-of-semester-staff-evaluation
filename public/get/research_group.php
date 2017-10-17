<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM research_groups WHERE name LIKE '%$q%' ORDER BY name ASC";
$research_groups = Research_group::find_by_sql($sql);
foreach($research_groups as $research_group){
	echo $research_group->name." | ".$research_group->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>