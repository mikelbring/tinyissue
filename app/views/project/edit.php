<h3>
    <a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo trans('tinyissue.new_issue'); ?></a>

    <?php echo trans('tinyissue.update'); ?> <?php echo Project::current()->name; ?>
    <span><?php echo trans('tinyissue.update_project_description'); ?></span>
</h3>


<div class="pad">

    <form method="post" action="">

        <table class="form" style="width: 80%;">
            <tr>
                <th style="width: 10%;"><?php echo trans('tinyissue.name'); ?></th>
                <td><input type="text" style="width: 98%;" name="name" value="<?php echo Input::old('name', Project::current()->name); ?>" /></td>
            </tr>
            <tr>
                <th><?php echo trans('tinyissue.status') ?></th>
                <td><?php echo Form::select('status', array(1 => 'Open', 0 => 'Archived'), Project::current()->status); ?></td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="<?php echo trans('tinyissue.update'); ?>" />
                    <input type="submit" name="delete" value="<?php echo trans('tinyissue.delete'); ?> <?php echo Project::current()->name; ?>" onclick="return confirm('<?php echo trans('tinyissue.delete_project_confirm'); ?>');" />
                </td>
            </tr>
        </table>

    </form>

</div>
