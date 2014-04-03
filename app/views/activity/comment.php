<?php

use dflydev\markdown\MarkdownParser;

$parser = new MarkdownParser();

?>
<li onclick="window.location='<?php echo $issue->to(); ?>#comment<?php echo $comment->id; ?>';">
    <div class="tag">
        <label class="label notice"><?php echo trans('tinyissue.label_comment'); ?></label>
    </div>
    <div class="data">
        <span class="comment">
            <?php echo str_replace(array("<p>","</p>"), "", $parser->transform('"' . Str::limit($comment->comment, 60) . '"')); ?>
        </span>
        <?php echo trans('tinyissue.by'); ?>
        <strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong> <?php echo trans('tinyissue.on_issue'); ?> <a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a>
        <span class="time">
            <?php echo date('F jS \a\t g:i A', strtotime($activity->created_at)); ?>
        </span>
    </div>
    <div class="clr"></div>
</li>
