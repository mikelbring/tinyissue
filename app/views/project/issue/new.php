<h3>
    <?php echo trans('tinyissue.create_a_new_issue'); ?>
    <span><?php echo trans('tinyissue.create_a_new_issue_in'); ?> <a href="<?php echo $project->to(); ?>"><?php echo $project->name; ?></a></span>
</h3>
<div class="pad">
    <form method="post">
        <table class="form" style="width: 100%;">
            <tr>
                <th style="width: 10%"><?php echo trans('tinyissue.title'); ?></th>
                <td>
                    <input type="text" name="title" style="width: 98%;" />

                    <?php echo $errors->first('title', '<span class="error">:message</span>'); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo trans('tinyissue.issue'); ?></th>
                <td>
                    <textarea name="body" style="width: 98%; height: 150px;"></textarea>
                    <?php echo $errors->first('body', '<span class="error">:message</span>'); ?>
                </td>
            </tr>
            <?php if(Auth::user()->permission('issue-modify')): ?>
            <tr>
                <th><?php echo trans('tinyissue.assigned_to'); ?></th>
                <td>
                    <?php echo Form::select('assigned_to', array(0 => '') + Project\User::dropdown($project->users()->get())); ?>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th><?php echo trans('tinyissue.attachments'); ?></th>
                <td>
                    <input id="upload" type="file" name="file_upload" />

                    <ul id="uploaded-attachments"></ul>
                </td>
            </tr>
            <tr>
                <th></th>
                <td><input type="submit" value="<?php echo trans('tinyissue.create_issue'); ?>" class="button primary" /></td>
            </tr>
        </table>
        <?php echo Form::hidden('session', Crypt::encrypt(Auth::user()->id)); ?>
        <?php echo Form::hidden('project_id', Project::current()->id); ?>
        <?php echo Form::hidden('token', md5(Project::current()->id . time() . \Auth::user()->id . rand(1, 100))); ?>
        <?php echo Form::token(); ?>
    </form>
</div>
