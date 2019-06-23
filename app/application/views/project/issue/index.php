<?php 
$config_app = require path('public') . 'config.app.php';  
if(!isset($config_app['PriorityColors'])) { $config_app['PriorityColors'] = array("black","Orchid","Cyan","Lime","orange","red"); }
?>
<h3>
	<a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo __('tinyissue.new_issue'); ?></a>

	<span style="color: <?php echo $config_app['PriorityColors'][$issue->status]; ?>; font-size: 200%;">&#9899;
	<?php if(Auth::user()->permission('issue-modify')): ?>
	<a href="<?php echo $issue->to('edit'); ?>" class="edit-issue" style="font-size: 80%; font-weight: bold;"><?php echo $issue->title; ?></a>
	<?php else: ?>
	<a href="<?php echo $issue->to(); ?>" style="font-size: 80%; font-weight: bold;"><?php echo $issue->title; ?></a>
	<?php endif; ?>
	</span>	

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

		echo '&nbsp;&nbsp;&nbsp;';
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

		<?php foreach($issue->activity() as $activity): ?>
			<?php echo $activity; ?>
		<?php endforeach; ?>
	</ul>
	<div id="div_currentlyAssigned_name" class="topbar"></div>

	<?php if(Project\Issue::current()->status > 0): ?>

	<div class="new-comment" id="new-comment">
		<?php if(Auth::user()->permission('issue-modify')): ?>

			<ul class="issue-actions">
				<li class="assigned-to">
					<?php echo __('tinyissue.assigned_to'); ?>

					<?php if(Project\Issue::current()->assigned): ?>
						<span id="span_currentlyAssigned_name">
						<?php echo Project\Issue::current()->assigned->firstname; ?>
						<?php echo Project\Issue::current()->assigned->lastname; ?>
						&nbsp;&nbsp;
						<img src="<?php echo \URL::home();?>/app/assets/images/layout/dropdown-arrow.png" height="10" />
						</span>
					<?php else: ?>
						<span id="span_currentlyAssigned_name">
						<?php echo __('tinyissue.no_one'); ?>
						&nbsp;&nbsp;
						<img src="<?php echo \URL::home();?>/app/assets/images/layout/dropdown-arrow.png" height="10" />
						</span>
					<?php endif; ?>

					<div class="dropdown">
						<ul id="dropdown_ul">
							<li class="unassigned" id="dropdown_li_0"><a href="javascript: Reassignment(<?php echo $project->id.','.((Project\Issue::current()->assigned_to == '') ? 0 : Project\Issue::current()->assigned_id).',0,'.Project\Issue::current()->id; ?>);" class="user0<?php echo !Project\Issue::current()->assigned_id ? ' assigned' : ''; ?>" ><?php echo __('tinyissue.no_one'); ?></a></li>
							<?php 
								foreach(Project::current()->users()->get() as $row) {
									echo '<li id="dropdown_li_'.$row->id.'">';
									echo ( $row->id == Project\Issue::current()->assigned->id) ? '<span style="color: #FFF; margin-left: 10px; font-weight: bold;">' : '<a href="javascript: Reassignment('.$project->id.','.((Project\Issue::current()->assigned_id == '') ? 0 : Project\Issue::current()->assigned_id).','.$row->id.','.Project\Issue::current()->id.');" class="user0'.((!Project\Issue::current()->assigned) ? ' assigned' : '').'" >';
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

		<form method="post" action="" enctype="multipart/form-data">
			<p>
				<textarea name="comment" id="textarea_comment_0" style="width: 98%; height: 90px;"></textarea>
				<!-- New options in the form : percentage of work done after this ticket  -->
				<span style="text-align: left; width: 50%;">
				<?php 
					$percent = ((is_object($Etat)) ? (($Etat->weight == 100) ? 91 : $Etat->weight+1) : 10 );
					if (Project\Issue::current()->assigned->id == \Auth::user()->id ) { 
						echo __('tinyissue.percentage_of_work_done').':';
						echo '<input type="number" name="Pourcentage" value="'.$percent.'" min="'.$percent.'" max="100" /> %';
					} else { 
						echo '<br />'; 
						echo __('tinyissue.percentage_of_work_done').':&nbsp;&nbsp;';
						echo $percent;
						echo '<input type="hidden" name="Pourcentage" value="'.$percent.'"  /> %';
						echo '<br />'; 
					} 
				?>
				</span>
				<div style="text-align: right; width: 98%; margin-top: -25px;">

 				<br /><br />
 				</div>
					<div style="width: 90%">
						<!-- Tags modification  -->
						<?php
							echo __('tinyissue.tags');
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

function IMGupload(input) {
	var IDcomment = 'comment' + new Date().getTime();
	var fil = document.getElementById("file_upload").files[0];
	var ext = fil['name'].substring(fil['name'].lastIndexOf('.') + 1).toLowerCase();
	var img = "../../../../app/assets/images/icons/file_01.png?"; 
	var xhttpCHK = new XMLHttpRequest();
	var CheckPage = '<?php echo $_SERVER['REQUEST_URI']; ?>/checkExt?ext=' + ext;
	xhttpCHK.onreadystatechange = function() {
	   if (this.readyState == 4 && this.status == 200) {
			var formdata = new FormData();
			formdata.append("Loading", fil);
			if (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg") { 
				img = "../../../../uploads/" + fil['name'];
			} else if (xhttpCHK.responseText == 'yes' ) {
				img = "../../../../app/assets/images/upload_type/" + ext + ".png";
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
	var xhttpDAG = new XMLHttpRequest();
	var NextPage = '<?php echo $_SERVER['REQUEST_URI']; ?>/retag?Modif=' + Modif + '&Quel=' + Quel;
	xhttpDAG.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
			var adLi = document.createElement("LI");
			adLi.className = 'comment';
			adLi.id = IDcomment;
			document.getElementById('ul_IssueDiscussion').appendChild(adLi);
			document.getElementById(IDcomment).innerHTML = xhttpDAG.responseText;
	    }
	};
	xhttpDAG.open("GET", NextPage, true);
	xhttpDAG.send(); 
}

function Reassignment (Project, Prev, Suiv, Issue) {
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
			include_once $wysiwyg['directory']."/Bugs_code/showeditor.js"; 
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
	//setTimeout(function() { var debut = LitTags (); } , 497);
</script>
