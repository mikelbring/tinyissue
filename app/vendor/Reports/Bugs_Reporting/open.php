<?php
include_once "BugsRepConfig.php";
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());	
}
$total = 0;
$sql = 'SELECT ISSU.id, ISSU.title, ISSU.body, ISSU.created_at, ISSU.closed_at, CONCAT(USR.firstname, " ", USR.lastname) AS assignee, CONCAT(CRE.firstname, " ", CRE.lastname) AS creator, PROJ.name FROM projects_issues AS ISSU LEFT JOIN projects AS PROJ ON PROJ.id = ISSU.project_id LEFT JOIN users AS USR ON USR.id = ISSU.assigned_to LEFT JOIN users AS CRE ON CRE.id = ISSU.created_by WHERE ISSU.closed_at IS NULL ORDER BY ISSU.closed_at ASC';
		
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
<meta charset = "UTF-8" name = "viewport" content = "width=device-width, initial-scale=1"/>
<link rel="stylesheet" href="datatable/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link rel = "stylesheet" type = "text/css" href = "css/jquery-ui.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<!-- data table js 
	<script src="datatable/jquery.dataTables.min.js"></script>
	<script src="datatable/dataTables.bootstrap.min.js"></script>-->
	
	<!-- data table js 
	<script src="datatable/jquery.dataTables.min.js"></script>
	<script src="datatable/dataTables.bootstrap.min.js"></script>-->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>
$(document).ready(function(){
    $('.search').on('keyup',function(){
        var searchTerm = $(this).val().toLowerCase();
        $('#load_data tbody tr').each(function(){
            var lineStr = $(this).text().toLowerCase();
            if(lineStr.indexOf(searchTerm) === -1){
                $(this).hide();
            }else{
                $(this).show();
            }
        });
    });
});
</script>
<script src = "js/jquery-ui.js"></script>
<script src = "js/ajax2.js"></script>
<script type="text/javascript" src="tableExport.js"></script>
<script type="text/javascript" src="jquery.base64.js"></script>
<script type="text/javascript" src="html2canvas.js"></script>
<script type="text/javascript" src="jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="jspdf/jspdf.js"></script>
<script type="text/javascript" src="jspdf/libs/base64.js"></script>
	<script>
	  $(function () {
	    $('#load_data').DataTable()
	    $('#example2').DataTable({
	      'paging'      : true,
	      'lengthChange': false,
	      'searching'   : true,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : false
	    })
	  })
	</script>
	<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>
	<title>Bugs Reporting</title>
	<style type="text/css">
		body {
			font-size: 15px;
			color: #343d44;
			font-family: "segoe-ui", "open-sans", tahoma, arial;
			padding: 100;
			margin: 100;
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
			background-color: #a03b99;
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
		.data-table tbody td:empty
		{
			background-color: #ffcccc;
		}

@media print {
	* { -webkit-print-color-adjust: exact; }
	html { background: none; padding: 0; }
	body { box-shadow: none; margin: 0; }
	span:empty { display: none; }
	.add, .cut { display: none; }
}

@page { margin: 20; }

	</style>
	<!--<link href="css/receipt_style.css" rel="stylesheet">--> 
</head>
<body>
<center><div class = "form-inline">
				<label><center>Date:</label>
				<input type = "text" class = "form-control" placeholder = "Start"  id = "date1"/>
				<label>To</label>
				<input type = "text" class = "form-control" placeholder = "End"  id = "date2"/>
				<button type = "button" class = "btn btn-primary" id = "btn_search"><span class = "glyphicon glyphicon-search"></span></button> <button type = "button" id = "reset" class = "btn btn-success"><span class = "glyphicon glyphicon-refresh"><span></button>&nbsp;&nbsp;
			<span class="pull-right">
						<input type="text" class="search form-control" placeholder="Search">
					</span></div></center></br>
<div id="div1">
<center><img alt="" src="images/tinyissue.SVG"></center>
	<h1><b>Bugs System Open Issues Report</b></h1></br>
	<table class="meta">
								<tr>
					<th><span>PRINT DATE:</span></th>
					<td><span><?php echo "" . date("Y/m/d") . "<br>";?></span></td>
				</tr></table></br>
	<table class="data-table" id="load_data">
				<thead>
			<tr>
				<th>Projects</th>
				<th>Ticket Number</th>
				<th>Submitted By</th>
				<th>Assigned To</th>								
				<th>Issue Title</th>
				<th>Issue Description</th>
				<th>Date Submitted</th>
				<th>Open / Pending</th>
			</tr>
		</thead>
		<tbody>
		<?php
		while ($row = mysqli_fetch_array($query))
		{
			echo '<tr>
			        <td>'.$row['name'].'</td>
					<td>#'.$row['id'].'</td>
			        <td>'.$row['creator'].'</td>
					<td>'.$row['assignee'].'</td>					
					<td>'.$row['title'].'</td>
					<td>'.$row['body'].'</td>
					<td>'.$row['created_at'].'</td>
					<td>'.$row['closed_at'].'</td>
				</tr>';
		}?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="7">TOTAL  TICKETS</th>
				<th><?php echo number_format($total); ?></th>
			</tr>
		</tfoot>
	</table>
	</div></br></br>
	<center><a style="color:blue; background-color:white;" onclick = "return confirm('Are you sure you want to go back ?')" href="index.php">Back</a>
	| <b><button style="color:blue; background-color:white;" onclick="printContent('div1')">Print Report</button></b></center>

<div class="container">
	<div class="row">
		<b><center><div class="btn-group pull-center" style=" padding: 10px;">
			<div class="dropdown">
  <button style="color:red" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
     <span class="glyphicon glyphicon-th-list"></span> Export Report
   
  <center></b></button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
   
								
								<b><li><a href="#" onclick="$('#load_data').tableExport({type:'excel',escape:'false'});"> <img src="images/xls.png" width="50px"> Excel</a></b></li>
								<b><li><a href="#" onclick="$('#load_data').tableExport({type:'doc',escape:'false'});"> <img src="images/word.png" width="50px"> Word</a></b></li>
								
  </ul>
</div>
		</div>
	</div>		
	
	</body>
</html>
<script type="text/javascript">
//$('#load_data').tableExport();
$(function(){
	$('#example').DataTable();
      }); 
</script>