<div class="blue-box">
	<div class="inside-pad">

		<?php if(!$issues): ?>
		<p><?php echo __('tinyissue.no_issues'); ?></p>
		<?php else: ?>
		<ul class="issues" id="sortable">
			<?php foreach($issues as $row):  ?>
			<li class="sortable-li" data-issue-id="<?php echo $row->id; ?>">
				<a href="" class="comments"><?php echo $row->comment_count(); ?></a>
				<a href="" class="id">#<?php echo $row->id; ?></a>
				<div class="data">
					<a href="<?php echo $row->to(); ?>"><?php echo $row->title; ?></a>
					<div class="info">
						<?php echo __('tinyissue.created_by'); ?>
						<strong><?php echo $row->user->firstname . ' ' . $row->user->lastname; ?></strong>
						<?php if(is_null($row->updated_by)): ?>
							<?php echo Time::age(strtotime($row->created_at)); ?>
						<?php endif; ?>

						<?php if(!is_null($row->updated_by)): ?>
							- <?php echo __('tinyissue.updated_by'); ?>
							<strong><?php echo $row->updated->firstname . ' ' . $row->updated->lastname; ?></strong>
							<?php echo Time::age(strtotime($row->updated_at)); ?>
						<?php endif; ?>

						<?php if($row->assigned_to != 0): ?>
							- <?php echo __('tinyissue.assigned_to'); ?>
							<strong><?php echo $row->assigned->firstname . ' ' . $row->assigned->lastname; ?></strong>
						<?php endif; ?>

					</div>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>

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
  margin-top: 10px;
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
		$('ul.issues li').each(function (index) {
			weights.push($(this).data('issue-id'));
		});
		
    // POST
    $.post(siteurl + 'ajax/sortable/project_issue', {
      weights : weights
    }, function(data){
      console.log(data);
			$('#sortable-save').hide();
			$('#sortable-msg').text("Changes saved");
		});    
  });
});
</script>
