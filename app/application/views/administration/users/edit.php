<h3>
	<?php echo __('tinyissue.update_user'); ?>
	<span><?php echo __('tinyissue.update_user_description'); ?></span>
</h3>

<div class="pad">

	<form method="post" action="">

		<table class="form">
			<tr>
				<th><?php echo __('tinyissue.first_name'); ?></th>
				<td>
					<input type="text" name="firstname" value="<?php echo Input::old('firstname', $user->firstname); ?>" autocomplete="off" />

					<?php echo $errors->first('firstname', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo __('tinyissue.last_name'); ?></th>
				<td>
					<input type="text" name="lastname" value="<?php echo Input::old('lastname',$user->lastname);?>" autocomplete="off" />

					<?php echo $errors->first('lastname', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo __('tinyissue.email'); ?></th>
				<td>
					<input type="text" name="email" value="<?php echo Input::old('email',$user->email)?>"  autocomplete="off" />

					<?php echo $errors->first('email', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo __('tinyissue.language'); ?>
				</th>
				<td>	
					<select name="language">
					<?php
						//Language has added in nov 2016
						$Lng = scandir("application/language/");
						$Not = array(".", "..", "all.php");
						foreach ($Lng as $val) { if(!in_array($val, $Not)) { echo '<option value="'.$val.'" '; if ($val == Input::old('language',$user->language)) { echo ' selected="selected" '; } echo '>'.$val.'</option>'; } }
					?>
					</select>
				</td>
			</tr>
			<tr>
				<th><?php echo __('tinyissue.role'); ?></th>
				<td>
					<?php echo Form::select('role_id',Role::dropdown(),$user->role_id); ?>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<?php echo __('tinyissue.only_complete_if_changing_password'); ?>
				</th>
			</tr>
			<tr>
				<th><?php echo __('tinyissue.new_password'); ?></th>
				<td>
					<input type="password" name="password" value="" autocomplete="off" />

					<?php echo $errors->first('password', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo __('tinyissue.confirm'); ?></th>
				<td>
					<input type="password" name="password_confirmation" value="" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" value="<?php echo __('tinyissue.update'); ?>" class="button	primary"/>
				</td>
			</tr>
		</table>

		<?php echo Form::token(); ?>
	</form>

</div>