<?php $positions = Position::find_all();?>
<div>
<table class="results">
<tr>
<th></th>
<th>Title</th>
<th>Category</th>
<th>&nbsp;</th>
</tr>
<?php
$i = 1;
foreach($positions as $position) : ?>
<tr>
<td><?php echo $i++; ?></td>
<!--<td><img src="../<?php //echo $photo->image_path();?>" width="100" /></td>-->
<td><?php echo titleCase($position->title); ?></td>
<td><?php echo $position->category; ?>
</td>
<td>
<?php if($session->is_admin()) :?>
<a href="index.php?c=position&p=position&edit=true&position_id=<?php echo urlencode(base64_encode($position->id));?>">Edit</a>
<?php endif ?>
</td>
<!--<td><a href="delete_position.php?id=<?php echo urlencode(base64_encode($position->id));?>">Delete</a></td>-->
</tr>
<?php endforeach;?>
</table>
<?php if($session->is_admin()) :?>
    <div><p><a href='index.php?c=position&p=position&add=true'>Add Position</a></div>
	<?php endif?>
</div>