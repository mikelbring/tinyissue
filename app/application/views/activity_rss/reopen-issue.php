<item>
	<title><?php echo __('tinyissue.label_reopened') . ': ' . $issue->title; ?></title>
	<link><?php echo $issue->to(); ?></link>
	<description><?php echo $issue->title . ' ' . __('tinyissue.was_reopened_by') . ' ' . $user->firstname . ' ' . $user->lastname; ?></description>
	<pubDate><?php echo date("D, d M Y H:i:s O", strtotime($activity->created_at)); ?></pubDate>
</item>
