<h3>
	<?php echo __('tinyissue.projects');?>
	<span><?php echo __('tinyissue.projects_description');?></span>
</h3>

<div class="pad">

	<ul class="tabs">
		<li <?php echo $active == 'active' ? 'class="active"' : ''; ?>>
			<a href="<?php echo URL::to('projects'); ?>">
				<?php echo $active_count == 1 ? '1 '.__('tinyissue.active').' '.__('tinyissue.project') : $active_count . ' '.__('tinyissue.active').' '.__('tinyissue.projects'); ?>
			</a>
		</li>
		<li <?php echo $active == 'archived' ? 'class="active"' : ''; ?>>
			<a href="<?php echo URL::to('projects'); ?>?status=0">
				<?php echo $archived_count == 1 ? '1 '.__('tinyissue.archived').' '.__('tinyissue.project') : $archived_count . ' '.__('tinyissue.archived').' '.__('tinyissue.projects'); ?>
				</a>
		</li>
	</ul>

	<div class="inside-tabs">

		<div class="blue-box">

			<div class="inside-pad">
				<ul class="projects" id="sortable">
					<?php foreach($projects as $row):
						$issues = $row->issues()->where('status', '=', 1)->count();
					?>
					<li class="sortable-li" data-project-id="<?php echo $row->id; ?>">
						<a href="<?php echo $row->to(); ?>"><?php echo $row->name; ?></a><br />
						<?php echo $issues == 1 ? '1 '. __('tinyissue.open_issue') : $issues . ' '. __('tinyissue.open_issues'); ?>
					</li>
					<?php endforeach; ?>

					<?php if(count($projects) == 0): ?>
					<li>
						<?php echo __('tinyissue.you_do_not_have_any_projects'); ?> <a href="<?php echo URL::to('projects/new'); ?>"><?php echo __('tinyissue.create_project'); ?></a>
					</li>
					<?php endif; ?>
				</ul>


			</div>

		</div>
			
		<div id="sortable-msg"></div>
		<div id="sortable-save"><input id="sortable-save-button" class="button primary" type="submit" value="SAVE" /></div>

	</div>

</div>

<style>
.sortable-li,
ul.projects li {
	line-height: 1.2em;
	height: 25px;
}
#sortable-save {
	margin-top: 10px;
}
#sortable-msg {
	color: #107AA7;
	font-weight: bold;
}
#sortable-msg.error {
	color: #F21D20;
}
</style>
 <script>
$(function() {
	$('#sortable-save').hide();
	
	// Apply sortable behaviours.
	$( "#sortable" ).sortable({
		placeholder: "sortable-li",
		change: function( event, ui ) {
			$('#sortable-save').show();
			$('#sortable-msg').text("Your new ordering is not yet saved.")
			$('#sortable-msg').removeClass('error');
		}
	});
	$( "#sortable" ).disableSelection();
	
	// Save it.
	$('#sortable-save-button').click(function(){
		var weights = new Array();
		$('ul.projects li').each(function (index) {
			weights.push($(this).data('project-id'));
		});
		
		var data = new Array();
		data['target'] = 'projects';
		data['sorted'] = weights;
		
		// Test
		console.log(data);
		$('#sortable-save').hide();
		$('#sortable-msg').text("Changes saved");
		
    // POST
    /*
    $.post(siteurl + 'ajax/sortable/projects', {
      weights : weights
    }, function(data){
			$('#sortable-save').hide();
			$('#sortable-msg').text("Changes saved");
		});
    */
    
  });
});
</script>
