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
session_start();
?>
<div id="container">
	<form name="Questionne" id="Questionne" action="../projects/new" method="POST">
		<table class="form">
			<tr>
				<td style="text-align: center;">
					<?php
						echo '<h2>'.$MyLng['Complete_awesome'].'</h2>';
						echo '<p style="font-size: 120%;">'.$MyLng['Complete_presentation'].'</p>';
					?>
				</td>
			</tr>
			<tr>
				<td style="text-align: left;">
					<b>Next</b> (please chose)<br />
					<p style="margin-left: 50px;">
						<input type="radio" name="StartingPage" value="../projects/new" checked="checked" onclick="ChoseNextPage(this.value);" />Initiate a new project<br />
						<input type="radio" name="StartingPage" value="../users/add"  onclick="ChoseNextPage(this.value);" />Add user<br />
						<input type="radio" name="StartingPage" value="../"  onclick="ChoseNextPage(this.value);" />Have an overview<br />
						<input type="hidden" name="email" value="<?php echo $_SESSION["email"]; ?>" /><br />
						<input type="hidden" name="password" value="<?php echo $_SESSION["password"]; ?>" /><br />
					</p>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">
					<p><a href="javascript:GoToNextPage();" class="button primary"><?php echo $MyLng['Complete_login'] ?></a></p>
					<div id="CountDown" style="width: 100%; text-align: center; padding-top:10px;">25</div>
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
var CountDown = 25;
var nextpage = "../projects/new";
function ChoseNextPage(p) {
	nextpage = p;
}
function GoToNextPage() {
	document.Questionne.action = nextpage;
	document.Questionne.submit();
}
setInterval(function () {
	document.getElementById('CountDown').innerHTML = CountDown;
	if (--CountDown <= 0) { document.location.href = nextpage;}
}, 1000);
</script>
</body>
</html>