<?php $programs = Program::find_all();?>
<div>
<table class="results">
<tr>
<th></th>
<th>Title</th>
<th>Code</th>
<th>&nbsp;</th>
</tr>
<?php
$i = 1;
foreach($programs as $program) : ?>
<tr>
<td><?php echo $i++; ?></td>
<!--<td><img src="../<?php //echo $photo->image_path();?>" width="100" /></td>-->
<td><?php echo titleCase($program->name); ?></td>
<td><?php echo $program->code; ?>
</td>
<td>
<?php if($session->is_admin()) :?>
<a href="index.php?c=program&p=program&edit=true&program_id=<?php echo urlencode(base64_encode($program->id));?>">Edit</a>
<?php endif ?>
</td>
<!--<td><a href="delete_program.php?id=<?php echo urlencode(base64_encode($program->id));?>">Delete</a></td>-->
</tr>
<?php endforeach;?>
</table>
<?php if($session->is_admin()) :?>
    <div><p><a href='index.php?c=program&p=program&add=true'>Add Program</a></div>
	<?php endif?>
</div>