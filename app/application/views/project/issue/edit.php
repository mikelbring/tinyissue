<h3>
	<?php echo __('tinyissue.edit_issue'); ?>
</h3>

<div class="pad">

	<form method="post" action="">

		<table class="form" style="width: 100%;">
			<tr>
				<th style="width: 10%"><?php echo __('tinyissue.title'); ?></th>
				<td>
					<input type="text" name="title" style="width: 98%;" value="<?php echo Input::old('title', $issue->title); ?>" />

					<?php echo $errors->first('title', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo __('tinyissue.issue'); ?></th>
				<td>
					<textarea name="body" style="width: 98%; height: 150px;"><?php echo Input::old('body', $issue->body); ?></textarea>
					<?php echo $errors->first('body', '<span class="error">:message</span>'); ?>
				</td>
			</tr>

			<tr>
				<th><?php echo __('tinyissue.tags'); ?></th>
				<td>
					<?php echo Form::text('tags', Input::old('tags', $issue_tags), array('id' => 'tags')); ?>
					<?php echo $errors->first('tags', '<span class="error">:message</span>'); ?>
					<script type="text/javascript">
					$(function(){
						$('#tags').tagit({
							autocomplete: {
								source: '<?php echo URL::to('ajax/tags/suggestions/edit'); ?>'
							}
						});
					});
					</script>
				</td>
			</tr>
			<?php if(Auth::user()->permission('issue-modify')): ?>
			<tr>
				<th><?php echo __('tinyissue.assigned_to'); ?></th>
				<td>
					<?php echo Form::select('assigned_to', array(0 => '') + Project\User::dropdown($project->users()->get()), Input::old('asigned_to', $issue->assigned_to)); ?>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<th></th>
				<td><input type="submit" value="<?php echo __('tinyissue.update_issue'); ?>" class="button primary" /></td>
			</tr>
		</table>

		<?php echo Form::token(); ?>

	</form>

</div>
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
			setTimeout(function() { showckeditor ('body'); } , 567);

		<?php } ?>
	<?php } ?>


</script>