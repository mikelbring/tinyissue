<p><?php echo sprintf(__('email.reassignment'),$issue->title,$project->name); ?>.</p>

<p><?php echo nl2br($issue->body); ?></p>

<p><?php echo sprintf(__('email.reassigned_by'),$actor); ?><br />
<?php echo __('email.more_url'); ?><a href="<?php echo $issue->to(); ?>"><?php echo $issue->to(); ?></a></p>

<!--

<pre>
	<h2>Issue</h2>
	<?php // print_r($issue);?>
	
		<h2>Project</h2>
	<?php // print_r($project);?>
</pre>
-->
