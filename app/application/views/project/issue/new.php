<?php 
if (Auth::user()->role_id == 1) { 
	echo '<script type="text/javascript" >document.location.href="../../../project/'.$project->id.'/issues";</script>';
}
?>

<?php 
$config_app = require path('public') . 'config.app.php';
$url =\URL::home();

//Clean the sub-directory from previously uploaded files - if ever the previous ticket creation aborted
$chemin = $url."uploads/New/".\Auth::user()->id;
if (file_exists($chemin)) {
	$chemin .= "/"; 
	$attacheds = scandir($chemin);
	foreach ($attacheds as $filename) {
		if (!in_array($filename , array(".", ".."))) { unlink($chemin.$filename); } 
	}
}
?>
<h3>
	<?php echo __('tinyissue.create_a_new_issue'); ?>
	<span><?php echo __('tinyissue.create_a_new_issue_in'); ?> <a href="<?php echo $project->to(); ?>"><?php echo $project->name; ?></a></span>
</h3>

<div class="pad">

	<form method="post" action="" enctype="multipart/form-data">

		<table class="form" style="width: 100%;">
			<tr>
				<th style="width: 10%"><?php echo __('tinyissue.title'); ?></th>
				<td>
					<input type="text" name="title" style="width: 98%; background-color: #FFF; color: #000; border-width: 2px; border-color: #999;" value="<?php echo Input::old('title'); ?>" />

					<?php echo $errors->first('title', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo __('tinyissue.issue'); ?></th>
				<td>
					<textarea name="body" id="texteara_body" style="width: 98%; height: 150px; background-color: #FFF; color: #000; border-width: 2px; border-color: #999;"><?php echo Input::old('body'); ?></textarea>
					<?php echo $errors->first('body', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<ul id="ul_IssueDiscussion" class="issue-discussion">
				</ul>
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

			<tr>
				<th><?php echo __('tinyissue.priority'); ?></th>
				<td>
					<?php echo Form::select('status', array(1=>__('tinyissue.priority_desc_1'),2=>__('tinyissue.priority_desc_2'),3=>__('tinyissue.priority_desc_3'),4=>__('tinyissue.priority_desc_4'),5=>__('tinyissue.priority_desc_5')), 3); ?>
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
var d = new Date();
var t = d.getTime();
var AllTags = "";


function AddTag (Quel,d) {
	return true;
}

function IMGupload(input) {
	var IDcomment = 'comment' + new Date().getTime();
	var fil = document.getElementById("file_upload").files[0];
	var ext = fil['name'].substring(fil['name'].lastIndexOf('.') + 1).toLowerCase();
	var img = "app/assets/images/icons/file_01.png?"; 
	var formdata = new FormData();
	var formdata = new FormData();
	formdata.append("Loading", fil);
	if (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg") { 
		img = "uploads/New/<?php echo \Auth::user()->id.'/'.date("Ymd").'_'; ?>" + fil['name'];
	} else if (xhttpCHK.responseText == 'yes' ) {
		img = "app/assets/images/upload_type/" + ext + ".png";
	}
	var xhttpUPLD = new XMLHttpRequest();
	//var NextPage = '<?php echo substr($_SERVER['REQUEST_URI'], 0, strlen($_SERVER['REQUEST_URI'])-4); ?>/1/upload?Nom=' + fil['name'] + '&Who=' + <?php echo \Auth::user()->id; ?> + '&ext=' + ext;
	var NextPage = '<?php echo substr($_SERVER['REQUEST_URI'], 0, strlen($_SERVER['REQUEST_URI'])-3); ?>1/upload?Nom=' + fil['name'];
	NextPage = NextPage + '&ext=' + ext;
	NextPage = NextPage + '&fileName=' + fil['name'];
	NextPage = NextPage + '&icone=' + img;

	xhttpUPLD.onreadystatechange = function() {
		if (this.readyState == 3 ) {
			document.getElementById('div_barupload').style.display = "block";
		}
		if (this.readyState == 4 && this.status == 200) {
			var adLi = document.createElement("LI");
			adLi.className = 'comment';
			adLi.id = IDcomment;
			document.getElementById('ul_IssueDiscussion').appendChild(adLi);
			var msg = '<div class="insides"><div class="topbar"><div class="data">';
			msg = msg + '<a href="<?php echo $url; ?>uploads/New/<?php echo \Auth::user()->id.'/'.date("Ymd").'_'; ?>' + fil['name'] + "?" + new Date().getTime() + '" target="_blank" />';
			msg = msg + '<img src="<?php echo $url; ?>' + img + '" height="30" align="right" border="0" />';
			msg = msg + '</a>';
			msg = msg + ((xhttpUPLD.responseText != 0) ? '<?php echo __('tinyissue.fileupload_succes'); ?>' : '<?php echo __('tinyissue.fileupload_failed'); ?>' );
			if (xhttpUPLD.responseText != 0) { msg = msg + '<a href="<?php echo $url; ?>uploads/New/<?php echo \Auth::user()->id.'/'.date("Ymd").'_'; ?>' + fil['name'] + "?" + new Date().getTime() + '" tlank">'; }
			msg = msg + '<b>' + fil['name'] + '</b>';
			if (xhttpUPLD.responseText != 0) { msg = msg + '</a>'; }
			
			msg = msg + '</div></div></div>';
			document.getElementById(IDcomment).innerHTML = msg;
			document.getElementById("file_upload").value = "";
			document.getElementById('div_barupload').style.display = "none";
			document.getElementById('span_butupload').style.display = 'none';
		}
	};
	xhttpUPLD.open("POST", NextPage, true);
	xhttpUPLD.send(formdata); 
	xhttpUPLD.upload.addEventListener("progress", IMGupload_progressHandler, false);


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
	    	return true;
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
			return true;
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
					showckeditor ('body');
				} , 567);
				";
			}
		} 
	} 
?>
</script>