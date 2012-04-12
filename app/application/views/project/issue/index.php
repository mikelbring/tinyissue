<h3>
	<a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue">New Issue</a>

	<?php if(Auth::user()->permission('issue-modify')): ?>
	<a href="<?php echo $issue->to('edit'); ?>" class="edit-issue"><?php echo $issue->title; ?></a>
	<?php else: ?>
	<a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a>
	<?php endif; ?>

	<span>on project <a href="<?php echo $project->to(); ?>"><?php echo $project->name; ?></a></span>
</h3>

<div class="pad">

	<ul class="issue-discussion">
		<li>
			<div class="insides">
				<div class="topbar">
					<strong><?php echo $issue->user->firstname . ' ' . $issue->user->lastname; ?></strong>
					opened this issue <?php echo Time::age(strtotime($issue->created_at)); ?>
				</div>

				<div class="issue">
					<?php echo Project\Issue\Comment::format($issue->body); ?>
				</div>

				<ul class="attachments">
					<?php foreach($issue->attachments()->get() as $attachment): ?>
					<li>
						<?php if(in_array($attachment->fileextension, Config::get('application.image_extensions'))): ?>
							<a href="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . urlencode($attachment->filename); ?>" title="<?php echo $attachment->filename; ?>"><img src="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . $attachment->filename; ?>" style="max-width: 100px;"  alt="<?php echo $attachment->filename; ?>" /></a>
						<?php else: ?>
							<a href="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . urlencode($attachment->filename); ?>" title="<?php echo $attachment->filename; ?>"><?php echo $attachment->filename; ?></a>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>
				</ul>

				<div class="clr"></div>
			</div>
		</li>

		<?php foreach($issue->comments()->get() as $row): ?>
		<li id="comment<?php echo $row->id; ?>" class="comment">
			<div class="insides">
				<div class="topbar">
					<?php if(Auth::user()->permission('issue-modify')): ?>
					<ul>
						<li class="edit-comment">
							<a href="javascript:void(0);" class="edit">Edit</a>
						</li>
						<li class="delete-comment">
						<a href="<?php echo $issue->to('delete_comment?comment=' . $row->id); ?>" class="delete">Delete</a>
						</li>
					</ul>
					<?php endif; ?>
					<strong><?php echo $row->user->firstname . ' ' . $row->user->lastname; ?></strong>
					commented <?php echo Time::age(strtotime($row->created_at)); ?>
				</div>

				<div class="issue">
					<?php echo Project\Issue\Comment::format($row->comment); ?>
				</div>

				<?php if(Auth::user()->permission('issue-modify')): ?>
				<div class="comment-edit">
					<textarea name="body" style="width: 98%; height: 90px;"><?php echo stripslashes($row->comment); ?></textarea>
					<div class="right">
						<a href="javascript:void(0);" class="action save">Save</a>
						<a href="javascript:void(0);" class="action cancel">Cancel</a>
					</div>
				</div>
				<?php endif; ?>

				<ul class="attachments">
					<?php foreach($row->attachments()->get() as $attachment): ?>
					<li>
						<?php if(in_array($attachment->fileextension, Config::get('application.image_extensions'))): ?>
							<a href="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . urlencode($attachment->filename) ?>" title="<?php echo $attachment->filename; ?>"><img src="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . $attachment->filename; ?>" style="max-width: 100px;"  alt="<?php echo $attachment->filename; ?>" /></a>
						<?php else: ?>
							<a href="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . urlencode($attachment->filename); ?>" title="<?php echo $attachment->filename; ?>"><?php echo $attachment->filename; ?></a>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>
				</ul>

				<div class="clr"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>

	<?php if(Project\Issue::current()->status == 1): ?>

	<div class="new-comment" id="new-comment">
		<?php if(Auth::user()->permission('issue-modify')): ?>

			<ul class="issue-actions">
				<li class="assigned-to">
					Assigned to:

					<?php if(Project\Issue::current()->assigned): ?>
						<a href="javascript:void(0);" class="currently_assigned">
						<?php echo Project\Issue::current()->assigned->firstname; ?>
						<?php echo Project\Issue::current()->assigned->lastname; ?>
						</a>
					<?php else: ?>
						<a href="javascript:void(0);" class="currently_assigned">
							No one
						</a>
					<?php endif; ?>

					<div class="dropdown">
						<ul>
							<li class="unassigned"><a href="javascript:void(0);" onclick="issue_assign_change(0, <?php echo Project\Issue::current()->id; ?>);" class="user0<?php echo !Project\Issue::current()->assigned ? ' assigned' : ''; ?>">No one</a></li>
							<?php foreach(Project::current()->users()->get() as $row): ?>
							<li><a href="javascript:void(0);" onclick="issue_assign_change(<?php echo $row->id; ?>, <?php echo Project\Issue::current()->id; ?>);" class="user<?php echo $row->id; ?><?php echo Project\Issue::current()->assigned && $row->id == Project\Issue::current()->assigned->id ? ' assigned' : ''; ?>"><?php echo $row->firstname . ' ' . $row->lastname; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</li>
				<li>
					<a href="<?php echo Project\Issue::current()->to('status?status=0'); ?>" onclick="return confirm('Are you sure you want to close this issue?');" class="close">Close Issue</a>
				</li>
			</ul>
		<?php endif; ?>

		<h4>
			Comment on this issue:
		</h4>

		<form method="post" action="">

			<p>
				<textarea name="comment" style="width: 98%; height: 90px;"></textarea>
			</p>
			<p>
				<input id="upload" type="file" name="file_upload" />
			</p>

			<ul id="uploaded-attachments"></ul>

			<p style="margin-top: 10px;">
				<input type="submit" class="button primary" value="Comment" />
			</p>

			<?php echo Form::hidden('session', Crypter::encrypt(Auth::user()->id)); ?>
			<?php echo Form::hidden('project_id', $project->id); ?>
			<?php echo Form::hidden('token', md5($project->id . time() . \Auth::user()->id . rand(1, 100))); ?>
			<?php echo Form::token(); ?>
		</form>

	</div>


	<?php else: ?>

	<p>
		Closed by <?php echo Project\Issue::current()->closer->firstname . ' ' . Project\Issue::current()->closer->lastname; ?>
		on <?php echo Project\Issue::current()->closed_at; ?>
	</p>

	<p>
		<a href="<?php echo Project\Issue::current()->to('status?status=1'); ?>" class="button success">Reopen</a>
	</p>

	<?php endif; ?>

</div>