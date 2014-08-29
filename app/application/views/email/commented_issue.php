<p><?php echo sprintf(__('email.new_comment'),$issue->title,$project->name); ?>:</p>

<p><?php echo nl2br($comment); ?></p>

<p><?php echo sprintf(__('email.submitted_by'),$actor); ?><br />
<?php echo __('email.more_url'); ?><a href="<?php echo $issue->to(); ?>"><?php echo $issue->to(); ?></a></p>