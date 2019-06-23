<?php
//This is a copy of app/application/views/project/issue/activty/attached-file.php  
$url =\URL::home();
$FileTypes = (is_dir($url.'app/assets/images/upload_type')) ? $FileTypes= scandir($url.'app/assets/images/upload_type') : array();
$What = \DB::table('projects_issues_attachments')->where('id', '=', $activity->attributes['action_id'])->order_by('id','DESC')->get();
?>
<li id="comment<?php echo $activity->id; ?>" class="comment">
	<div class="tag">
		<img src="<?php echo $url; ?>../app/assets/images/icons/attached.png" height="30" align="left" />
	</div>

	<div class="data">
		<span class="comment">
				<?php
						$Who = \User::where('id', '=', $activity->attributes['user_id'] )->get(array('firstname','lastname','email'));
						//Modification du 23 juin 2019
						////Afin de pouvoir traiter encore les fichiers autrefois référencés avec "../" dans la base de données, nous corrigeons ici à la pièce
						////Le nouveau mode d'enregistrement n'impose plus les caractères "../" à l'enregistrement de l'adresse
						if (substr($What[0]->filename, 0, 3) == '../' ) { $What[0]->filename = substr($What[0]->filename, 3); }
						echo '<a href="'.$url.$What[0]->filename.'" target="_blank" />';
						echo '<img src="'.$url.(( in_array(strtolower($What[0]->fileextension), array('jpg','jpeg','gif','png'))) ? $What[0]->filename : ((( in_array(strtolower($What[0]->fileextension).'.png', $FileTypes)) ? '../../../../app/assets/images/upload_type/'.$What[0]->fileextension.'.png' : '../../../../app/assets/images/icons/file_01.png'))).'" height="30" align="right" border="0" />';
						echo '</a>';
						echo '<span style="font-weight: bold; color: #090;">'.__('tinyissue.fileuploaded').'</span> ';
						echo '&nbsp;( <a href="'.$url.$What[0]->filename.'" style="font-weight: bold; color: #009; text-decoration:underline;" target="_blank">';
						echo '<b>'.$activity->attributes['data'].'</b>';
						echo '</a>&nbsp;)&nbsp;';
						echo ''.__('tinyissue.to').' <a href="'.$issue->to().'">'.$issue->title.'</a> '.__('tinyissue.by').' ';
						echo $Who[0]->attributes["firstname"].' '.$Who[0]->attributes["lastname"].' : ';
						echo '<br />';
						echo '<span class="time">'.date(Config::get('application.my_bugs_app.date_format'), strtotime($activity->attributes['updated_at'])).'</span>';
				?>
		</span>
	</div>

	<div class="clr"></div>
</li>
