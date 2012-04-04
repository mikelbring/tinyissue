<?php echo View::make('templates/blocks/header')->with('sidebar', $sidebar)->with('active', $active); ?>
<?php echo $content; ?>
<?php echo View::make('templates/blocks/footer'); ?>
