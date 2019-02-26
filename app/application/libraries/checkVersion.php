<?php
	$verActu = Config::get('tinyissue.version');
	$verDisp = file_get_contents( "https://github.com/pixeline/bugs/releases");
	$verDisp = substr($verDisp, strpos($verDisp, "Latest release"), 2600);
	$verNum = substr($verDisp, strpos($verDisp, '<span class="css-truncate-target" style="max-width: 125px">') + 60, 70);
	$verNum = substr($verNum, 0, strpos($verDisp, '</span>'));
	$verCommit = substr($verDisp, strpos($verDisp, '<svg class="octicon octicon-git-commit"'), 400); 
	$verCommit = substr($verCommit, strpos($verCommit,'<code>')+6);
	$verCommit = substr($verCommit, 0, strpos($verCommit, '<'));
?>