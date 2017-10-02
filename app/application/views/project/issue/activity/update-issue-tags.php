<li id="comment<?php echo $activity->id; ?>" class="comment">
	<div class="insides">
		<div class="topbar">
			<div class="data">
				<?php
					if (trim($activity->attributes['data']) == '') {
					$Msg = ($activity->attributes['parent_id'] == $activity->attributes['item_id'] ) ? __('tinyissue.tag_removed') : __('tinyissue.tag_added');
					$Col = ($activity->attributes['parent_id'] == $activity->attributes['item_id'] ) ? "none" : "underline";
					$TagNum = Tag::where('id', '=', $activity->attributes['action_id'] )->first(array('id','tag','bgcolor'));
					$Who = \User::where('id', '=', $activity->attributes['user_id'] )->get(array('firstname','lastname','email'));
					echo '<label style="background-color: '.@$TagNum->attributes['bgcolor'].'; padding: 5px 10px; border-radius: 8px;">'.
					@$TagNum->attributes['tag'].'</label> : <span style="font-weight: bold; text-decoration: '.$Col.';">'.$Msg.
					'</span> '.__('tinyissue.by') . ' <b>' .$Who[0]->attributes["firstname"].' '.$Who[0]->attributes["lastname"].'</b> '.
					' '.date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->attributes['updated_at']));
					} else {
						$j = json_decode($activity->attributes['data'], true);
						echo count($j['added_tags']).' '.((count($j['added_tags']) > 1) ? __('tinyissue.tags_added') : __('tinyissue.tag_added')).'.';
						foreach ($j['tag_data'] as $ind => $val ) { 
							if ( in_array($val['id'], $j['added_tags'])) { echo '<label style="background-color: '.$val['bgcolor'].'; padding: 5px 10px; border-radius: 8px;">'.$val['tag'].'</label>'; } 
						}
						echo '<br clear="all" />';
						echo '<br clear="all" />';
						echo count($j['removed_tags']).' '.((count($j['removed_tags']) > 1) ? __('tinyissue.tags_removed') : __('tinyissue.tag_removed')).'.';
						foreach ($j['tag_data'] as $ind => $val ) { 
							if ( in_array($val['id'], $j['removed_tags'])) { echo '<label style="background-color: '.$val['bgcolor'].'; padding: 5px 10px; border-radius: 8px;">'.$val['tag'].'</label>'; } 
						}
						echo '<br clear="all" />';
						echo ' '.date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->attributes['updated_at']));
					}
				?>
			</div>
		</div>
	</div>

	<div class="clr"></div>
</li>
