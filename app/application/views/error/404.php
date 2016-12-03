<!doctype html>
<html>
	<head>
		<meta charset="utf-8">

		<title>Error 404 - Not Found</title>

		<style>
			@import url(//fonts.googleapis.com/css?family=Ubuntu);

			body {
				background: #eee;
				color: #6d6d6d;
				font: normal normal normal 14px/1.253 Ubuntu, sans-serif;
				margin: 0 0 25px 0;
				min-width: 800px;
				padding: 0;
			}

			#main {
				background-clip: padding-box;
				background-color: #fff;
				border:1px solid #ccc;
				border-radius: 5px;
				box-shadow: 0 0 10px #cdcdcd;
				margin: 25px auto 0;
				padding: 30px;
				width: 700px;
				position: relative;
			}

			#main h1 {
				font-family: 'Ubuntu';
				font-size: 38px;
				letter-spacing: 2px;
				margin: 0 0 10px 0;
				padding: 0;
			}

			#main h2 {
				color: #999;
				font-size: 18px;
				letter-spacing: 3px;
				margin: 0 0 25px 0;
				padding: 0 0 0 0;
			}

			#main h3 {
				color: #999;
				margin-top: 24px;
				padding: 0 0 0 0;
			}

			#main h3 {
				font-size: 18px;
			}

			#main p {
				line-height: 25px;
				margin: 10px 0;
			}

			#main pre {
				background-color: #333;
				border-left: 1px solid #d8d8d8;
				border-top: 1px solid #d8d8d8;
				border-radius: 5px;
				color: #eee;
				padding: 10px;
			}

			#main ul {
				margin: 10px 0;
				padding: 0 30px;
			}

			#main li {
				margin: 5px 0;
			}
		</style>
	</head>
	<body>
		<div id="main">
			<?php $messages = array(__('tinyissue.error404_title_0'),__('tinyissue.error404_title_1'),__('tinyissue.error404_title_2')); ?>

			<h1><?php echo $messages[mt_rand(0, 2)]; ?></h1>

			<h2><?php echo __('tinyissue.error404_header'); ?></h2>

			<h3><?php echo __('tinyissue.error404_means'); ?></h3>

			<p><?php echo __('tinyissue.error404_p1'); ?></p>

			<p><?php echo __('tinyissue.error404_p2').' '.HTML::link('/', __('tinyissue.homepage')); ?>?</p>
		</div>
	</body>
</html>