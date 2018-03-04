<li id="comment<?php echo $comment->id; ?>" class="comment">
	<div class="insides">
		<div class="topbar">
			<?php if(Auth::user()->permission('issue-modify')): ?>
			<ul>
				<li class="edit-comment">
					<a href="javascript:void(0);" class="edit">Edit</a>
				</li>
				<li class="delete-comment">
				<a href="<?php echo $issue->to('delete_comment?comment=' . $issue->id); ?>" class="delete">Delete</a>
				</li>
			</ul>
			<?php endif; ?>
			<strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong>
			<?php echo __('tinyissue.commented'); ?> <?php echo date(Config::get('application.my_bugs_app.date_format'), strtotime($comment->updated_at)); ?>
		</div>

		<div class="issue">
			<?php echo Project\Issue\Comment::format($comment->comment); ?>
		</div>

		<?php if(Auth::user()->permission('issue-modify')): ?>
		<div class="comment-edit">
			<textarea name="body" style="width: 98%; height: 90px;"><?php echo stripslashes($comment->comment); ?></textarea>
			<div class="right">
				<a href="javascript:void(0);" class="action save"><?php echo __('tinyissue.save'); ?></a>
				<a href="javascript:void(0);" class="action cancel"><?php echo __('tinyissue.cancel'); ?></a>
			</div>
		</div>
		<?php endif; ?>
		
		<ul class="attachments">
			<?php foreach($comment->attachments()->get() as $attachment): ?>
			<li>
				<?php if(in_array($attachment->fileextension, Config::get('application.image_extensions'))): ?>
					<a href="<?php echo URL::base().Config::get('application.attachment_path').rawurlencode($attachment->filename) ?>" title="<?php echo $attachment->filename; ?>"><img src="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . $attachment->filename; ?>" style="max-width: 100px;"  alt="<?php echo $attachment->filename; ?>" /></a>
					<?php else: ?>
					<a href="<?php echo URL::base().Config::get('application.attachment_path').rawurlencode($attachment->filename); ?>" title="<?php echo $attachment->filename; ?>"><?php echo $attachment->filename; ?></a>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="clr"></div>
</li>
<script type="text/javascript">
<?php
	$wysiwyg = Config::get('application.editor');
	if (trim(@$wysiwyg['directory']) != '') {
		if (file_exists($wysiwyg['directory']."/Bugs_code/showeditor.js")) {
			include_once $wysiwyg['directory']."/Bugs_code/showeditor.js"; 
		} 
	} 
?>

</script>