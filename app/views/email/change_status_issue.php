<p>Issue "<?php echo $issue->title; ?>" in "<?php echo $project->name; ?>" project was <?php echo $verb; ?>.</p>

<p><?php echo ucfirst($verb); ?> by: <?php echo $actor; ?><br />
URL: <a href="<?php echo $issue->to(); ?>"><?php echo $issue->to(); ?></a></p>