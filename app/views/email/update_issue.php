<p>Issue "<?php echo $issue->title; ?>" in "<?php echo $project->name; ?>" project was updated.</p>

<p>Updated by: <?php echo $actor; ?><br />
URL: <a href="<?php echo $issue->to(); ?>"><?php echo $issue->to(); ?></a></p>