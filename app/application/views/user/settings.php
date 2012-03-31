<h3>
	My Settings
	<span>Update your personal settings</span>
</h3>

<div class="pad">

	<form method="post" action="">

		<table class="form">
			<tr>
				<th>First Name</th>
				<td>
					<input type="text" name="firstname" value="<?php echo Input::old('firstname', $user->firstname); ?>" autocomplete="off" />

					<?php echo $errors->first('firstname', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th>Last Name</th>
				<td>
					<input type="text" name="lastname" value="<?php echo Input::old('lastname',$user->lastname);?>" autocomplete="off" />

					<?php echo $errors->first('lastname', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th>Email</th>
				<td>
					<input type="text" name="email" value="<?php echo Input::old('email',$user->email)?>"  autocomplete="off" />

					<?php echo $errors->first('email', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					Only complete if changing password
				</th>
			</tr>
			<tr>
				<th>New Password</th>
				<td>
					<input type="password" name="password" value="" autocomplete="off" />

					<?php echo $errors->first('password', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th>Confirm</th>
				<td>
					<input type="password" name="password_confirmation" value="" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" value="Update"  class="button	primary"/>
				</td>
			</tr>
		</table>

	</form>

</div>