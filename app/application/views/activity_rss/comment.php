<item>
	<title><?php echo __('tinyissue.label_comment') . ' ' . __('tinyissue.on_issue') . ': ' . $issue->title . ' ' . __('tinyissue.by') . ' ' . $user->firstname . ' ' . $user->lastname; ?></title>
	<link><?php echo $issue->to(); ?>#comment<?php echo $comment->id; ?></link>
	<description><?php echo str_replace('>', '&gt;', str_replace('<', '&lt;', $comment->comment)); ?></description>
	<pubDate><?php echo date("D, d M Y H:i:s O", strtotime($activity->created_at)); ?></pubDate>
</item>
