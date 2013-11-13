<p>Issue "<?php echo $issue->title; ?>" in "<?php echo $project->name; ?>" project was reassigned to you.</p>

<p>Reassigned by: <?php echo $actor; ?><br />
URL: <a href="<?php echo $issue->to(); ?>"><?php echo $issue->to(); ?></a></p>