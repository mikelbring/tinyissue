<li onclick="window.location='<?php echo $issue->to(); ?>';">

	<div class="tag">
		<label class="label notice" style="color:black;"><?php echo __('tinyissue.label_reprojected'); ?></label>
	</div>

	<div class="data">
		<?php
		$ProjOrig =\DB::table('projects')->select(array('name'))->where('id','=',$activity->attributes['parent_id'])->get();  
		$ProjDest =\DB::table('projects')->select(array('name'))->where('id','=',$activity->attributes['action_id'])->get();  
			echo '<b>'.$user->attributes["firstname"].' '.$user->attributes["lastname"].'</b> : ';
			echo '&nbsp;';
			echo __('tinyissue.hasReproject');
			echo '<br />';  
		echo '(&nbsp;'.__('tinyissue.hasReproject_Origin').' ) <b>'.$ProjOrig[0]->name;
		echo '<span style="font-size: larger; font-weight: bold; color: black;">&nbsp;&nbsp;&rarr;&nbsp;&nbsp;</span>'; 
		echo $ProjDest[0]->name.'</b> (&nbsp;'.__('tinyissue.hasReproject_Destination').'&nbsp;)';
	?>
		<span class="time">
			<?php echo date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->created_at)); ?>
		</span>
	</div>

	<div class="clr"></div>
</li>
