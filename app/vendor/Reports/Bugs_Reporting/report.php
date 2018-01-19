<?php
include_once "BugsRepConfig.php";
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());	
}
$total = 0;
$sql = 'SELECT DISTINCT ISSU.id,title,name,firstname,closed_at,ISSU.created_at,body 
	FROM projects AS PROJ, users AS USER, projects_issues AS ISSU, projects_users AS PUSR
	WHERE PUSR.user_id = ISSU.created_by 
	AND PROJ.id = ISSU.project_id 
	AND USER.id = PUSR.user_id
	ORDER BY name ASC, ISSU.created_at ASC
	';
		
$query = mysqli_query($conn, $sql);
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	
    while($row = $result->fetch_assoc()) {
    $total++;
	}
} else {

}

if (!$query) {
	die ('SQL Error: ' . mysqli_error($conn));
}
?>
<html>
<head>
<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>
	<title>RTS Reporting</title>
	<link href="css/receipt_style.css" rel="stylesheet">
	<style type="text/css">
		body {
			font-size: 15px;
			color: #343d44;
			font-family: "segoe-ui", "open-sans", tahoma, arial;
			padding: 0;
			margin: 0;
		}
		table {
			margin: auto;
			font-family: "Times New Roman";
			font-size: 12px;
		}

		h1 {
			margin: 25px auto 0;
			text-align: center;
			text-transform: uppercase;
			font-size: 17px;
		}

		table td {
			transition: all .5s;
			text-align: center;
		}
		
		/* Table */
		.data-table {
			position: center;
			border-collapse: collapse;
			font-size: 13px;
			min-width: 537px;
		}

		.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			padding: 7px 17px;
		}
		.data-table caption {
			margin: 7px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #508abb;
			color: #FFFFFF;
			border-color: #6ea1cc !important;
			text-transform: uppercase;
			text-align: center;
		}

		/* Table Body */
		.data-table tbody td {
			color: #353535;
		}
		.data-table tbody td:first-child,
		.data-table tbody td:nth-child(4),
		.data-table tbody td:last-child {
			text-align: center;
		}

		.data-table tbody tr:nth-child(odd) td {
			background-color: #f4fbff;
		}
		.data-table tbody tr:hover td {
			background-color: #ffffa2;
			border-color: #ffff0f;
		}

		/* Table Footer */
		.data-table tfoot th {
			background-color: #e5f5ff;
			text-align: right;
		}
		.data-table tfoot th:first-child {
			text-align: left;
		}
		.data-table tbody td:empty {
			background-color: #ffcccc;
		}
	</style>
</head>
<body></br>
<div id="div1">
<div sytle="text-align: center;"><img alt="" src="img/tinyissue.SVG"></div>
	<h1><b>Bugs System</b></h1></br>
	<table class="meta">
								<tr>
					<th><span>PRINT DATE:</span></th>
					<td><span><?php echo "" . date("Y/m/d") . "<br>";?></span></td>
				</tr></table>
	<table class="data-table">
		<caption class="title">General Issues Report</caption>
		<thead>
			<tr>
				<th style="width:10%;">Ticket Number</th>
				<th style="width:20%;">Project Name<br /><br />Issue Title</th>
				<th style="width:50%;">Issue Description</th>
				<th style="width:20%;">Submitted<br />By<br />Closed</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while ($row = mysqli_fetch_array($query)) {
			echo '<tr>
					<td style="width:10%; text-align: center; vertical-align: middle;">#'.$row['id'].'</td>
					<td style="width:20%; text-align: center;">'.$row['name'].'<br /><br />'.$row['title'].'</td>
					<td style="width:50%; text-align: left;">'.$row['body'].'</td>
					<td style="width:20%; text-align: center;">'.$row['created_at'].'<br /><br />'.$row['firstname'].'<br /><br />'.$row['closed_at'].'</td>
				</tr>';
		}?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="4">TOTAL  TICKETS</th>
				<th><?php echo number_format($total); ?></th>
			</tr>
		</tfoot>
	</table>
	</div><br /><br />

	<a style="color:blue; background-color:white;" onclick = "return confirm('Are you sure you want to go back ?')" href="index.php">Back</a>
	| <button style="color:blue; background-color:white;" onclick="printContent('div1')">Print Report</button>
	</body>
</html>
