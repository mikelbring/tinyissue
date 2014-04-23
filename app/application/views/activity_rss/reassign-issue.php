<item>
	<title><?php echo __('tinyissue.label_reassigned') . ': ' . $issue->title; ?></title>
	<link><?php echo $issue->to(); ?></link>
	<description><?php if($activity->action_id > 0): ?>
	<?php echo $issue->title . ' ' . __('tinyissue.was_reassigned_to') . ' ' . $user->firstname . ' ' . $user->lastname; ?>
	<?php else: ?>
	<?php echo $issue->title . ' ' . __('tinyissue.was_reassigned_to') . ' ' . __('tinyissue.no_one'); ?>
	<?php endif; ?>
	<?php echo __('tinyissue.by') . ' ' . $user->firstname . ' ' . $user->lastname; ?></description>
	<pubDate><?php echo date("D, d M Y H:i:s O", strtotime($activity->created_at)); ?></pubDate>
</item>
