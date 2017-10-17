<?php 
$phones = Phone::find_by_user_id($user_id);
$user = User::find_by_id($user_id);

?>
<div>
<table class="results">
<tr>
<th></th>
<th>Phone</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>
<?php //foreach($users as $user) : 


if($phones = Phone::find_all_by_user_id($user_id)){
$user = User::find_by_id($user_id);
$i = 1;
foreach($phones as $phone) : 
//echo "<pre>".$phone->id."</pre>";
?>
<tr>
<td><?php echo $i++; ?></td>
<!--<td><img src="../<?php //echo $photo->image_path();?>" width="100" /></td>-->
<td><?php echo $phone->phone_number(); ?></td>
<td><a href="phone.php?phone_id=<?php echo urlencode(base64_encode($phone->id));?>&edit=1"><?php action("Edit");?></a></td>
<td><a href="delete_phone.php?id=<?php echo urlencode(base64_encode($phone->id));?>&user_id=<?php echo urlencode(base64_encode($phone->user_id));?>"><?php action("Delete");?></a></td>
</tr>
<?php endforeach;?>
<?php }?>
</table>
</div>
<div>
<p><a href="staff.php?user_id=<?php echo urlencode(base64_encode($user_id));?>">Back</a></p>
</div>