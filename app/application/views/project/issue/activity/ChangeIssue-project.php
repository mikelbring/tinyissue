<?php 
if (@$activity->attributes['type_id'] == 8) { 
	$Who = \User::where('id', '=', $activity->attributes['user_id'] )->get(array('firstname','lastname','email'));
	?>
	<li id="comment<?php echo $activity->attributes['id']; ?>" class="comment">
		<div class="insides">
			<div class="topbar">
				<?php
				$ProOrig =\DB::table('projects')->where('id','=',$activity->attributes['parent_id'])->get();  
				$ProDest =\DB::table('projects')->where('id','=',$activity->attributes['action_id'])->get();  
					echo '<b>'.$user->attributes["firstname"].' '.$user->attributes["lastname"].'</b> : ';
					echo '&nbsp;';
					echo __('tinyissue.hasReproject');
					echo '&nbsp;';
					echo ' - '.date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->attributes['created_at']));
					echo '<br />';  
			echo '</div>';
				echo __('tinyissue.hasReproject_Origin').' : '.$ProOrig[0]->name;
				echo '<br />'; 
				echo __('tinyissue.hasReproject_Destination').' : '.$ProDest[0]->name;
				?>
		</div>
		</div>
		<div class="clr"></div>
	</li>
<?php }  ?>
