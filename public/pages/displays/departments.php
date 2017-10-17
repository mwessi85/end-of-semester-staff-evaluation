<?php if(isset($departments)){ ?>
<div>
<form method="post" action="index.php?p=departments" autocomplete="off">
    <fieldset>
        <legend>Search Academic Unit</legend>
    <p>
        <label for="make">Name: </label>
        <input type="search" name="name" id="name" placeholder="Enter name or part of name and click search" autofocus="autofocus">
        
        <input type="submit" name="search" value="Search">
    </p>
    </fieldset>
</form>
</div>
<div style="width: 830px; float: left; margin-right: 5%; clear:both; border: 0px solid #666;">
<table class="results">
<tr>
<th>Academic Units</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>
<?php
$i = 1;
foreach($departments as $department) : ?>
<?php 
$user = User::find_by_id($department->head);
if(isset($user->id)){
	$staff = Staff::find_by_user_id($user->id);
	if($staff->id){
		$title = Title::find_by_id($staff->title);
		$position = Position::find_by_id($staff->position);
		$head_title = $title->title.". ".$user->full_name()." (".$position->title.")";
	}
}

 ?>
<tr>
<td><a href="index.php?c=department&p=department&department_id=<?php echo urlencode(base64_encode($department->id));?>" title="<?php echo isset($head_title) ? "Head: ".$head_title : "";?>"><?php echo titleCase($department->name); ?></a></td>
<?php if($session->is_admin()) :?>
<td><a href="index.php?c=department&p=departments&edit=true&department_id=<?php echo urlencode(base64_encode($department->id));?>">Edit</a></td>
<td><a href="index.php?c=csv_download&p=departments&download=true&department_id=<?php echo urlencode(base64_encode($department->id));?>">Download</a></td>
<?php endif ?>

<!--<td><a href="delete_department.php?id=<?php echo urlencode(base64_encode($department->id));?>">Delete</a></td>-->
</tr>
<?php endforeach;?>
</table>
<?php if($session->is_admin()) :?>
    <div><p><a href='index.php?c=department&p=departments&add=true'>Add Department</a></div>
	<?php endif?>
</div>
<?php  }else if(isset($query)){
?>
<div>
<table class="results">
<tr>
<th>Academic Units</th>
</tr>
<?php
$i = 1;
while($row = $query->fetch(PDO::FETCH_ASSOC)) {?>
<?php 
$department = Department::find_by_id($row['department']);
 ?>
<tr>
<td><a href='index.php?c=department&p=department&department_id=<?php echo urlencode(base64_encode($row['department'])); ?>'>
<?php echo $department->name; ?>&nbsp;(<?php echo $row['count']; ?>)</a></td>

<?php if($session->is_admin()) :?>
<td><a href="index.php?c=department&p=departments&edit=true&department_id=<?php echo urlencode(base64_encode($row['department']))?>">Edit</a></td>
<?php endif ?>

<!--<td><a href="delete_department.php?id=<?php echo urlencode(base64_encode($row['author']));?>">Delete</a></td>-->
</tr>
<?php };?>
</table>
<?php if($session->is_admin()) :?>
    <div><p><a href='index.php?c=department&p=departments&add=true'>Add Department</a></div>
	<?php endif?>
</div>
<?php }?>