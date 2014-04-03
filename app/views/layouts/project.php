<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Tiny Issue</title>
    <script>
        var siteurl = '<?php echo URL::to('/'); ?>';
        var current_url = '<?php echo URL::current(); ?>';
        var baseurl = '<?php echo URL::getRequest()->getBaseUrl(); ?>';
    </script>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php echo HTML::style('assets/css/app.css') ?>
</head>
<body>
    <?php

    print View::make('layouts/blocks/header')->with('sidebar', $sidebar)->with('active', $active);
    print $content;
    print View::make('layouts/blocks/footer');

    echo HTML::script('assets/js/jquery.js');
    echo HTML::script('assets/js/jquery-ui.js');
    echo HTML::script('assets/js/uploadify/swfobject.js');
    echo HTML::script('assets/js/uploadify/jquery.uploadify.v2.1.4.min.js');
    echo HTML::script('assets/js/project.js');

    ?>
</body>
</html>
