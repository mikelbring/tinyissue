<!DOCTYPE html>
<html>
<title>Installation bugs complete</title>
<head>
	<link href="../app/assets/css/install.css" media="all" type="text/css" rel="stylesheet">

</head>
<body>
<?php
$EnLng = require_once("../app/application/language/en/install.php");
if (!isset($_GET["Lng"]) || !file_exists("../app/application/language/".@$_GET["Lng"]."/install.php")) { $_GET["Lng"] = 'en'; }
if (@$_GET["Lng"] != 'en' ) { $MyLng = require_once("../app/application/language/".$_GET["Lng"]."/install.php"); $MyLng = array_merge($EnLng, $MyLng); } else {$MyLng = $EnLng; }
?>
<div id="container">
		<table class="form">
			<tr>
				<td>
					<?php
						echo '<h2>'.$MyLng['Complete_awesome'].'</h2>';
						echo '<p>'.$MyLng['Complete_presentation'].'</p>';
					?>
					<p><a href="../" class="button primary"><?php echo $MyLng['Complete_login'] ?></a></p>
					<div id="CountDown" style="width: 100%; text-align: center; padding-top:10px;">25</div>
				</td>
			</tr>
		</table>
</div>
<script type="text/javascript">
var CountDown = 25;
setInterval(function () {
	document.getElementById('CountDown').innerHTML = CountDown;
	if (--CountDown <= 0) { document.location.href = "../";}
}, 1000);
</script>
</body>
</html>