<h3>
	<?php echo __('tinyissue.role') ?>s
</h3>

<div class="pad">

	<form method="post" action="">
	<?php 
	foreach($roles as $role) {
		echo $role->id.'.&nbsp;';
		echo '<input name="RoleName['.$role->id.']" type="input" size="15" maxlenght="20" value="'.$role->name.'" />';
		echo '<input name="RoleDesc['.$role->id.']" type="input" size="75" maxlenght="255" value="'.$role->description.'" />';
		echo '<a href="' . URL::to('role/' . $role->id . '/edit') . '"><label id="role' . $role->id . '" class="label"' . ($role->bgcolor ? ' style="background: ' . $role->bgcolor . '"' : '') . '>Modifier</label></a>';
		echo '<br /><br />';
	} 
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" onclick="document.location.href = 'administration';" value="<?php echo __('tinyissue.cancel'); ?>" class="button secondary" />
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" value="<?php echo __('tinyissue.roles_modify'); ?>" class="button primary" />
	</form>

</div>