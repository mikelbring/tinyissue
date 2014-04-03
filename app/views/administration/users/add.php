<h3>
    <?php echo trans('tinyissue.add_user'); ?>
    <span><?php echo trans('tinyissue.add_new_user'); ?></span>
</h3>

<div class="pad">

    <form method="post" action="">
        <table class="form">
            <tr>
                <th>
                    <?php echo trans('tinyissue.first_name'); ?>
                </th>
                <td>
                    <input type="text" name="firstname" value="<?php echo Input::old('firstname'); ?>" />

                    <?php echo $errors->first('firstname', '<span class="error">:message</span>'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo trans('tinyissue.last_name'); ?>
                </th>
                <td>
                    <input type="text" name="lastname" value="<?php echo Input::old('lastname');?>" />

                    <?php echo $errors->first('lastname', '<span class="error">:message</span>'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo trans('tinyissue.email'); ?>
                </th>
                <td>
                    <input type="text" name="email" value="<?php echo Input::old('email')?>" />

                    <?php echo $errors->first('email', '<span class="error">:message</span>'); ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo trans('tinyissue.role'); ?>
                </th>
                <td>
                    <?php echo Form::select('role_id',Role::dropdown(), Input::old('role_id')); ?>
                </td>
            </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="<?php echo trans('tinyissue.add_user'); ?>" class="button    primary"/>
                    </td>
                </tr>
        </table>

        <?php echo Form::token(); ?>
    </form>

</div>