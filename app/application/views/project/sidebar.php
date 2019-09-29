<?php
$active_projects =Project\User::active_projects();
if(count($active_projects)>1){
?>
<div id="sidebar_Projects_title" class="sidebarTitles"><?php echo __('tinyissue.select_a_project'); ?></div>
<div id="sidebar_Projects" class="sidebarItem">
<form class="projects_selector">
<fieldset class="sidebar_Projects_label"><label for="projects_select"><?php echo __('tinyissue.select_a_project');?></label>
<select name="projects_select" id="projects_select"  onchange="if (this.value) window.location.href=this.value">
<?php
	$NbIssues = array();
	$Proj = array();
	$SansAccent = array();
	foreach($active_projects as $row) {
		$NbIssues[$row->to()] = $row->count_open_issues();
		$Proj[$row->to()] = $row->name.' ('.$NbIssues[$row->to()].')';
	}
	foreach ($Proj as $ind => $val ){
		$SansAccent[$ind] = htmlentities($val, ENT_NOQUOTES, 'utf-8');
		$SansAccent[$ind] = preg_replace('#&([A-za-z])(?:uml|circ|tilde|acute|grave|cedil|ring);#', '\1', $SansAccent[$ind]);
		$SansAccent[$ind] = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $SansAccent[$ind]);
		$SansAccent[$ind] = preg_replace('#&[^;]+;#', '', $SansAccent[$ind]);
	}
	asort($SansAccent);

	foreach($SansAccent as $ind => $val) {
		$selected = (substr($ind, strrpos($ind, "/")+1) == Project::current()->id) ? 'selected':'';
		echo '<option value="'.$ind.(($NbIssues[$ind] == 0) ? '' : '/issues?tag_id=1').'" '.$selected.'>'.$Proj[$ind].'</option>';
	 }
?>
</select>
</fieldset>
</form>
</div>

<?php
}
?>
<div id="sidebar_Issues_title" class="sidebarTitles"><?php echo __('tinyissue.projet_Ticket'); ?></div>
<div id="sidebar_Issues" class="sidebarItem">
<h2>
	<?php if(Auth::user()->permission('project-modify')): ?>
	<a href="<?php echo Project::current()->to('edit'); ?>" class="edit"><?php echo __('tinyissue.edit');?></a>
	<?php endif; ?>

	<span><?php echo HTML::link(Project::current()->to(), Project::current()->name); ?><br />
	<?php echo __('tinyissue.assign_users_and_edit_the_project');?></span>
</h2>

<ul>
	<li><a href="<?php echo Project::current()->to('issues'); ?>?tag_id=1"><?php echo Project::current()->count_open_issues(); ?> <?php echo __('tinyissue.open_issues');?></a></li>
	<li><a href="<?php echo Project::current()->to('issues'); ?>?tag_id=2"><?php echo Project::current()->count_closed_issues(); ?> <?php echo __('tinyissue.closed_issues');?></a></li>
</ul>
</div>

<div id="sidebar_Users_title" class="sidebarTitles"><?php echo __('tinyissue.assigned_users'); ?></div>
<div id="sidebar_Users" class="sidebarItem">
<h2>
	<?php 
		//echo __('tinyissue.assigned_users');
	?>
	<span><?php echo __('tinyissue.assigned_users_description');?></span>
</h2>

<ul class="sidebar-users">
<?php foreach(Project::current()->users()->get() as $row): ?>
	<li id="project-user<?php echo $row->id; ?>">
		<?php if(Auth::user()->permission('project-modify') && count(Project::current()->users()->get())  > 1): ?>
		<a href="javascript:void(0);" onclick="remove_project_user(<?php echo $row->id; ?>, <?php echo Project::current()->id; ?>);" class="delete"><?php echo __('tinyissue.remove');?></a>
		<?php endif; ?>
		<?php echo $row->firstname . ' ' . $row->lastname; ?>
	</li>
<?php endforeach; ?>
</ul>

<?php if(Auth::user()->permission('project-modify')): ?>

	<input type="text" id="add-user-project" placeholder="<?php echo __('tinyissue.assign_a_user');?>" onmouseover="init_sidebar_autocomplete(<?php echo Project::current()->id; ?>);" />

<?php endif; ?>
</div>

<div id="sidebar_Website_title" class="sidebarTitles"><?php echo __('tinyissue.website_title'); ?></div>
<div id="sidebar_Website" class="sidebarItem">
<?php
	$project_WebLnks = \DB::table('projects_links')->where('id_project', '=', Project::current()->id)->order_by('category','ASC')->get();
	$WebLnk = array();
	foreach($project_WebLnks as $WebLnks) {
		if (trim($WebLnks->desactivated) == '') { $WebLnk[$WebLnks->category] = $WebLnks->link; }
	}
if (count($WebLnk) > 0 ) {
?>
<h2>
	<?php 
		//echo __('tinyissue.website_title');
	?>
	<span><?php echo __('tinyissue.website_description');?></span>
</h2>
<?php
	echo '<ul>';
	foreach($WebLnk as $categ => $link) {
		echo '<li><a href="'.$link.'" class="links" target="_blank">'.__('tinyissue.website_'.$categ).'</a></li>';
	}
	echo '</ul>';
}
?>
</div>


<script type="text/javascript" >
	$('#sidebar_Website_title').click(function() {
	    $('#sidebar_Website').toggle('slow');
	});
	$('#sidebar_Users_title').click(function() {
	    $('#sidebar_Users').toggle('slow');
	});
	$('#sidebar_Issues_title').click(function() {
	    $('#sidebar_Issues').toggle('slow');
	});
	$('#sidebar_Projects_title').click(function() {
	    $('#sidebar_Projects').toggle('slow');
	});
</script>