<?php echo View::make('layouts/blocks/header')->with('sidebar', $sidebar)->with('active', $active); ?>
<?php echo $content; ?>
<?php echo View::make('layouts/blocks/footer'); ?>
