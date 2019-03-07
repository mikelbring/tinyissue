<div class="blue-box">
	<div class="inside-pad">
		<div class="filter-and-sorting">
			<form method="get" action="">
				<table class="form" style="width: 100%;">
				<tr>
					<th style="width: 10%"><?php echo __('tinyissue.tags'); ?></th>
					<td colspan="4">
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
					</td>
				</tr>
				<tr>
					<th style="width: 10%"><?php echo __('tinyissue.sort_by'); ?></th>
					<td style="width: 35%">
						<?php echo Form::select('sort_by', $sort_options, Input::get('sort_by', '')); ?>
						<?php echo Form::select('sort_order', array('asc' => __('tinyissue.sort_asc'), 'desc' => __('tinyissue.sort_desc')), $sort_order); ?>
						<input name="tag_id" value="<?php echo Input::get('tag_id', '1'); ?>" type="hidden" />
					</td>
					<th style="width: 10%">
						<?php echo __('tinyissue.limits'); ?><br />
					</th>
					<td style="width: 45%; font-weight: bold;">
						<?php echo Form::select('limit_contrib', array( 'assigned_to' => __('tinyissue.limits_contrib_assignedTo'),'created_by'  => __('tinyissue.limits_contrib_createdBy'),'closed_by'   => __('tinyissue.limits_contrib_closedBy'),'updated_by'  => __('tinyissue.limits_contrib_updatedBy')), Input::get('limit_contrib', '')); ?>
						<?php echo Form::select('assigned_to', $assigned_users, Input::get('assigned_to', '')); ?>
					</td>
				</tr>
				<tr>
					<th style="width: 10%">
					</th>
					<td style="width: 35%">
					</td>
					<th style="width: 10%"></th>
					<td style="width: 45%">
						<?php echo Form::select('limit_event', array('created_at' => __('tinyissue.limits_event_createdAt'),'updated_at' => __('tinyissue.limits_event_updatedAt'),'closed_at'  => __('tinyissue.limits_event_closedAt')), Input::get('limit_event', '')); ?>
						<?php echo Form::select('limit_period',array('' => "", 'week' 	=> __('tinyissue.limits_period_week'),'month' 	=> __('tinyissue.limits_period_month'),'months' => __('tinyissue.limits_period_months')), Input::get('limit_period', ''),array("onchange"=>"CalculonsDates(this.value);" ) ); ?>
					</td>
				</tr>
				<tr>
					<th style="width: 10%"></th>
					<td style="width: 35%">
						<input type="submit" value="<?php echo __('tinyissue.show_results'); ?>" class="button primary" />
					</td>
					<th style="width: 10%"></th>
					<td style="width: 45%">
						<?php echo Form::date('DateInit', input::get('DateInit',(date("Y")-1).date("-m-d")), array('id' => 'input_DateInit')); ?>
						<?php echo Form::date('DateFina', input::get('DateFina',date("Y-m-d")), array('id' => 'input_DateFina')); ?>
					</td>
				</tr>
				</table>
			</form>
		</div>
	</div>
</div>

<div class="blue-box">
	<div class="inside-pad">
		<?php if(!$issues): ?>
		<p><?php echo __('tinyissue.no_issues'); ?></p>
		<?php else: ?>
		<ul class="issues" id="sortable">
			<?php foreach($issues as $row):  ?>
			<li class="sortable-li" data-issue-id="<?php echo $row->id; ?>">
				<a href="" class="comments"><?php echo $row->comment_count(); ?></a>

				<?php if(!empty($row->tags)): ?>
				<div class="tags">
				<?php foreach($row->tags()->order_by('tag', 'ASC')->get() as $tag): ?>
						<?php echo '<label class="label"' . ($tag->bgcolor ? ' style="background: ' . $tag->bgcolor . '"' : '') . '>' . $tag->tag . '</label>'; ?>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<a href="" class="id">#<?php echo $row->id; ?></a>
				<div class="data">
					<a href="<?php echo $row->to(); ?>"><?php echo $row->title; ?></a>
					<div class="info">
						<?php echo __('tinyissue.created_by'); ?>
						<strong><?php echo $row->user->firstname . ' ' . $row->user->lastname; ?></strong>
						<?php if(is_null($row->updated_by)): ?>
							<?php echo Time::age(strtotime($row->created_at)); ?>
						<?php endif; ?>

						<?php if(!is_null($row->updated_by)): ?>
							- <?php echo __('tinyissue.updated_by'); ?>
							<strong><?php echo $row->updated->firstname . ' ' . $row->updated->lastname; ?></strong>
							<?php echo Time::age(strtotime($row->updated_at)); ?>
						<?php endif; ?>

						<?php if($row->assigned_to != 0): ?>
							- <?php echo __('tinyissue.assigned_to'); ?>
							<strong><?php echo $row->assigned->firstname . ' ' . $row->assigned->lastname; ?></strong>
						<?php endif; ?>

					</div>
					<?php
					if (@$_GET["tag_id"] == 1) {
						$config_app = require path('public') . 'config.app.php';
						echo '<br /><br />';
						//Percentage of work done
						$SizeXtot = 500;
						$SizeX = $SizeXtot / 100;
						$Etat = Todo::load_todo($row->id);
						if (is_object($Etat)) {
							$Percent = $Etat->weight;
							echo '<div style="position: relative; top: -11px; left: 0; background-color: green; color:white; width: '.($Percent*$SizeX).'px; height: 4px; line-height:4px;" /></div>';
							echo '<div style="position: relative; top: -15px; left: '.(0 + ($Percent*$SizeX)).'px; margin-bottom: -4px; background-color: gray; color:white; width: '.($SizeXtot-($Percent*$SizeX)).'px; height: 4px; text-align: center; line-height:4px;" /></div>';
						} else { $Percent = 10; }
						//Time's going fast!
						//Timing bar, according to the time planified (field projects_issues - duration) for this issue
						$Deb = strtotime($row->created_at);
						$Dur = (time() - $Deb) / 86400;
						if (@$row->duration === 0) { $row->duration = 30; }
						$DurRelat = round(($Dur / $row->duration)*100);
						$DurColor = ($DurRelat < 65) ? 'green' : (( $DurRelat > $config_app['Percent'][3]) ? 'red' : 'yellow') ;
						if ($DurRelat >= 50 && $Percent <= 50 ) { $DurColor = 'yellow'; }
						if ($DurRelat >= 75 && $Percent <= 50 ) { $DurColor = 'red'; }
						echo '<div style="position: relative; top: -10px; left: 0; background-color: '.$DurColor.'; color:white; width: '.(($DurRelat >= 100) ? $SizeXtot : ($DurRelat*$SizeX)).'px; height: 4px; text-align: left; line-height:4px;" /></div>';
						if ($DurRelat < 100) { echo '<div style="position: relative; top: -14px; left: '.(0 + ($DurRelat*$SizeX)).'px; margin-bottom: -24px; background-color: gray; color:white; width: '.($SizeXtot-($DurRelat*$SizeX)).'px; height: 4px; text-align: right; line-height:4px;" /></div>'; }
						echo '<br clear="all" />';
					}

					?>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<div id="sortable-msg"><?php echo __('tinyissue.sortable_issue_howto'); ?></div>
		<div id="sortable-save"><input id="sortable-save-button" class="button primary" type="submit" value="<?php echo __('tinyissue.save'); ?>" /></div>
	</div>
</div>
<script type="text/javascript">
function CalculonsDates(Quoi) {
	var auj = new Date();
	var dat = new Date();
	var duree = 365;
	if (Quoi == 'week') { duree = 7; }
	if (Quoi == 'month') { duree = 31; }
	if (Quoi == 'months') { duree = 62; }
	dat.setDate(auj.getDate() - duree);
	document.getElementById('input_DateInit').value = dat.getFullYear()+"-"+pad((dat.getMonth()+1),2)+"-"+pad(dat.getDate(),2);
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
