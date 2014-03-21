<h3>
    <?php echo trans('tinyissue.dashboard'); ?>
    <span>
        <?php echo trans('tinyissue.dashboard_description'); ?>
    </span>
</h3>
<div class="pad">
    <?php

    foreach (Auth::user()->dashboard() as $project):
        if ( ! $project['activity']):
            continue;
        endif;

    ?>
    <div class="blue-box">
        <div class="inside-pad">
            <h4>
                <a href="<?php echo $project['project']->to(); ?>"><?php echo $project['project']->name; ?></a>
            </h4>
            <ul class="activity">
                <?php

                foreach($project['activity'] as $activity):
                    echo $activity;
                endforeach;

                ?>
            </ul>
            <a href="<?php echo $project['project']->to(); ?>" class="view"><?php echo $project['project']->name; ?></a>
        </div>
    </div>
    <?php

    endforeach;

    ?>
</div>
