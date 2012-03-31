<h3>
	Add User
	<span>Add a new user</span>
</h3>

<div class="pad">

	<form method="post" action="">
		<table class="form">
			<tr>
				<th>
					First Name
				</th>
				<td>
					<input type="text" name="firstname" value="<?php echo Input::old('firstname', $user->firstname); ?>" />

					<?php echo $errors->first('firstname', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th>
					Last Name
				</th>
				<td>
					<input type="text" name="lastname" value="<?php echo Input::old('lastname',$user->lastname);?>" />

					<?php echo $errors->first('lastname', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th>
					Email
				</th>
				<td>
					<input type="text" name="email" value="<?php echo Input::old('email',$user->email)?>" />

					<?php echo $errors->first('email', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th>
					Role
				</th>
				<td>
					<?php echo Form::select('role_id',Role::dropdown(), Input::old('role_id')); ?>
				</td>
			</tr>
				<tr>
					<th></th>
					<td>
						<input type="submit" value="Add User" class="button	primary"/>
					</td>
				</tr>
		</table>

		<?php echo Form::token(); ?>
	</form>

</div>