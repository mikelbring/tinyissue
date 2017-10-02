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

	</div>
	<div class="clr"></div>
</li>
<script type="text/javascript">
<?php
	$wysiwyg = Config::get('application.editor');
	if (trim($wysiwyg['BasePage'	]) != '') {
		if ($wysiwyg['BasePage'] == '/app/vendor/ckeditor/ckeditor.js') { ?>
			function showckeditor (Quel) {
				CKEDITOR.replace( Quel, {
					language: '<?php echo \Auth::user()->language; ?>',
					height: 175,
					toolbar : [
						{ name: 'Fichiers', items: ['Source']},
						{ name: 'CopieColle', items: ['Cut','Copy','Paste','PasteText','PasteFromWord','RemoveFormat']},
						{ name: 'FaireDefaire', items: ['Undo','Redo','-','Find','Replace','-','SelectAll']},
						{ name: 'Polices', items: ['Bold','Italic','Underline','TextColor']},
						{ name: 'ListeDec', items: ['horizontalrule','table','JustifyLeft','JustifyCenter','JustifyRight','Outdent','Indent','Blockquote']},
						{ name: 'Liens', items: ['NumberedList','BulletedList','-','Link','Unlink']}
					]
				} );
			}
//			setTimeout(function() { showckeditor ('body'); } , 567);

		<?php } ?>
	<?php } ?>


</script>