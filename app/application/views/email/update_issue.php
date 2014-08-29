<p><?php echo sprintf(__('email.update'),$issue->title,$project->name); ?>.</p>

<p><?php echo nl2br($issue->body); ?></p>

<p><?php echo sprintf(__('email.updated_by'),$actor); ?><br />
<?php echo __('email.more_url'); ?><a href="<?php echo $issue->to(); ?>"><?php echo $issue->to(); ?></a></p>