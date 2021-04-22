<?php 
$config_app = require path('public') . 'config.app.php';  
if(!isset($config_app['PriorityColors'])) { $config_app['PriorityColors'] = array("black","Orchid","Cyan","Lime","orange","red"); }
if (!Project\User::MbrProj(\Auth::user()->id, Project::current()->id)) {
	echo '<script>document.location.href="'.URL::to().'";</script>';
}
?>
<div class="blue-box">
	<div class="inside-pad filterANDsort">
		<div class="filter-and-sorting">
			<form method="get" action="">
				<div class="filter-and-sorting_TAGS">
					<div style="position: absolute; left: 0; width: 10%; font-weight: bold; text-align: right; top: 13px;">
						<b><?php echo __('tinyissue.tags'); ?></b>
					</div>
					<div style="position: absolute; left: 11%; width: 85%;">
							<?php echo Form::text('tags', Input::get('tags', ''), array('id' => 'tags')); ?>
							<script type="text/javascript">
							$(function(){
								$('#tags').tagit({
									autocomplete: {
										source: '<?php echo URL::to('ajax/tags/suggestions/filter'); ?>'
									}
								});
							});
							</script>
					</div>
				</div>
				<div class="filter-and-sorting_BAS">

					<div class="filter-and-sorting_FILTER" >
						<div style="position: relative; left: -15%; width: 15%; font-weight: bold; text-align: left; top: 3px; display: inline; margin-right: -10%;">
							<b><?php echo __('tinyissue.limits'); ?></b>
						</div>
						<?php echo Form::select('limit_contrib', array( 'assigned_to' => __('tinyissue.limits_contrib_assignedto'),'created_by'  => __('tinyissue.limits_contrib_createdBy'),'closed_by'   => __('tinyissue.limits_contrib_closedby'),'updated_by'  => __('tinyissue.limits_contrib_updatedby')), Input::get('limit_contrib', '')); ?>
						<?php echo Form::select('assigned_to', $assigned_users, Input::get('assigned_to', '')); ?>
						<br /><br />
						<?php echo Form::select('limit_event', array('created_at' => __('tinyissue.limits_event_createdat'),'updated_at' => __('tinyissue.limits_event_updatedAt'),'closed_at'  => __('tinyissue.limits_event_closedAt')), Input::get('limit_event', '')); ?>
						<?php echo Form::select('limit_period',array('' => "", 'week' 	=> __('tinyissue.limits_period_week'),'month' 	=> __('tinyissue.limits_period_month'),'months' => __('tinyissue.limits_period_months'),'years' => __('tinyissue.limits_period_years')), Input::get('limit_period', ''),array("onchange"=>"CalculonsDates(this.value);" ) ); ?>
						<br /><br />
						<?php echo Form::date('DateInit', input::get('DateInit',(date("Y")-1).date("-m-d")), array('id' => 'input_DateInit')); ?>
						<?php echo Form::date('DateFina', input::get('DateFina',date("Y-m-d")), array('id' => 'input_DateFina')); ?>
					</div>
					
					<div class="filter-and-sorting_SORT">
						<div style="position: absolute; left: -25%; width: 25%; font-weight: bold; text-align: left; top: 2px; display: inline-block;">
							<b><?php echo __('tinyissue.sort_by'); ?></b>
						</div>
						<?php echo Form::select('sort_by', $sort_options, Input::get('sort_by', (Input::get('tag_id','') == 1) ? 'projects_issues.status' : 'projects_issues.updated_at')); ?>
						<?php echo Form::select('sort_order', array('asc' => __('tinyissue.sort_asc'), 'desc' => __('tinyissue.sort_desc')), $sort_order); ?>
						<input name="tag_id" value="<?php echo Input::get('tag_id', '1'); ?>" type="hidden" />
						<br />
						<br /><br />
						<input type="submit" value="<?php echo __('tinyissue.show_results'); ?>" class="button primary" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="blue-box">
	<div class="inside-pad">
		<?php 
			if(!$issues) {
				echo '<p>'.__('tinyissue.no_issues').'</p>';
		} else {
			echo '<ul class="issues" id="sortable">';
			foreach($issues as $row) {
				$follower = \DB::table('following')->where('project','=',0)->where('issue_id','=',$row->id)->where('user_id','=',\Auth::user()->id)->count();
				$follower = ($follower > 0) ? 1 : 0;
				
				echo '<li class="sortable-li" data-issue-id="'.$row->id.'">';
				echo '<a href="javascript: Following('.$row->id.', '.$row->project_id.', '.\Auth::user()->id.');" class="commentstate_'.$follower.'" id="a_following_'.$row->id.'"  style="min-height: '.$follower.'; "  title="'.$row->comment_count().' '.__('tinyissue.following_stand').' / '.(($follower == 0) ? __('tinyissue.following_start') : __('tinyissue.following_stop')).'" >'.$row->comment_count().'</a>';

				if(!empty($row->tags)) {
					echo '<div class="tags">';
					foreach($row->tags()->order_by('tag', 'ASC')->get() as $tag) {
						echo '<label class="label"' . ($tag->bgcolor ? ' style="background: ' . $tag->bgcolor . '"' : '') . '>' . $tag->tag . '</label>';
					}
					echo '</div>';
				} 

				echo '<a href="" class="id">#'.$row->id.'<br /><br /><span style="color: '.$config_app['PriorityColors'][$row->status].'; font-size: 200%;">&#9899;</span></span></a>';
				echo '<div class="data">';
					echo '<a href="'.$row->to().'">'.$row->title.'</a>';
					echo '<div class="info">';
					echo __('tinyissue.created_by'); 
					echo '<strong>'.$row->user->firstname . ' ' . $row->user->lastname.'</strong>';
					if(is_null($row->updated_by)) { echo Time::age(strtotime($row->created_at)); }
					if(!is_null($row->updated_by)) {  
						echo ' - '.__('tinyissue.updated_by');
						echo '<strong>'.$row->updated->firstname . ' ' . $row->updated->lastname.'</strong>';
						echo Time::age(strtotime($row->updated_at));
					} 
					if($row->assigned_to != 0) {
						echo ' - '.__('tinyissue.assigned_to'); 
						echo '<strong>'.$row->assigned->firstname . ' ' . $row->assigned->lastname.'</strong>';
					} 
					echo '</div>';

					if (@$_GET["tag_id"] == 1 && Auth::user()->role_id != 1) {
						echo '<br /><br />';
								//Percentage of work done
								////Calculations
								$SizeXtot = 500;
								$SizeX = $SizeXtot / 100;
//								echo __('tinyissue.issue_percent').' : ';
								$Etat = Todo::load_todo($row->id);
								////Here we show the progress bar
								if (is_object($Etat)) {
									echo '<div class="Percent2">';
									echo '<div style="background-color: green; position: absolute; top: 0; left: 0; width: '.($Etat->weight).'%; height: 100%; text-align: center; line-height:20px;" />'.$Etat->weight.'%</div>';
									echo '<div style="background-color: gray; position: absolute;  top: 0; left: '.$Etat->weight.'%; width: '.(100-$Etat->weight).'%; height: 100%; text-align: center; line-height:20px;" />'.(100-$Etat->weight).'%</div>';
									echo '</div>';
								}
						
								//Time's going fast!
								//Timing bar, according to the time planified (field projects_issues - duration) for this issue
								////Calculations
								$config_app = require path('public') . 'config.app.php';
								$Deb = strtotime($row->created_at);
								$Dur = (time() - $Deb) / 86400;
								if (@$row->duration === 0 || @is_null($row->duration)) { $row->duration = 30; }
								$DurRelat = round(($Dur / $row->duration) * 100);
								$Dur = round($Dur);
								$DurColor = ($DurRelat < 65) ? 'green' : (( $DurRelat > $config_app['Percent'][3]) ? 'red' : 'yellow') ;
								if ($DurRelat >= 50 && @$Etat->weight <= 50 ) { $DurColor = 'yellow'; }
								if ($DurRelat >= 75 && @$Etat->weight <= 50 ) { $DurColor = 'red'; }
								$TxtColor = ($DurColor == 'yellow') ? 'black' : 'white' ;
								////Here we show to progress bar
//								echo __('tinyissue.countdown').' ('.__('tinyissue.day').'s) : ';
								echo '<div class="Percent2">';
								echo '<div style="background-color: '.$DurColor.'; position: absolute; top: 0; left: 0; width: '.(($DurRelat <= 100) ? $DurRelat : 100).'%; height: 100%; text-align: center; line-height:20px;" />'.((($DurRelat  >= 100)) ? $Dur.' / '.@$row->duration : $Dur).'</div>';
								if ($DurRelat < 100) {  echo '<div style="background-color: gray; position: absolute;  top: 0; left: '.$DurRelat.'%; width: '.(100-$DurRelat).'%; height: 100%; text-align: center; line-height:20px;" />'.$row->duration.'</div>'; }
								echo '</div>';
					}
					echo '<br clear="all" />';
					echo '</div>';
					echo '</li>';
	
				}
				echo '</ul>';
			 }
			 if (Auth::user()->role_id != 1) { 
				echo '<div id="sortable-msg">'.__('tinyissue.sortable_issue_howto').'</div>';
			}
		 ?>
		<div id="sortable-save"><input id="sortable-save-button" class="button primary" type="submit" value="<?php echo __('tinyissue.save'); ?>" /></div>
	</div>
</div>
<script type="text/javascript">
function CalculonsDates(Quoi) {
	var auj = new Date();
	var dat = new Date();
	var yyyy = auj.getFullYear();
	var mm = auj.getMonth()+1; //January is 0!
	var dd = auj.getDate();
	mm = (mm < 10) ? '0'+ mm : mm;	
	dd = (dd < 10) ? '0'+ dd : dd;	
	document.getElementById('input_DateInit').value = yyyy + '-' + mm + '-' + dd;
	var duree = 365;
	if (Quoi == 'week') { duree = 7; }
	if (Quoi == 'month') { duree = 31; }
	if (Quoi == 'months') { duree = 62; }
	if (Quoi == 'years') { duree = 365; }
	dat.setDate(dat.getDate() - duree);
	yyyy = dat.getFullYear();
	mm = dat.getMonth()+1; //January is 0!
	dd = dat.getDate();
	mm = (mm < 10) ? '0'+ mm : mm;	
	dd = (dd < 10) ? '0'+ dd : dd;	
	document.getElementById('input_DateFina').value = yyyy + '-' + mm + '-' + dd;
}
function Following(Quel, Project, Qui) {
	<?php if (@$_GET["tag_id"] != 2) { ?> 
	var etat = (document.getElementById('a_following_' + Quel).style.minHeight.substr(0,1) == '0') ? 0 : 1;
	var xhttp = new XMLHttpRequest();
	var NextPage = '../../app/application/controllers/ajax/Following.php?Quoi=1&Qui=' + Qui + '&Quel=' + Quel + '&Project=' + Project + '&Etat=' + etat;
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (xhttp.responseText != '' ) {
				etat = Math.abs(etat-1);
				document.getElementById('a_following_' + Quel).className = "commentstate_" + etat;
				document.getElementById('a_following_' + Quel).style.minHeight = etat+"px";
			}
		}
	};
	xhttp.open("GET", NextPage, true);
	xhttp.send(); 
	<?php } ?>
}
function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}
function OteTag() {
	return true;
}
function AddTag (tags){
	return true;
}

function LitTags () {
	return true;
}
</script>
