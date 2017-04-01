<h3>
	<a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo __('tinyissue.new_issue'); ?></a>

	<?php if(Auth::user()->permission('issue-modify')): ?>
	<a href="<?php echo $issue->to('edit'); ?>" class="edit-issue"><?php echo $issue->title; ?></a>
	<?php else: ?>
	<a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a>
	<?php endif; ?>

	<span><?php echo __('tinyissue.on_project'); ?> <a href="<?php echo $project->to(); ?>"><?php echo $project->name; ?></a></span>
</h3>
<div class="pad">

	<div id="issue-tags">
	<?php
		//Percentage of work done
		$SizeXtot = 500;
		$SizeX = $SizeXtot / 100;
		echo __('tinyissue.issue_percent').' : ';
		$Etat = Todo::load_todo($issue->id);
		if (is_object($Etat)) {
		echo '<div style="position: relative; top:-20px; left: 200px; background-color: green; color:white; width: '.($Etat->weight*$SizeX).'px; height: 20px; text-align: center; line-height:20px;" />'.$Etat->weight.'%</div>';
		echo '<div style="position: relative; top:-40px; left: '.(200 + ($Etat->weight*$SizeX)).'px; margin-bottom: -30px; background-color: gray; color:white; width: '.($SizeXtot-($Etat->weight*$SizeX)).'px; height: 20px; text-align: center; line-height:20px;" /></div>';
		}

		//Time's going fast!
		//Timing bar, according to the time planified (field projects_issues - duration) for this issue
		$config_app = require path('public') . 'config.app.php';
		$Deb = strtotime($issue->created_at);
		$Dur = (time() - $Deb) / 86400;
		if (@$issue->duration === 0 || @is_null($issue->duration)) { $issue->duration = 30; }
		$DurRelat = round(($Dur / $issue->duration) * 100);
		$Dur = round($Dur);
		$DurColor = ($DurRelat < 65) ? 'green' : (( $DurRelat > $config_app['Percent'][3]) ? 'red' : 'yellow') ;
		if ($DurRelat >= 50 && @$Etat->weight <= 50 ) { $DurColor = 'yellow'; }
		if ($DurRelat >= 75 && @$Etat->weight <= 50 ) { $DurColor = 'red'; }
		$TxtColor = ($DurColor == 'green') ? 'white' : 'black' ;
		echo __('tinyissue.countdown').' ('.__('tinyissue.day').'s) : ';
		echo '<div style="position: relative; top:-20px; left: 200px; background-color: '.$DurColor.'; color:'.$TxtColor.'; width: '.(($DurRelat  >= 100) ? $SizeXtot : ($DurRelat*$SizeX)).'px; height: 20px; text-align: left; line-height:20px;" />'.((($DurRelat  >= 100)) ? $Dur.' / '.@$issue->duration : $Dur).'</div>';
		if ($DurRelat < 100) { echo '<div style="position: relative; top:-40px; left: '.(200 + ($DurRelat*$SizeX)).'px; margin-bottom: -30px; background-color: gray; color:white; width: '.($SizeXtot-($DurRelat*$SizeX)).'px; height: 20px; text-align: right; line-height:20px;" />'.$issue->duration.'</div>'; }
		echo '<br clear="all" />';

	?>
	&nbsp;&nbsp;&nbsp;
	<?php
		if(!empty($issue->tags)) {
			$IssueTags = array();
			foreach($issue->tags()->order_by('tag', 'ASC')->get() as $tag) {
			echo '<label class="label"' . ($tag->bgcolor ? ' style="background: ' . $tag->bgcolor . '"' : '') . '>' . $tag->tag . '</label>&nbsp;';
			$IssueTags[] = $tag->tag;
			}  //endforeach
		} //endif
	?>
	</div>
	<?php Todo::add_todo($issue->id, 2, 0); ?>

	<ul id="ul_IssueDiscussion" class="issue-discussion">
		<li>
			<div class="insides">
				<div class="topbar">
					<strong><?php echo $issue->user->firstname . ' ' . $issue->user->lastname; ?> </strong>
					<?php echo __('tinyissue.opened_this_issue'); ?>  <?php echo date(Config::get('application.my_bugs_app.date_format'), strtotime($issue->created_at)); ?>
				</div>

				<div class="issue">
					<?php echo Project\Issue\Comment::format($issue->body); ?>
				</div>

				<ul class="attachments">
					<?php foreach($issue->attachments()->get() as $attachment): ?>
					<li>
						<?php if(in_array($attachment->fileextension, Config::get('application.image_extensions'))): ?>
							<a href="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . rawurlencode($attachment->filename); ?>" title="<?php echo $attachment->filename; ?>"><img src="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . $attachment->filename; ?>" style="max-width: 100px;"  alt="<?php echo $attachment->filename; ?>" /></a>
						<?php else: ?>
							<a href="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . rawurlencode($attachment->filename); ?>" title="<?php echo $attachment->filename; ?>"><?php echo $attachment->filename; ?></a>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>
				</ul>

				<div class="clr"></div>
			</div>
		</li>

		<?php foreach($issue->activity() as $activity): ?>
			<?php echo $activity; ?>
		<?php endforeach; ?>

	</ul>
	<div id="div_currentlyAssigned_name" class="topbar"></div>

	<?php if(Project\Issue::current()->status == 1): ?>

	<div class="new-comment" id="new-comment">
		<?php if(Auth::user()->permission('issue-modify')): ?>

			<ul class="issue-actions">
				<li class="assigned-to">
					<?php echo __('tinyissue.assigned_to'); ?>

					<?php if(Project\Issue::current()->assigned): ?>
						<a href="javascript:void(0);" class="currently_assigned">
						<span id="span_currentlyAssigned_name">
						<?php echo Project\Issue::current()->assigned->firstname; ?>
						<?php echo Project\Issue::current()->assigned->lastname; ?>
						</span>
						</a>
					<?php else: ?>
						<a href="javascript:void(0);" class="currently_assigned">
							<span id="span_currentlyAssigned_name">
							<?php echo __('tinyissue.no_one'); ?>
							</span>
						</a>
					<?php endif; ?>

					<div class="dropdown">
						<ul>
							<li class="unassigned"><a href="<?php echo $issue->to('reassign'); ?>?Prev=<?php echo Project\Issue::current()->assigned->id.'&Next=0&Issue='.Project\Issue::current()->id; ?>" class="user0<?php echo !Project\Issue::current()->assigned ? ' assigned' : ''; ?>" target="ContenuVariable"><?php echo __('tinyissue.no_one'); ?></a></li>
							<?php foreach(Project::current()->users()->get() as $row): ?>
							<li><a href="<?php echo $issue->to('reassign'); ?>?Prev=<?php echo Project\Issue::current()->assigned->id.'&Next='.$row->id.'&Issue='.Project\Issue::current()->id; ?>" class="user0<?php echo !Project\Issue::current()->assigned ? ' assigned' : ''; ?>" target="ContenuVariable"><?php echo $row->firstname . ' ' . $row->lastname; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</li>
				<li>
					<a href="<?php echo Project\Issue::current()->to('status?status=0'); ?>" onclick="return confirm('<?php echo __('tinyissue.close_issue_confirm'); ?>');" class="close"><?php echo __('tinyissue.close_issue'); ?></a>
				</li>
			</ul>
		<?php endif; ?>

		<h4>
			<?php echo __('tinyissue.comment_on_this_issue'); ?>
		</h4>

		<form method="post" action="">
			<!-- New options in the form : percentage of work done after this ticket  -->
			<p>
				<textarea name="comment" style="width: 98%; height: 90px;"></textarea>
				<span style="text-align: left; width: 50%;">
				<?php echo __('tinyissue.percentage_of_work_done'); ?> : <input type="number" name="Pourcentage" value="<?php echo ((is_object($Etat)) ? (($Etat->weight == 100) ? 91 : $Etat->weight+1) : 10 ); ?>" min="<?php echo ((is_object($Etat)) ? (($Etat->weight == 100) ? 91 : $Etat->weight) : 10); ?>" max="100" /> %
				</span>
				<div style="text-align: right; width: 98%; margin-top: -25px;">
				<a href="http://daringfireball.net/projects/markdown/basics/" ><?php echo __('tinyissue.format_with_markdown'); ?></a>
				</div>
					<div style="width: 90%">
					<!-- Tags modification  -->
					<?php
						//echo __('tinyissue.tags');
						$TAGS = new Project_Issue_Controller();
						$Tomates = $TAGS->get_edit($issue->id);
						echo Form::text('tags', Input::get('tags', implode(",", $IssueTags)), array('id' => 'tags', 'name' =>'MesTags', 'onblur' =>'AdaptTags(this.value);')); ?>
						<script type="text/javascript">
						$(function(){
							$('#tags').tagit({
								autocomplete: { source: '<?php echo URL::to('ajax/tags/suggestions/filter'); ?>' }
							});
						});
						</script>
					</div>
			</p>
			<p>
				<div class="upload-wrap green-button">
						<?php echo __('tinyissue.fileupload_button'); ?>
						<input id="upload" type="file" name="file_upload" class="green-button" />
						<input type="hidden" id="uploadbuttontext" name="uploadbuttontext" value="<?php echo __('tinyissue.fileupload_button'); ?>"/>
					</div>			</p>

			<ul id="uploaded-attachments"></ul>

			<p style="margin-top: 10px;">
				<input type="submit" class="button primary" value="<?php echo __('tinyissue.comment'); ?>" />
			</p>

			<?php echo Form::hidden('session', Crypter::encrypt(Auth::user()->id)); ?>
			<?php echo Form::hidden('project_id', $project->id); ?>
			<?php echo Form::hidden('token', md5($project->id . time() . \Auth::user()->id . rand(1, 100))); ?>
			<?php echo Form::token(); ?>
		</form>

	</div>

	</div>
	<?php else: ?>
	<?php echo HTML::link(Project\Issue::current()->to('status?status=1'), __('tinyissue.reopen_issue')); ?>
	<?php endif; ?>
</div>
<script type="text/javascript">
var d = new Date();
var t = d.getTime();
var AllTags = "";
function OteTag() {
	var avant = LitTags();
	setTimeout(function() {
		apres = LitTags();
		document.getElementById('ContenuVariable').src = '<?php echo $_SERVER['REQUEST_URI']; ?>/retag?avant=' + avant + '&apres=' + apres +'';
	} , 123);
	AllTags = apres;
}
function AddTag (tags){
	var n = new Date();
	var now = n.getTime();
	if (now - t > 1000 ) {
		document.getElementById('ContenuVariable').src = '<?php echo $_SERVER['REQUEST_URI']; ?>/retag?avant=' + AllTags + '&apres=xxxxx' + tags +'';
	}
	AllTags = LitTags();
}

function LitTags () {
	var NosTags = "";
	var contenu = document.getElementById('TagItAll');
	var Fils = contenu.children;
	for (i = 0; i < Fils.length; i++) {
		Tout = Fils[i].innerHTML;
		etiq = Tout.substring(Tout.indexOf('>', 14)+1, Tout.indexOf('<', Tout.indexOf('>', 14)));
		if (etiq != '<input aria-haspopup="true" aria-autocomplete="list" role="textbox" autocomplete="off" class="ui-widget-content ui-autocomplete-input" type="text">' && etiq != '<input class="ui-widget-content" type="text">' ) {
			NosTags = NosTags + etiq + "|";
		}
	}
	return NosTags;
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
			setTimeout(function() { showckeditor ('comment'); } , 567);

		<?php } ?>
	<?php } ?>
	setTimeout(function() { var debut = LitTags (); } , 497);
</script>
