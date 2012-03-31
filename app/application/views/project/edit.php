<h3>
	<a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue">New Issue</a>

	Update <?php echo Project::current()->name; ?>
	<span>Change the name, status or delete this project</span>
</h3>


<div class="pad">

	<form method="post" action="">

		<table class="form" style="width: 80%;">
			<tr>
				<th style="width: 10%;">Name</th>
				<td><input type="text" style="width: 98%;" name="name" value="<?php echo Input::old('name', Project::current()->name); ?>" /></td>
			</tr>
			<tr>
				<th>Status</th>
				<td><?php echo Form::select('status', array(1 => 'Open', 0 => 'Archived'), Project::current()->status); ?></td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" value="Update" />
					<input type="submit" name="delete" value="Delete <?php echo Project::current()->name; ?>" onclick="return confirm('Are you sure you want to delete this project? There is no going back!');" />
				</td>
			</tr>
		</table>

	</form>

</div>
