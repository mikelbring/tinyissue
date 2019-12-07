	<li id="comment<?php echo $activity->attributes['id']; ?>" class="comment">
		<div class="insides">
			<div class="topbar">
				<?php
				$ProjOrig =\DB::table('projects')->select(array('name'))->where('id','=',$activity->attributes['parent_id'])->get();  
				$ProjDest =\DB::table('projects')->select(array('name'))->where('id','=',$activity->attributes['action_id'])->get();  
					echo '<b>'.$user->attributes["firstname"].' '.$user->attributes["lastname"].'</b> : ';
					echo '&nbsp;';
					echo __('tinyissue.hasreproject');
					echo '&nbsp;';
					echo ' - '.date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->attributes['created_at']));
					echo '<br />';  
			echo '</div>';
			echo '<div class="data" style="margin-left: 2%;">';
				echo __('tinyissue.hasreproject_origin').' : <b>'.$ProjOrig[0]->name.'</b>';
				echo '<br />'; 
				echo __('tinyissue.hasreproject_destination').' : <b>'.$ProjDest[0]->name.'</b>';
			?>
		</div>
		</div>
		<div class="clr"></div>
	</li>
