<?php $titles = Title::find_all();?>
<div>
<table class="results">
<tr>
<th></th>
<th>Title</th>
<th>&nbsp;</th>
</tr>
<?php //foreach($users as $user) : 
$i = 1;
foreach($titles as $title) : ?>
<?php
//$user = User::find_by_id($title->head);
?>
<tr>
<td><?php echo $i++; ?></td>
<!--<td><img src="../<?php //echo $photo->image_path();?>" width="100" /></td>-->
<td><?php echo titleCase($title->title); ?></td>

<td>
<?php if($session->is_admin()) :?>
<a href="index.php?c=title&p=title&edit=true&title_id=<?php echo urlencode(base64_encode($title->id));?>">Edit</a>
<?php endif ?>
</td>
<!--<td><a href="delete_title.php?id=<?php echo urlencode(base64_encode($title->id));?>">Delete</a></td>-->
</tr>
<?php endforeach;?>
</table>
<?php if($session->is_admin()) :?>
    <div><p><a href='index.php?c=title&p=title&add=true'>Add Title</a></div>
	<?php endif?>
</div>