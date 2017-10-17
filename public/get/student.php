<?php require_once("../../initialize.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT * FROM users WHERE user_type='student' AND (first_name LIKE '%$q%' OR other_name LIKE '%$q%' OR last_name LIKE '%$q%') ORDER BY last_name, first_name, other_name ASC";
$users = User::find_by_sql($sql);
foreach($users as $user){
	echo $user->full_name()." | ".$user->id." \n";
}
return false;
?>
<p><font color="#000000">recognize </font></p>