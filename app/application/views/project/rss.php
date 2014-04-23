<?php echo "<?xml version='1.0' encoding='UTF-8' ?>"; ?> 
<rss version='2.0'>
<channel>
<title><?php echo 'Project activity RSS for ' . $project->name; ?></title>
<link><?php echo $project->to(); ?></link>
<description><?php echo 'Recent activities in' . $project->name; ?></description>
<language>hu</language>
		<?php foreach($activities as $activity): ?>
		<?php 	echo $activity;	?>
		<?php endforeach; ?>
</channel>
</rss>