<p><?php echo sprintf(__('email.new_issue'),$issue->title,$project->name); ?>.</p>

<p><?php echo nl2br($issue->body); ?></p>

<p><?php echo sprintf(__('email.submitted_by'),$issue->user->firstname . ' ' . $issue->user->lastname); ?><br />
<?php echo __('email.more_url'); ?><a href="<?php echo $issue->to(); ?>"><?php echo $issue->to(); ?></a></p>