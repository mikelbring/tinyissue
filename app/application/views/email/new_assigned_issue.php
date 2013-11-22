<p>New issue "<?php echo $issue->title; ?>" was submitted to "<?php echo $project->name; ?>" project and assigned to you.</p>

<p>Created by: <?php echo $issue->user->firstname . ' ' . $issue->user->lastname; ?><br />
URL: <a href="<?php echo $issue->to(); ?>"><?php echo $issue->to(); ?></a></p>