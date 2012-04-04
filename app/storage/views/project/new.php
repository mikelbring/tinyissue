<h3>
	Create a new project
	<span>Create a new project and select users to assign to it. You can assign users later as well.</span>
</h3>

<div class="pad">

	<form method="post" action="" id="submit-project">
		<table class="form" style="width: 80%;">
			<tr>
				<th style="width: 10%;">Name</th>
				<td><input type="text" name="name" style="width: 90%;" /></td>
			</tr>
		</table>

		<ul class="assign-users" style="display: none">
			<li class="project-user<?php echo Auth::user()->id; ?>">
				<a href="javascript:void(0);" onclick="$('.project-user<?php echo Auth::user()->id; ?>').remove();" class="delete">Remove</a>
				<?php echo Auth::user()->firstname . ' ' . Auth::user()->lastname; ?>
				<input type="hidden" name="user[]" value="<?php echo Auth::user()->id; ?>" />
			</li>
		</ul>
	</form>

	<table class="form" style="width: 80%;">
		<tr>
			<th style="width: 10%;">Assign Users</th>
			<td>
				<input type="text" id="add-user-project" style="margin: 0;" placeholder="Assign a user" />

				<ul class="assign-users" style="width: 218px;">
					<li class="project-user<?php echo Auth::user()->id; ?>">
						<a href="javascript:void(0);" onclick="$('.project-user<?php echo Auth::user()->id; ?>').remove();" class="delete">Remove</a>
						<?php echo Auth::user()->firstname . ' ' . Auth::user()->lastname; ?>
						<input type="hidden" name="user[]" value="<?php echo Auth::user()->id; ?>" />
					</li>
				</ul>
			</td>
		</tr>
		<tr>
			<th></th>
			<td><input type="submit" onclick="$('#submit-project').submit();" value="Create Project"  /></td>
		</tr>
	</table>

</div>