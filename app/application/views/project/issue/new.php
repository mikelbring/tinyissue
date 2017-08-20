<?php $config_app = require path('public') . 'config.app.php'; ?>
<h3>
	<?php echo __('tinyissue.create_a_new_issue'); ?>
	<span><?php echo __('tinyissue.create_a_new_issue_in'); ?> <a href="<?php echo $project->to(); ?>"><?php echo $project->name; ?></a></span>
</h3>

<div class="pad">

	<form method="post" action="">

		<table class="form" style="width: 100%;">
			<tr>
				<th style="width: 10%"><?php echo __('tinyissue.title'); ?></th>
				<td>
					<input type="text" name="title" style="width: 98%;" value="<?php echo Input::old('title'); ?>" />

					<?php echo $errors->first('title', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo __('tinyissue.issue'); ?></th>
				<td>
					<textarea name="body" style="width: 98%; height: 150px;"><?php echo Input::old('body'); ?></textarea>
					<?php echo $errors->first('body', '<span class="error">:message</span>'); ?>
				</td>
			</tr>

		<tr>
			<th><?php echo __('tinyissue.tags'); ?></th>
				<td>
					<?php echo Form::text('tags', Input::old('tags', Tag::find(1)->first()->tag), array('id' => 'tags')); ?>
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
			<tr>
				<th><?php echo __('tinyissue.duration'); ?></th>
				<td>
					<input type="number" name="duration" style="width: 60px;" value="<?php echo $config_app['duration']; ?>" min="1" max="400" />&nbsp;<?php echo __('tinyissue.days'); ?>
				</td>
			</tr>


			<?php if(Auth::user()->permission('issue-modify')): ?>
			<tr>
				<th><?php echo __('tinyissue.assigned_to'); ?></th>
				<td>
					<?php echo Form::select('assigned_to', array(0 => '') + Project\User::dropdown($project->users()->get()), $project->default_assignee); ?>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<th><?php echo __('tinyissue.attachments'); ?></th>
				<td>
					<div class="upload-wrap green-button">
						<?php echo __('tinyissue.fileupload_button'); ?>
						<input id="upload" type="file" name="file_upload" class="green-button" />
						<input type="hidden" id="uploadbuttontext" name="uploadbuttontext" value="<?php echo __('tinyissue.fileupload_button'); ?>"/>
					</div>

					<ul id="uploaded-attachments"></ul>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="<?php echo __('tinyissue.create_issue'); ?>" class="button primary" /></td>
			</tr>
		</table>

		<?php echo Form::hidden('session', Crypter::encrypt(Auth::user()->id)); ?>
		<?php echo Form::hidden('project_id', Project::current()->id); ?>
		<?php echo Form::hidden('token', md5(Project::current()->id . time() . \Auth::user()->id . rand(1, 100))); ?>
		<?php echo Form::token(); ?>

	</form>

</div>
<script type="text/javascript">
function OteTag() {
	return true;
}
function AddTag (tags){
	return true;
}

function LitTags () {
	return true;
}

<?php
	$wysiwyg = Config::get('application.editor');
	if (trim($wysiwyg['BasePage'	]) != '') {
		if ($wysiwyg['BasePage'] == '/app/vendor/ckeditor/ckeditor.js') { ?>
			function showckeditor (Quel) {
				CKEDITOR.config.entities = false;
				CKEDITOR.config.entities_latin = false;
				CKEDITOR.config.htmlEncodeOutput = false;
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