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

	<?php
		echo '<ul>';
		$NbIssues = array();
		$Proj = array();
		$SansAccent = array();
		foreach(Project\User::active_projects() as $row) {
			$NbIssues[$row->to()] = $row->count_open_issues();
			$Proj[$row->to()] = $row->name.'&nbsp;<span class="info-open-issues" title="Number of Open Tickets">('.$NbIssues[$row->to()].')</span>';
			$idProj[$row->to()] = $row->id;
		}
		foreach ($Proj as $ind => $val ){
			$SansAccent[$ind] = htmlentities($val, ENT_NOQUOTES, 'utf-8');
			$SansAccent[$ind] = preg_replace('#&([A-za-z])(?:uml|circ|tilde|acute|grave|cedil|ring);#', '\1', $SansAccent[$ind]);
			$SansAccent[$ind] = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $SansAccent[$ind]);
			$SansAccent[$ind] = preg_replace('#&[^;]+;#', '', $SansAccent[$ind]);
		}
		asort($SansAccent);


		foreach($SansAccent as $ind => $val) {
			$id = $idProj[$ind];
			$follower = \DB::table('following')->where('project','=',1)->where('project_id','=',$id)->where('user_id','=',\Auth::user()->id)->count();
			$follower = ($follower > 0) ? 1 : 0;
			echo '<a href="javascript: Following('.$follower.', '.$id.', '.\Auth::user()->id.');" ><img id="img_follow_'.$id.'" src="app/assets/images/layout/icon-comments_'.$follower.'.png" align="left" style="min-height:'.$follower.'px " /></a>';
			echo '<li>';
			echo '<a href="'.$ind.(($NbIssues[$ind] == 0) ? '' : '/issues?tag_id=1').'">'.$Proj[$ind].' </a>';
			echo '</li>';
		}
		echo '</ul>';

	$ceci = array_keys($_GET);
	$prefixe = (in_array(@$ceci[0], array("/administration/users","/projects/reports","/user/settings","/user/issues","/project/5"))) ? "../" : "";
	include_once path('public').'app/vendor/searchEngine/index.php'; 
?>
</div>

<script type="text/javascript" >
	$('#sidebar_MenuDefault_title').click(function() {
	    $('#sidebar_MenuDefault').toggle('slow');
	});
	
	function Following(etat, Project, Qui) {
		var xhttp = new XMLHttpRequest();
		etat = document.getElementById('img_follow_' + Project).style.minHeight.substr(0,1);
		var NextPage = 'app/vendor/searchEngine/Following.php?Quoi=2&Qui=' + Qui + '&Project=' + Project + '&Etat=' + etat;
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText != '' ) {
				etat = Math.abs(etat-1);
				document.getElementById('img_follow_' + Project).src = "app/assets/images/layout/icon-comments_" + etat;
				document.getElementById('img_follow_' + Project).style.minHeight = etat+"px";
				}
			}
		};
		xhttp.open("GET", NextPage, true);
		xhttp.send(); 
	}
</script>