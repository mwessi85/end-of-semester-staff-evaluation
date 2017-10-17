<?php
if(isset($session)){
	//echo "<pre>".print_r($session, true)."</pre>"; 
}
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 30;
$total_count = User::count_all(" WHERE user_type = 'staff'");
$pagination = new Pagination($page, $per_page, $total_count);
if(isset($_POST['name'])){
	$condition = " AND (first_name LIKE '%".$_POST['name']."%' OR last_name like  '%".$_POST['name']."%'  OR other_name like  '%".$_POST['name']."%') ";
}else{
	$condition = "";	
}
$sql = "SELECT * FROM users WHERE user_type = 'staff'".$condition."ORDER BY id desc LIMIT ".$per_page." OFFSET ".$pagination->offset();
$users = User::find_by_sql($sql);
?>
<div>
    <form method="post" action="index.php?p=users" autocomplete="off">
        <fieldset>
            <legend>Search staff</legend>
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
    <!--<th>Id</th>-->
    <th>Name</th>
    <!--<th>Username</th>-->
    <th>Email Address</th>
    <!--<th>Status</th>-->
    <th>&nbsp;</th>
    </tr>
    <?php
    $i = 1;
	if($users){
    foreach($users as $user){?>
    <tr>
    <!--<td><?php //echo $i++; ?></td>-->
    <?php 
	if($staff = Staff::find_by_user_id($user->id)){?>
	<td><a href="index.php?c=staff&p=staff&user_id=<?php echo urlencode(base64_encode($user->id));?>"><?php echo $user->full_name(); ?></a></td>		
	
	<?php }
	elseif(isset($session)){?>
    <?php  
		if($staff = Student::find_by_user_id($user->id)){?>
	<td><a href="index.php?c=student&p=student&user_id=<?php echo urlencode(base64_encode($user->id));?>"><?php echo $user->full_name(); ?></a></td>		
	
	<?php }elseif(Session::user_permission($user->id)){?>
			<td><a href="index.php?c=staff&p=staff&user_id=<?php echo urlencode(base64_encode($user->id));?>"><?php echo $user->full_name(); ?></a></td>
		<?php }
		else{;?>
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
    <?php }
	}?>
    </table>
</div>
    <?php if(isset($session)){?>
		<?php if($session->session_no == Session::session_no(1)) :?>
        <div><p><a href='index.php?c=users&p=users&add=true'>Add User</a></div>
        <?php endif?>
    <?php }?>

<p></p>
<div id="pagination" style="clear:both; text-align:center;">
<?php bottom_pagination("index.php?p=users");?>
</div>