<h3>
	<?php echo __('tinyissue.tags') ?>
</h3>

<div class="pad">

	<?php foreach($tags as $tag): ?>
		<?php echo '<a href="' . URL::to('tag/' . $tag->id . '/edit') . '"><label id="tag' . $tag->id . '" class="label"' . ($tag->bgcolor ? ' style="background: ' . $tag->bgcolor . '"' : '') . '>' . $tag->tag . '</label></a>'; ?><br /><br />
	<?php endforeach; ?>
	
	<br />
	
	<form method="to" action="<?php echo URL::to('tag/new'); ?>">
		<input type="submit" value="<?php echo __('tinyissue.create_tag'); ?>" class="button primary" />
	</form>

</div>