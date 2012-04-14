<h3>
	<a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue">New Issue</a>

	Export <?php echo Project::current()->name; ?>
	<span>Export the issues of this project</span>
</h3>


<div class="pad">

	<form method="post" action="">

		<table class="form" style="width: 80%;">
			<tr>
				<th style="width: 10%;">Format</th>
				<td style="width: 90%;"><?php echo Form::select('format', array(0 => 'csv', 1 => 'xls'),0); ?></td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" value="export" />
				</td>
			</tr>
		</table>

	</form>

</div>
