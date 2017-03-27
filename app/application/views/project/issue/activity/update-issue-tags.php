<li id="comment<?php echo $activity->id; ?>" class="comment">
	<div class="insides">
		<div class="topbar">
			<div class="data">
				<?php
					$Msg = ($activity->attributes['parent_id'] == $activity->attributes['item_id'] ) ? __('tinyissue.tag_removed') : __('tinyissue.tag_added');
					$Col = ($activity->attributes['parent_id'] == $activity->attributes['item_id'] ) ? "none" : "underline";
					$TagNum = Tag::where('id', '=', $activity->attributes['action_id'] )->first(array('id','tag','bgcolor'));
					$Who = \User::where('id', '=', $activity->attributes['user_id'] )->get(array('firstname','lastname','email'));
					echo '<label style="background-color: '.$TagNum->attributes['bgcolor'].'; padding: 5px 10px; border-radius: 8px;">'.
					$TagNum->attributes['tag'].'</label> : <span style="font-weight: bold; text-decoration: '.$Col.';">'.$Msg.
					'</span> '.__('tinyissue.by') . ' <b>' .$Who[0]->attributes["firstname"].' '.$Who[0]->attributes["lastname"].'</b> '.
					' '.$activity->attributes['updated_at'];
				?>
			</div>
		</div>
	</div>

	<div class="clr"></div>
</li>
