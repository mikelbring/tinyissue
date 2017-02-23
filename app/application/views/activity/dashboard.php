<h3>
	<?php echo __('tinyissue.dashboard'); ?>
	<span>
		<?php echo __('tinyissue.dashboard_description'); ?>
	</span>
</h3>

<div class="pad">
<?php
	$SansAccent = array();
	foreach(Auth::user()->dashboard() as $project):
		if(!$project['activity']) continue;

		$id = $project['project']->attributes['id'];
		$NomProjet[$id] = $project['project']->name;
		$SansAccent[$id] = htmlentities($NomProjet[$id], ENT_NOQUOTES, 'utf-8');
		$SansAccent[$id] = preg_replace('#&([A-za-z])(?:uml|circ|tilde|acute|grave|cedil|ring);#', '\1', $SansAccent[$id]);
		$SansAccent[$id] = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $SansAccent[$id]);
		$SansAccent[$id] = preg_replace('#&[^;]+;#', '', $SansAccent[$id]);

		foreach($project['activity'] as $activity) {
			$actiProj[$id][] =  $activity;
		}
		asort($SansAccent);
	endforeach;

	foreach ($SansAccent as $id => $name):
?>

	<div class="blue-box">
		<div class="inside-pad">

			<h4>
				<a href="project/<?php echo $id; ?>"><?php echo $NomProjet[$id]; ?></a>
			</h4>

			<ul class="activity">
				<?php foreach($actiProj[$id] as $activity): ?>
				<?php echo $activity; ?>
				<?php endforeach; ?>
			</ul>

			<a href="project/<?php echo $id; ?>"><?php echo $NomProjet[$id]; ?></a>

		</div>
	</div>
	<?php endforeach; ?>
</div>
