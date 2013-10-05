<h3>
	<a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo __('tinyissue.new_issue'); ?></a>

	<?php if(Auth::user()->permission('issue-modify')): ?>
	<a href="<?php echo $issue->to('edit'); ?>" class="edit-issue"><?php echo $issue->title; ?></a>
	<?php else: ?>
	<a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a>
	<?php endif; ?>

	<span><?php echo __('tinyissue.on_project'); ?> <a href="<?php echo $project->to(); ?>"><?php echo $project->name; ?></a></span>
</h3>

<div class="pad">

	<ul class="issue-discussion">
		<li>
			<div class="insides">
				<div class="topbar">
					<strong><?php echo $issue->user->firstname . ' ' . $issue->user->lastname; ?></strong>
					<?php echo __('tinyissue.opened_this_issue'); ?>  <?php echo date('F jS \a\t g:i A', strtotime($issue->created_at)); ?>
				</div>

				<div class="issue">
					<?php echo Project\Issue\Comment::format($issue->body); ?>
				</div>

				<ul class="attachments">
					<?php foreach($issue->attachments()->get() as $attachment): ?>
					<li>
						<?php if(in_array($attachment->fileextension, Config::get('application.image_extensions'))): ?>
							<a href="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . rawurlencode($attachment->filename); ?>" title="<?php echo $attachment->filename; ?>"><img src="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . $attachment->filename; ?>" style="max-width: 100px;"  alt="<?php echo $attachment->filename; ?>" /></a>
						<?php else: ?>
							<a href="<?php echo URL::base() . Config::get('application.attachment_path') . $project->id . '/' . $attachment->upload_token . '/' . rawurlencode($attachment->filename); ?>" title="<?php echo $attachment->filename; ?>"><?php echo $attachment->filename; ?></a>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>
				</ul>

				<div class="clr"></div>
			</div>
		</li>

		<?php foreach($issue->activity() as $activity): ?>
			<?php echo $activity; ?>
		<?php endforeach; ?>

	</ul>

	<?php if(Project\Issue::current()->status == 1): ?>

	<div class="new-comment" id="new-comment">
		<?php if(Auth::user()->permission('issue-modify')): ?>

			<ul class="issue-actions">
				<li class="assigned-to">
				<?php echo __('tinyissue.change_project'); ?>

				<a href="javascript:void(0);" class="current_project">
								<?php echo $project->name; ?>
				</a>
				<div class="dropdown">
					<ul>
					<?php foreach ($projects as $proj): ?>
					<?php if ($proj->id !== $project->id): ?>
					<li>
						<a href="javascript:void(0);" onclick="issue_project_change(<?php echo $proj->id; ?>, <?php echo $issue->id; ?>);">
							<?php echo $proj->name; ?>
						</a>
					</li>
					<?php endif; ?>
					<?php endforeach; ?>
					</ul>
					</div>
				</li>
				<li class="assigned-to">
					<?php echo __('tinyissue.assigned_to'); ?>

					<?php if(Project\Issue::current()->assigned): ?>
						<a href="javascript:void(0);" class="currently_assigned">
						<?php echo Project\Issue::current()->assigned->firstname; ?>
						<?php echo Project\Issue::current()->assigned->lastname; ?>
						</a>
					<?php else: ?>
						<a href="javascript:void(0);" class="currently_assigned">
							<?php echo __('tinyissue.no_one'); ?>
						</a>
					<?php endif; ?>

					<div class="dropdown">
						<ul>
							<li class="unassigned"><a href="javascript:void(0);" onclick="issue_assign_change(0, <?php echo Project\Issue::current()->id; ?>);" class="user0<?php echo !Project\Issue::current()->assigned ? ' assigned' : ''; ?>"><?php echo __('tinyissue.no_one'); ?></a></li>
							<?php foreach(Project::current()->users()->get() as $row): ?>
							<li><a href="javascript:void(0);" onclick="issue_assign_change(<?php echo $row->id; ?>, <?php echo Project\Issue::current()->id; ?>);" class="user<?php echo $row->id; ?><?php echo Project\Issue::current()->assigned && $row->id == Project\Issue::current()->assigned->id ? ' assigned' : ''; ?>"><?php echo $row->firstname . ' ' . $row->lastname; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</li>
				<li>
					<a href="<?php echo Project\Issue::current()->to('status?status=0'); ?>" onclick="return confirm('<?php echo __('tinyissue.close_issue_confirm'); ?>');" class="close"><?php echo __('tinyissue.close_issue'); ?></a>
				</li>
			</ul>
		<?php endif; ?>

		<h4>
			<?php echo __('tinyissue.comment_on_this_issue'); ?>
		</h4>

		<form method="post" action="">

			<p>
				<textarea name="comment" style="width: 98%; height: 90px;"></textarea>
				<a href="http://daringfireball.net/projects/markdown/basics/" target="_blank" style="margin-left: 86%;">Format with Markdown</a>
			</p>
			<p>
				<input id="upload" type="file" name="file_upload" />
			</p>

			<ul id="uploaded-attachments"></ul>

			<p style="margin-top: 10px;">
				<input type="submit" class="button primary" value="<?php echo __('tinyissue.comment'); ?>" />
			</p>

			<?php echo Form::hidden('session', Crypter::encrypt(Auth::user()->id)); ?>
			<?php echo Form::hidden('project_id', $project->id); ?>
			<?php echo Form::hidden('token', md5($project->id . time() . \Auth::user()->id . rand(1, 100))); ?>
			<?php echo Form::token(); ?>
		</form>

	</div>

	</div>

	<?php else: ?>
	<?php echo HTML::link(Project\Issue::current()->to('status?status=1'), __('tinyissue.reopen_issue')); ?>
	<?php endif; ?>
</div>
