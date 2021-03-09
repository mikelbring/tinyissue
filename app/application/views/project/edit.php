<?php
	$Rol = \DB::table('roles')->order_by('id','ASC')->get();
	$roles = array();
	foreach($Rol as $R) {
		$roles[$R->id] = $R->name;
	}
?>
<h3>
	<?php if (Auth::user()->role_id != 1) { ?>
   	<a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo __('tinyissue.new_issue');?>
   <?php } ?> 

	<?php echo __('tinyissue.update'); ?> <em><?php echo Project::current()->name; ?></em>
	<span><?php echo __('tinyissue.update_project_description'); ?></span>
</h3>


<div class="pad">
			<h3>
			<?php echo __('tinyissue.thisproject_members'); ?>
			</h3>
	<table class="form" style="width: 50%;">
		<th class="project-user"><?php echo __('__tinyissue.name'); ?></th>
		<th class="project-user"><?php echo __('__tinyissue.role'); ?></th>
		<th class="project-user">&nbsp;</th>
		
		<?php foreach(Project::current()->users()->get() as $row): ?>
			<tr id="project-user_<?php echo $row->id; ?>">
				<td width="70%" class="project-user"><?php echo $row->firstname . ' ' . $row->lastname; ?></td>
				<td width="20%" class="project-user"><?php echo $roles[$row->role_id]; ?></td>
				<td width="10%" class="project-user">
					<?php if(Auth::user()->permission('project-modify') && count(Project::current()->users()->get())  > 1): ?>
					<a href="javascript:void(0);" onclick="remove_project_user(<?php echo $row->id; ?>, <?php echo Project::current()->id; ?>, '<?php echo __('tinyissue.ProjSuppMbre'); ?>', 'page');" class="delete"><?php echo __('tinyissue.remove');?></a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr id="page-users"></tr>
	</table>
	<br />

<?php if(Auth::user()->permission('project-modify')): ?>
	<div style="width: 50%;">
	<input type="text" id="add-user-project" placeholder="<?php echo __('tinyissue.assign_a_user');?>" onkeyup="if(this.value.length > 2) { propose_project_user(this.value, <?php echo Project::current()->id; ?>, 'page'); }" style="margin-left: 0; border-color: grey; border-style: solid; border-width: 3px;" />
	</div>
	<div id="projetProsedNamesPage" class="projetProsedNamesPage">
	</div>
<?php endif; ?>

</div>

<div class="pad"><h3><?php echo __('tinyissue.thisproject_details'); ?></h3></div>

<?php
	$project_WebLnks = \DB::table('projects_links')->where('id_project', '=', $project->id)->order_by('category','ASC')->get();
	$WebLnk = array();
	foreach($project_WebLnks as $WebLnks) { 
		if (trim($WebLnks->desactivated) == '') { $WebLnk[$WebLnks->category] = $WebLnks->link; } 
	}
?>

<div class="pad">

	<form method="post" action="">

		<table class="form" style="width: 80%;">
			<tr>
				<th style="width: 10%;"><?php echo __('tinyissue.name'); ?></th>
				<td><input type="text" style="width: 98%;" name="name" value="<?php echo Input::old('name', Project::current()->name); ?>" /></td>
			</tr>
			<tr>
				<th><?php echo __('tinyissue.status') ?></th>
				<td><?php echo Form::select('status', array(1 => __('tinyissue.active'), 0 => __('tinyissue.archived')), Project::current()->status); ?></td>
			</tr>
			<tr>
			<th><?php echo __('tinyissue.default_assignee'); ?></th>
				<td>
					<?php echo Form::select('default_assignee', array(0 => '') + Project\User::dropdown(Project::current()->users()->get()), Project::current()->default_assignee); ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<h3>
				<?php echo __('tinyissue.website_title'); ?>
				</h3>
				</td>
			</tr>
			<tr>
			<th><?php echo __('tinyissue.website_dev'); ?></th>
				<td>
					<input size="50" name="Dev" value="<?php echo @$WebLnk['dev']; ?>" placeholder="http://127.0.0.1/<?php echo Project::current()->name; ?>" />
				</td>
			</tr>
			<tr>
			<th><?php echo __('tinyissue.website_git'); ?></th>
				<td>
					<input size="50" name="Git" value="<?php echo @$WebLnk['git']; ?>" placeholder="http://github.com/<?php echo Auth::user()->firstname; ?>/<?php echo Project::current()->name; ?>" />
				</td>
			</tr>
			<tr>
			<th><?php echo __('tinyissue.website_prod'); ?></th>
				<td>
					<input size="50" name="Prod" value="<?php echo @$WebLnk['prod']; ?>" placeholder="http://www.<?php echo Project::current()->name; ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<h3>&nbsp;&nbsp;</h3>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" value="<?php echo __('tinyissue.update'); ?>" />
					<input type="submit" name="delete" value="<?php echo __('tinyissue.delete'); ?> <?php echo Project::current()->name; ?>" onclick="return confirm('<?php echo __('tinyissue.delete_project_confirm'); ?>');" />
				</td>
			</tr>
		</table>

	</form>

</div>
