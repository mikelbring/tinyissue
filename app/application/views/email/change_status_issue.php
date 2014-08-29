<p><?php echo sprintf(__('email.issue_changed'),$issue->title,$project->name,$verb); ?>.</p>

<p><?php echo ucfirst($verb); ?> <?php echo __('email.by'); ?>: <?php echo $actor; ?><br />
<?php echo __('email.more_url'); ?><a href="<?php echo $issue->to(); ?>"><?php echo $issue->to(); ?></a></p>