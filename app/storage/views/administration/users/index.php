<h3>
	<a href="<?php echo URL::to('administration/users/add');?>" class="addnewuser">Add a new user</a>
	Users
	<span>Add, modify and delete application wide users</span>
</h3>

<div class="pad">

	<div id="users-list">

		<?php foreach($roles as $role):?>

			<h4>
				<?php echo $role->name; ?>
				<span><?php echo $role->description; ?></span>
			</h4>

			<ul>
				<?php foreach(User::where('role_id', '=', $role->id)->where('deleted', '=', 0)->order_by('firstname', 'asc')->get() as $user): ?>
				<li>
					<ul>
						<?php if(!$user->me()): ?>
						<li class="delete">
							<a href="<?php echo URL::to('administration/users/delete/' . $user->id);?>" onClick="return confirm('Are you sure you wish to delete this user?');" class="button tiny error right">Delete</a>
						</li>
						<?php endif; ?>
						<li class="edit">
							<a href="<?php echo URL::to('administration/users/edit/' . $user->id);?>">Edit</a>
						</li>
					</ul>

					<a class="name" href="<?php echo URL::to('administration/users/edit/' . $user->id);?>"><?php echo $user->firstname . ' ' . $user->lastname; ?></a>

				</li>
				<?php endforeach; ?>
			</ul>

		<?php endforeach; ?>

	</div>

</div>