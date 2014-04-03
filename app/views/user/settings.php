<h3>
    <?php echo trans('tinyissue.my_settings'); ?>
    <span><?php echo trans('tinyissue.my_settings_description'); ?></span>
</h3>

<div class="pad">

    <form method="post" action="">

        <table class="form">
            <tr>
                <th><?php echo trans('tinyissue.first_name'); ?></th>
                <td>
                    <input type="text" name="firstname" value="<?php echo Input::old('firstname', $user->firstname); ?>" autocomplete="off" style="width: 300px;" />

                    <?php echo $errors->first('firstname', '<span class="error">:message</span>'); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo trans('tinyissue.last_name'); ?></th>
                <td>
                    <input type="text" name="lastname" value="<?php echo Input::old('lastname',$user->lastname);?>" autocomplete="off" style="width: 300px;" />

                    <?php echo $errors->first('lastname', '<span class="error">:message</span>'); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo trans('tinyissue.email'); ?></th>
                <td>
                    <input type="text" name="email" value="<?php echo Input::old('email',$user->email)?>"  autocomplete="off" style="width: 300px;" />

                    <?php echo $errors->first('email', '<span class="error">:message</span>'); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo trans('tinyissue.language') ; ?></th>
                <td>
                    <select name="language">
                        <?php foreach(User\Setting::getLanguages($user->language) as $language) :     ?>
                            <option <?php echo $language['selected'] ; ?> value="<?php echo $language['name'] ; ?>"><?php echo $language['name'] ; ?></option>
                        <?php endforeach ; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th colspan="2">
                    <?php echo trans('tinyissue.only_complete_if_changing_password'); ?>
                </th>
            </tr>
            <tr>
                <th><?php echo trans('tinyissue.new_password'); ?></th>
                <td>
                    <input type="password" name="password" value="" autocomplete="off" style="width: 300px;" />

                    <?php echo $errors->first('password', '<span class="error">:message</span>'); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo trans('tinyissue.confirm'); ?></th>
                <td>
                    <input type="password" name="password_confirmation" value="" autocomplete="off" style="width: 300px;" />
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="<?php echo trans('tinyissue.update'); ?>"  class="button    primary"/>
                </td>
            </tr>
        </table>

    </form>

</div>
