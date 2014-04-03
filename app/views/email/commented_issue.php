<p>Issue "<?php echo $issue->title; ?>" in "<?php echo $project->name; ?>" project has a new comment.</p>

<p>Submitted by: <?php echo $actor; ?><br />
URL: <a href="<?php echo $issue->to(); ?>"><?php echo $issue->to(); ?></a></p>