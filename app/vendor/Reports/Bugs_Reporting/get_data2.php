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
<?php
$date1 = date("Y-m-d", strtotime($_POST['date1']));
$date2 = date("Y-m-d", strtotime($_POST['date2']));
include_once "BugsRepConfig.php";
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if(!$conn){
	die("Fatal Error: Connection Error!");
}
$total = 0;	
$sql = $conn->query("SELECT ISSU.id, ISSU.title, ISSU.body, ISSU.created_at, ISSU.closed_at, CONCAT(USR.firstname, ' ', USR.lastname) AS assignee, CONCAT(CRE.firstname, ' ', CRE.lastname) AS creator, PROJ.name FROM projects_issues AS ISSU LEFT JOIN projects AS PROJ ON PROJ.id = ISSU.project_id LEFT JOIN users AS USR ON USR.id = ISSU.assigned_to LEFT JOIN users AS CRE ON CRE.id = ISSU.created_by WHERE ISSU.created_at BETWEEN '$date1' AND '$date2' AND ISSU.closed_at IS NULL ORDER BY ISSU.closed_at ASC") or die(mysqli_error());
$records = $sql->num_rows;
if($records > 0){
	while($query = $sql->fetch_array()){
		$total++;
	?>
	<tr>
		<td><?php echo $query['name']?></td>
		<td>#<?php echo $query['id']?></td>
		<td><?php echo $query['creator']?></td>
		<td><?php echo $query['assignee']?></td>		
		<td><?php echo $query['title']?></td>
		<td><?php echo $query['body']?></td>
		<td><?php echo $query['created_at']?></td>
		<td><?php echo $query['closed_at']?></td>
	</tr>
	<?php
	}
}else{
		echo '
		<tr>
			<td colspan = "8"><center>Record Not Found</center></td>
		</tr>
		';
}
	?>
	