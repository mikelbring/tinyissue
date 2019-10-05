<div id="sidebar_MenuDefault_title" class="sidebarTitles"><?php echo __('tinyissue.active_projects'); ?></div>
<div id="sidebar_MenuDefault" class="sidebarItem">
<h2>
	<?php if(Auth::user()->permission('project-create')): ?>
	<a href="<?php echo URL::to('projects/new'); ?>" class="add" title="New Project" style="margin-top: -18px;"><?php __('tinyissue.new'); ?></a>
	<?php endif; ?>
	<?php 
		///echo __('tinyissue.active_projects');
	?>
	<span><?php echo __('tinyissue.active_projects_description');?></span>
</h2>

<ul>
	<?php
		$NbIssues = array();
		$Proj = array();
		$SansAccent = array();
		foreach(Project\User::active_projects() as $row) {
			$NbIssues[$row->to()] = $row->count_open_issues();
			$Proj[$row->to()] = $row->name.'&nbsp;<span class="info-open-issues" title="Number of Open Tickets">('.$NbIssues[$row->to()].')</span>';
		}
		foreach ($Proj as $ind => $val ){
			$SansAccent[$ind] = htmlentities($val, ENT_NOQUOTES, 'utf-8');
			$SansAccent[$ind] = preg_replace('#&([A-za-z])(?:uml|circ|tilde|acute|grave|cedil|ring);#', '\1', $SansAccent[$ind]);
			$SansAccent[$ind] = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $SansAccent[$ind]);
			$SansAccent[$ind] = preg_replace('#&[^;]+;#', '', $SansAccent[$ind]);
		}
		asort($SansAccent);
	?>


	<?php foreach($SansAccent as $ind => $val): ?>
	<li>
		<a href="<?php echo $ind.(($NbIssues[$ind] == 0) ? '' : '/issues?tag_id=1'); ?>"><?php echo $Proj[$ind]; ?> </a>
	</li>
	<?php endforeach ?>

</ul>
</div>
<div id="sidebar_Search" class="sidebarItem">
<?php 
	$ceci = array_keys($_GET);
	$prefixe = (in_array(@$ceci[0], array("/administration/users","/projects/reports","/user/settings","/user/issues","/project/5"))) ? "../" : "";
	include_once path('public').'app/vendor/searchEngine/index.php'; 
?>
</div>

<script type="text/javascript" >
	$('#sidebar_MenuDefault_title').click(function() {
	    $('#sidebar_MenuDefault').toggle('slow');
	});
	$('#sidebar_Search').click(function() {
	    $('#sidebar_Website').toggle('slow');
	});
</script>