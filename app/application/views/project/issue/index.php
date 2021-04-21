<?php 
	$config_app = require path('public') . 'config.app.php';  
	if(!isset($config_app['PriorityColors'])) { $config_app['PriorityColors'] = array("black","Orchid","Cyan","Lime","orange","red"); }
	$url =\URL::home();
	if (!Project\User::MbrProj(\Auth::user()->id, Project::current()->id)) {
		echo '<script>document.location.href="'.URL::to().'";</script>';
	}
	$following = \DB::table('following')->where('project','=',0)->where('issue_id','=',Project\Issue::current()->id)->where('user_id','=',\Auth::user()->id)->count();
	if ($following == 0) {
		$follower["attached"] = 0;
		$follower["tags"] = 0;
		$follower["comment"] = 0;
	} else {
		$following =\DB::query("SELECT 1 as 'comment', attached, tags FROM following WHERE project_id = ".Project::current()->id." AND project = 0 AND issue_id = ".Project\Issue::current()->id." AND user_id = ".\Auth::user()->id);
		$follower["attached"] = $following[0]->attached ?? 0;
		$follower["tags"] = $following[0]->tags ?? 0;
		$follower["comment"] = $following[0]->comment ?? 0;
	}
?>
<h3>
	<?php if (Auth::user()->role_id != 1) { ?>
	<a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo __('tinyissue.new_issue'); ?></a>
   <?php } ?> 

	<span style="color: <?php echo $config_app['PriorityColors'][$issue->status]; ?>; font-size: 200%;">&#9899;
	<?php if(Auth::user()->permission('issue-modify') && $issue->status > 0 ): ?>
	<a href="<?php echo $issue->to('edit'); ?>" class="edit-issue" style="font-size: 80%; font-weight: bold;"><?php echo $issue->title; ?></a>
	<?php else: ?>
	<a href="<?php echo $issue->to(); ?>" style="font-size: 80%; font-weight: bold;"><?php echo $issue->title; ?></a>
	<?php endif; ?>
	</span>	

	<span><?php echo __('tinyissue.on_project'); ?> <a href="<?php echo $project->to(); ?>"><?php echo $project->name; ?></a></span>
</h3>
<div class="pad">

	<div style="background-color: #ededed; width: 20%; float: right; ">
		<?php if (isset($follower)) { ?>
		<div style="width:25%; float:left;">
			<span style="font-weight: bold; font-size: 125%;"><?php echo __('tinyissue.following'); ?></span>
			<br />
			&nbsp;&nbsp;&nbsp;
			<img src="<?php echo \URL::home();?>app/assets/images/layout/icon-comments_<?php echo $follower["comment"]; ?>.png" id="img_following" />
		</div>
		<div style="width:75%; float:right;">
			<input id="input_following_comments" type="checkbox" value="1" <?php echo ($follower["comment"]) ? 'checked' : ''; ?> onclick="Following('comments', this.checked);" />
			<?php echo __('tinyissue.following_email_comment_tit'); ?>
			<br />
			<input id="input_following_attached" type="checkbox" value="1" <?php echo ($follower["attached"]) ? 'checked' : ''; ?> onclick="Following('attached', this.checked);" />
			<?php echo __('tinyissue.following_email_attached_tit'); ?>
			&nbsp;&nbsp;&nbsp;
			<input id="input_following_tags" type="checkbox" value="1" <?php echo ($follower["tags"]) ? 'checked' : ''; ?> onclick="Following('tags', this.checked);" />
			<?php echo __('tinyissue.following_email_tags_tit'); ?>
		</div>
		<?php } ?>
	</div>
	<div id="issue-tags">
	<?php
			//Percentage of work done
			////Calculations
			$SizeXtot = 500;
			$SizeX = $SizeXtot / 100;
			echo __('tinyissue.issue_percent').' : ';
			$EtatTodo = Todo::load_todo($issue->id);
			////Here we show the progress bar
		if (Auth::user()->role_id != 1) {
			if (is_object($EtatTodo)) {
				echo '<div class="Percent">';
				echo '<div style="background-color: green; position: absolute; top: 0; left: 0; width: '.($EtatTodo->weight).'%; height: 100%; text-align: center; line-height:20px;" />'.$EtatTodo->weight.'%</div>';
				echo '<div style="background-color: gray; position: absolute;  top: 0; left: '.$EtatTodo->weight.'%; width: '.(100-$EtatTodo->weight).'%; height: 100%; text-align: center; line-height:20px;" />'.(100-$EtatTodo->weight).'%</div>';
				echo '</div>';
			}
	
			//Time's going fast!
			//Timing bar, according to the time planified (field projects_issues - duration) for this issue
			////Calculations
			$config_app = require path('public') . 'config.app.php';
			$Deb = strtotime($issue->created_at);
			$Dur = (time() - $Deb) / 86400;
			if (@$issue->duration === 0 || @is_null($issue->duration)) { $issue->duration = 30; }
			$DurRelat = round(($Dur / $issue->duration) * 100);
			$Dur = round($Dur);
			$DurColoF = ($DurRelat < 65) ? 'white' : (( $DurRelat > $config_app['Percent'][3]) ? 'white' : 'black') ;
			$DurColor = ($DurRelat < 65) ? 'green' : (( $DurRelat > $config_app['Percent'][3]) ? 'red' : 'yellow') ;
			if ($DurRelat >= 50 && @$EtatTodo->weight <= 50 ) { $DurColor = 'yellow'; }
			if ($DurRelat >= 75 && @$EtatTodo->weight <= 50 ) { $DurColor = 'red'; }
			$TxtColor = ($DurColor == 'green') ? 'white' : 'black' ;
			////Here we show to progress bar
			echo __('tinyissue.countdown').' ('.__('tinyissue.day').'s) : ';
			echo '<div class="Percent">';
			echo '<div style="color: '.$DurColoF.'; background-color: '.$DurColor.'; position: absolute; top: 0; left: 0; width: '.(($DurRelat <= 100) ? $DurRelat : 100).'%; height: 100%; text-align: center; line-height:20px;" />'.((($DurRelat  >= 100)) ? $Dur.' / '.@$issue->duration : $Dur).'</div>';
			if ($DurRelat < 100) {  echo '<div style="background-color: gray; position: absolute;  top: 0; left: '.$DurRelat.'%; width: '.(100-$DurRelat).'%; height: 100%; text-align: center; line-height:20px;" />'.$issue->duration.'</div>'; }
			echo '</div>';
	
	
			echo '<br clear="all" />';
		}

		$IssueTags = array();
		if(!empty($issue->tags)) {
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
							<a href="<?php echo \URL::home() . Config::get('application.attachment_path') . '/' . rawurlencode($attachment->filename); ?>" title="<?php echo $attachment->filename; ?>"><img src="<?php echo \URL::home() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . $attachment->filename; ?>" style="max-width: 100px;"  alt="<?php echo $attachment->filename; ?>" /></a>
						<?php else: ?>
							<a href="<?php echo \URL::home() . Config::get('application.attachment_path') . '/' . rawurlencode($attachment->filename); ?>" title="<?php echo $attachment->filename; ?>"><?php echo \URL::home().$attachment->filename; ?></a>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>
				</ul>

				<div class="clr"></div>
			</div>
		</li>

		<?php 
			foreach($issue->activity() as $activity) {
				echo (strlen($activity) > 1) ? $activity : '';
			}
		?>
	</ul>
	<div id="div_currentlyAssigned_name" class="topbar"></div>

	<?php if(Project\Issue::current()->status > 0): ?>

	<div class="new-comment" id="new-comment">
		<?php if(Auth::user()->permission('issue-modify')): ?>
			<ul class="issue-actions">
				<li class="assigned-to">
					<?php echo __('tinyissue.assigned_to'); ?>

					<?php if(Project\Issue::current()->assigned) { ?>
						<span id="span_currentlyAssigned_name">
						<?php echo Project\Issue::current()->assigned->firstname; ?>
						<?php echo Project\Issue::current()->assigned->lastname; ?>
						&nbsp;&nbsp;
						<img src="<?php echo \URL::home();?>app/assets/images/layout/dropdown-arrow.png" height="10" />
						</span>
					<?php } else { ?>
						<span id="span_currentlyAssigned_name">
						<?php echo __('tinyissue.no_one'); ?>
						&nbsp;&nbsp;
						<img src="<?php echo \URL::home();?>app/assets/images/layout/dropdown-arrow.png" height="10" />
						</span>
					<?php } ?>

					<div class="dropdown">
						<ul id="dropdown_ul">
							<li class="unassigned" id="dropdown_li_0">
								<a href="javascript: Reassignment(<?php echo $project->id.','.((Project\Issue::current()->assigned->id == '') ? 0 : Project\Issue::current()->assigned_id).',0,'.Project\Issue::current()->id; ?>);" class="user0<?php echo !Project\Issue::current()->assigned->id ? ' assigned' : ''; ?>" ><?php echo __('tinyissue.no_one'); ?></a>
							</li>
							<?php 
								foreach(Project::current()->users()->get() as $row) {
									echo '<li id="dropdown_li_'.$row->id.'">';
									echo ( $row->id == Project\Issue::current()->assigned->id) ? '<span style="color: #FFF; margin-left: 10px; font-weight: bold;">' : '<a href="javascript: Reassignment('.$project->id.','.((Project\Issue::current()->assigned->id == '') ? 0 : Project\Issue::current()->assigned->id).','.$row->id.','.Project\Issue::current()->id.');" class="user0'.((!Project\Issue::current()->assigned) ? ' assigned' : '').'" >';
									echo $row->firstname . ' ' . $row->lastname; 
									echo ( $row->id == Project\Issue::current()->assigned->id) ? '</span>' : '</a>'; 
									echo '</li>';
								}
							?>
						</ul>
					</div>
				</li>
				<li>
					<?php if (Project\Issue::current()->assigned->id == \Auth::user()->id ) { ?>
					<a href="<?php echo Project\Issue::current()->to('status?status=0'); ?>" onclick="return confirm('<?php echo __('tinyissue.close_issue_confirm'); ?>');" class="close"><?php echo __('tinyissue.close_issue'); ?></a>
					<?php } else { echo '&nbsp;'; } ?>
				</li>
			</ul>
		<?php endif; ?>

		<h4>
			<?php echo __('tinyissue.comment_on_this_issue'); ?>
		</h4>

		<form method="post" id="NewComment" action="" enctype="multipart/form-data">
			<p>
				<textarea name="comment" id="textarea_comment_0" style="width: 98%; height: 90px;"></textarea>
				<!-- New options in the form : percentage of work done after this ticket  -->
				<br />
				<span style="text-align: left;">
				<?php 
					$percent = ((is_object($EtatTodo)) ? (($EtatTodo->weight == 100) ? 91 : $EtatTodo->weight+1) : 10 );
					if (Project\Issue::current()->assigned->id == \Auth::user()->id ) { 
						echo '<b>'.__('tinyissue.percentage_of_work_done').'</b> : ';
						echo '<input type="number" name="Pourcentage" value="'.$percent.'" min="'.$percent.'" max="100" /> %';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '<b>'.__('tinyissue.priority').'</b> : ';
						echo '&nbsp;&nbsp;&nbsp;';
						echo Form::select('status', array(0=>__('tinyissue.priority_desc_0'),1=>__('tinyissue.priority_desc_1'),2=>__('tinyissue.priority_desc_2'),3=>__('tinyissue.priority_desc_3'),4=>__('tinyissue.priority_desc_4'),5=>__('tinyissue.priority_desc_5')), $issue->status); 
					} else {
						if (Auth::user()->role_id != 1 ) { 
							echo '<br />'; 
							echo '<b>'.__('tinyissue.percentage_of_work_done').'</b> : ';
							echo '<input type="hidden" name="Pourcentage" value="'.$percent.'"  /> '.$percent.' %';
							echo '<b>'.__('tinyissue.priority').'</b> : ';
							echo '<input type="hidden" name="status" value="'.$issue->status.'"  /> '.__('tinyissue.priority_desc_'.$issue->status);
						}
					}	
					echo '<br />'; 
				?>					
				</span>
				<div style="text-align: right; width: 98%; margin-top: -25px;"><br /><br /></div>
			<?php  if (Auth::user()->role_id != 1) { ?>
					<!-- Tags modification  -->
					<span style="float:left; font-weight: bold; margin: 7px;"><?php echo  __('tinyissue.tags'); ?></span>
					<div style="width: 73%; float: left">
						<?php
							$TAGS = new Project_Issue_Controller();
							$Tomates = $TAGS->get_edit($issue->id);
							$Retagage = $TAGS->get_retag($issue->id);
							echo Form::text('tags', Input::get('tags', implode(",", $IssueTags)), array('id' => 'tags', 'name' =>'MesTags', 'onblur' =>'AdaptTags(this.value);'));
						?>
						<script type="text/javascript">
						$(function(){
							$('#tags').tagit({
								autocomplete: { source: '<?php echo URL::to('ajax/tags/suggestions/filter'); ?>' }
							});
						});
						//Viendra ici
						<?php echo $Retagage; ?>
						</script>
					</div>
			</p>
			<br /><br />

			<ul id="uploaded-attachments">
				<p>
					<div id="div_upload" class="upload-wrap green-button" onclick="document.getElementById('div_upload').style.width = '280px'; document.getElementById('span_butupload').style.display = 'block'; ">
						<span id="upload_title"><?php echo __('tinyissue.fileupload_button'); ?></span>
						<span id="span_butupload" style="display: none;">
							<input id="file_upload" type="file" name="file_upload" class="green-button" onchange="IMGupload(this);" />
							<input type="hidden" id="uploadbuttontext" name="uploadbuttontext" value="<?php echo __('tinyissue.fileupload_button'); ?>" style="color:#000; background-color:#99F;" />
						</span>
					</div>
					<div id="div_barupload" style="display: none; position:relative; left: 450px; top: -50px">
						<progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
					</div>
				</p>
			</ul>
			<?php  } ?>


				<p>
					<input id="input_submitComment" type="submit" class="button primary" value="<?php echo __('tinyissue.comment'); ?>" />
				<?php if (Project\Issue::current()->assigned->id == \Auth::user()->id ) { ?>
					<input id="input_CloseComment" type="button"  class="button primary button2" style="position: relative; margin-left: 35px;" value="<?php echo __('tinyissue.closecomment_issue'); ?>"  onclick="if (confirm('<?php echo __('tinyissue.close_issue_confirm'); ?>')) { document.getElementById('input_Fermons').value = '0'; document.getElementById('NewComment').submit();}" />
				<?php } ?>
				</p>
			<input name="Fermons" id="input_Fermons" type="hidden" value="<?php echo $issue->status; ?>" />
			<?php 
			//echo Form::hidden('Fermons', $issue->status); 
			?>
			<?php echo Form::hidden('session', Crypter::encrypt(Auth::user()->id)); ?>
			<?php echo Form::hidden('project_id', $project->id); ?>
			<?php echo Form::hidden('token', md5($project->id . time() . \Auth::user()->id . rand(1, 100))); ?>
			<?php echo Form::token(); ?>
		</form>

	</div>

	</div>
	<?php else: ?>
	<?php if (!Project\User::MbrProj(\Auth::user()->id, Project::current()->id)) { echo HTML::link(Project\Issue::current()->to('status?status=3'), __('tinyissue.reopen_issue')); } ?>
	<br /><br />
	<?php endif; ?>
	<br /><br />
</div>


<script type="text/javascript">
var d = new Date();
var t = d.getTime();
var AllTags = "";


function AddTag (Quel,d) {
	if (d == true ) { return true; }
	var Modif = "AddOneTag";
	var IDcomment = 'comment' + new Date().getTime();
	var xhttpTAG = new XMLHttpRequest();
	var NextPage = '<?php echo $_SERVER['REQUEST_URI']; ?>/retag?Modif=' + Modif + '&Quel=' + Quel;
	xhttpTAG.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		if (xhttpTAG.responseText != '' ) {
				var adLi = document.createElement("LI");
				adLi.className = 'comment';
				adLi.id = IDcomment;
				document.getElementById('ul_IssueDiscussion').appendChild(adLi);
				document.getElementById(IDcomment).innerHTML = xhttpTAG.responseText;
			}
		}
	};
	xhttpTAG.open("GET", NextPage, true);
	xhttpTAG.send(); 
}

function Following(Quoi, etat) {
	if (Quoi == 'comments' ) {
		document.getElementById('input_following_attached').checked = etat; 
		document.getElementById('input_following_tags').checked = etat;
		document.getElementById('img_following').src = "<?php echo \URL::home();?>app/assets/images/layout/icon-comments_" + ((etat) ? 1 : 0) + ".png";
	} else if (Quoi != 'comments' && etat  && !document.getElementById('input_following_comments').checked) {
		document.getElementById('input_following_comments').checked = true;
		document.getElementById('img_following').src = "<?php echo \URL::home();?>app/assets/images/layout/icon-comments_1.png";
	}
	var xhttp = new XMLHttpRequest();
	var NextPage = '<?php echo $url; ?>app/application/controllers/ajax/Following.php?Quoi=1&Qui=<?php echo \Auth::user()->id; ?>&Quel=<?php echo Project\Issue::current()->id; ?>&Project=<?php echo Project::current()->id; ?>&Etat=' + ((etat) ? 0 : 1);
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (xhttp.responseText != '' ) {
			}
		}
	};
	xhttp.open("GET", NextPage, true);
	xhttp.send(); 
}

function IMGupload(input) {
	var IDcomment = 'comment' + new Date().getTime();
	var fil = document.getElementById("file_upload").files[0];
	var ext = fil['name'].substring(fil['name'].lastIndexOf('.') + 1).toLowerCase();
	var img = "<?php echo $url; ?>app/assets/images/icons/file_01.png?"; 
	var xhttpCHK = new XMLHttpRequest();
	var CheckPage = '<?php echo $_SERVER['REQUEST_URI']; ?>/checkExt?ext=' + ext;
	xhttpCHK.onreadystatechange = function() {
	   if (this.readyState == 4 && this.status == 200) {
			var formdata = new FormData();
			formdata.append("Loading", fil);
			if (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg") { 
				img = "<?php echo $_SERVER['REQUEST_URI']; ?>uploads/" + fil['name'];
			} else if (xhttpCHK.responseText == 'yes' ) {
				img = "<?php echo $_SERVER['REQUEST_URI']; ?>app/assets/images/upload_type/" + ext + ".png";
			}
			var xhttpUPLD = new XMLHttpRequest();
			var NextPage = '<?php echo $_SERVER['REQUEST_URI']; ?>/upload?Nom=' + fil['name'];
			NextPage = NextPage + '&ext=' + ext;
			NextPage = NextPage + '&fileName=' + fil['name'];
			NextPage = NextPage + '&icone=' + img;
		
			xhttpUPLD.onreadystatechange = function() {
			if (this.readyState == 3 ) {
				document.getElementById('div_barupload').style.display = "block";
			}
			if (this.readyState == 4 && this.status == 200) {
				var bons = ["NonAccepté", "1;", "2;", "3;", "4;"];
				var recu = xhttpUPLD.responseText;
				var resultat = recu.substr(0,2);
				var adLi = document.createElement("LI");

				adLi.className = 'comment';
				adLi.id = IDcomment;
				document.getElementById('ul_IssueDiscussion').appendChild(adLi);

				if ( bons.indexOf(resultat) > 0 ) {
						var msg = recu.substr(2);
						setTimeout(function() { document.getElementById('div_barupload').style.display = "none"; }, 7560);
					} else {
						msg = '<?php echo __('tinyissue.fileupload_failed'); ?><br />' + recu.substr(3);
						document.getElementById('div_barupload').style.display = "none";
					}

					document.getElementById(IDcomment).innerHTML = msg;
					document.getElementById("file_upload").value = "";
					document.getElementById('span_butupload').style.display = 'none';
				}
			};
			xhttpUPLD.open("POST", NextPage, true);
			xhttpUPLD.send(formdata); 
			xhttpUPLD.upload.addEventListener("progress", IMGupload_progressHandler, false);
		}
	};
	xhttpCHK.open("GET", CheckPage, true);
	xhttpCHK.send(); 
}
function IMGupload_progressHandler(event){
	var percent = (event.total == 0) ? 1 : Math.round((event.loaded / event.total) * 100);
	document.getElementById("progressBar").value = percent;
}

function OteTag(Quel) {
	Modif = "eraseTag";
	var IDcomment = 'comment' + new Date().getTime();
	var xhttpTAG = new XMLHttpRequest();
	var NextPage = '<?php echo $_SERVER['REQUEST_URI']; ?>/retag?Modif=' + Modif + '&Quel=' + Quel;
	xhttpTAG.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		if (xhttpTAG.responseText != '' ) {
				var adLi = document.createElement("LI");
				adLi.className = 'comment';
				adLi.id = IDcomment;
				document.getElementById('ul_IssueDiscussion').appendChild(adLi);
				document.getElementById(IDcomment).innerHTML = xhttpTAG.responseText;
			}
		}
	};
	xhttpTAG.open("GET", NextPage, true);
	xhttpTAG.send(); 
}

function Reassignment (Project, Prev, Suiv, Issue) {
	Modif = "reassign";
	var n = new Date();
	var Modif = "false";
	if (n-d > 3000 ) { Modif = "AddOneTag"; }
	var IDcomment = 'comment' + n.getTime();
	var xhttpASGMT = new XMLHttpRequest();
	var NextPage = '<?php echo $_SERVER['REQUEST_URI']; ?>/reassign?Modif=' + Modif + '&Project=' + Project + '&Prev=' + Prev + '&Suiv=' + Suiv + '&Issue=' + Issue;
	xhttpASGMT.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200) {
		if (xhttpASGMT.responseText != '' ) {
				var adLi = document.createElement("LI");
				adLi.className = 'comment';
				adLi.id = IDcomment;
				document.getElementById('ul_IssueDiscussion').appendChild(adLi);
				document.getElementById(IDcomment).innerHTML = xhttpASGMT.responseText;
				
				var MyDropDown = document.getElementById('dropdown_ul');
				var items = MyDropDown.getElementsByTagName("li");
				for (var i = 1; i < items.length; ++i) {
					var monID = items[i].getAttribute('id');
					var num = monID.substring(12);
					var contenu = items[i].innerHTML;
					var nomDeb = contenu.indexOf('>',0);
					var nomFin = contenu.indexOf('<', nomDeb);
					var nom = contenu.substring(nomDeb+1,nomFin);
					var contenu = '<a class="user0" href="javascript: Reassignment(' + Project + ', ' + Prev + ', ' + num + ',' + Issue + ');">' + nom + '</a>';
					if (num == Suiv) {
						contenu = '<span style="color: #FFF; margin-left: 10px; font-weight: bold;">' + nom + '</span>';
						document.getElementById('span_currentlyAssigned_name').innerHTML = nom;
					}
					items[i].innerHTML = contenu;
				}
			}
		}
	};
	xhttpASGMT.open("GET", NextPage, true);
	xhttpASGMT.send(); 
}

<?php
	$wysiwyg = Config::get('application.editor');
	if (trim(@$wysiwyg['directory']) != '') {
		if (file_exists($wysiwyg['directory']."/Bugs_code/showeditor.js")) {
			include $wysiwyg['directory']."/Bugs_code/showeditor.js"; 
			if ($wysiwyg['name'] == 'ckeditor') {
				echo "
				setTimeout(function() {
					showckeditor ('comment');
				} , 567);
				";
			}
		} 
	} 
?>
</script>
