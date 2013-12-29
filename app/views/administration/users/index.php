<h3>
    <a href="<?php echo URL::to('administration/users/add');?>" class="addnewuser"><?php echo trans('tinyissue.add_new_user'); ?></a>
    <?php echo trans('tinyissue.users'); ?>
    <span><?php echo trans('tinyissue.users_description'); ?></span>
</h3>
<div class="pad">
    <div id="users-list">
        <?php foreach ($roles as $role):?>
            <h4>
                <?php echo $role->name; ?>
                <span><?php echo $role->description; ?></span>
            </h4>
            <ul>
                <?php foreach (User::where('role_id', '=', $role->id)->where('deleted', '=', 0)->orderBy('firstname', 'asc')->get() as $user): ?>
                <li>
                    <ul>
                        <?php if ( ! $user->isMe()): ?>
                        <li class="delete">
                            <a href="<?php echo URL::to('administration/users/delete/' . $user->id);?>" onClick="return confirm('<?php echo trans('tinyissue.delete_user_confirm'); ?>');" class="button tiny error right"><?php echo trans('tinyissue.delete'); ?></a>
                        </li>
                        <?php endif; ?>
                        <li class="edit">
                            <a href="<?php echo URL::to('administration/users/edit/' . $user->id);?>"><?php echo trans('tinyissue.edit'); ?></a>
                        </li>
                    </ul>
                    <a class="name" href="<?php echo URL::to('administration/users/edit/' . $user->id);?>"><?php echo $user->firstname . ' ' . $user->lastname; ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    </div>
</div>
