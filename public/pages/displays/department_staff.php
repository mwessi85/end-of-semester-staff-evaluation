<?php
if(isset($session)){
	//echo "<pre>".print_r($session, true)."</pre>"; 
}
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$total_count = User::count_all();
$pagination = new Pagination($page, $per_page, $total_count);
$sql = "SELECT * FROM staffs WHERE department = ".$department->id." ORDER BY id desc LIMIT ".$per_page." OFFSET ".$pagination->offset();
//echo $sql;
$department_staff = Staff::find_by_sql($sql);
?>

<div>
    <table class="results">
    <tr>
    <!--<th>Id</th>-->
    <th>Name</th>
    <!--<th>Username</th>-->
    <th>Email Address</th>
    <!--<th>Status</th>-->
    <th>&nbsp;</th>
    </tr>
    <?php
    $i = 1;
    foreach($department_staff as $staff): ;
	//$publications = Publication::find_all(" ORDER BY publication_date");
	$user = User::find_by_id($staff->user_id);
	?>
    
    <tr>
    <!--<td><?php //echo $i++; ?></td>-->
    <?php 
	if($staff = Staff::find_by_user_id($user->id)){?>
	<td><a href="index.php?c=staff&p=staff&user_id=<?php echo urlencode(base64_encode($user->id));?>"><?php echo $user->full_name(); ?></a></td>		
	
	<?php }
	elseif(isset($session)){?>
    <?php  
		if(Session::user_permission($user->id)){?>
			<td><a href="index.php?c=staff&p=staff&user_id=<?php echo urlencode(base64_encode($user->id));?>"><?php echo $user->full_name(); ?></a></td>
		<?php }else{;?>
				<td><?php echo $user->full_name(); ?></td>
	<?php }?>
    <?php }else{?>
    <td><?php echo $user->full_name(); ?></td>
<?php }?>

 	<!--<td><?php echo $user->username; ?></td>-->
    <td><?php echo $user->email; ?></td>
    <!--<td><?php echo $user->status; ?></td>-->
    <?php if(isset($session)){?>
		<?php 
        if(Session::user_permission($user->id)) :?>
        <td><a href="index.php?p=users&c=users&user_id=<?php echo urlencode(base64_encode($user->id));?>&edit=true">Edit</a></td>
        <?php endif?>
    <?php }?>
    </tr>
    <?php endforeach;?>
    </table>
</div>
<p></p>
<div id="pagination" style="clear:both; text-align:center;">
<?php bottom_pagination("index.php?p=users");?>
</div>