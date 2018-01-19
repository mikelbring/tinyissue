<thead>
			<tr>
				<th>Projects</th>
				<th>Ticket Number</th>
				<th>Submitted By<br /><br />Assigned To</th>								
				<th>Issue Title<br /><br />Issue Description</th>
				<th>Date Submitted<br /><br />Date Updated</th>
				<th>Issue Comments</th>
				<th>Commented_By</th>
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
$sql = $conn->query("SELECT ISSU.id, ISSU.title, ISSU.body, ISSU.created_at, CONCAT(USR.firstname, ' ', USR.lastname) AS assignee, CONCAT(CRE.firstname, ' ', CRE.lastname) AS creator, CONCAT(USC.firstname, ' ', USC.lastname) AS commenter, PROJ.name, PIC.comment, PIC.updated_at FROM projects_issues AS ISSU LEFT JOIN projects AS PROJ ON PROJ.id = ISSU.project_id LEFT JOIN users AS USR ON USR.id = ISSU.assigned_to LEFT JOIN users AS CRE ON CRE.id = ISSU.created_by LEFT JOIN projects_issues_comments AS PIC ON ISSU.id = PIC.issue_id LEFT JOIN users AS USC ON USC.id = PIC.created_by WHERE PIC.updated_at BETWEEN '$date1' AND '$date2' ORDER BY PIC.updated_at ASC") or die(mysqli_error());
$records = $sql->num_rows;
if($records > 0){
	while($query = $sql->fetch_array()){
		$total++;
	?>
	<tr>
		<td><?php echo $query['name']?></td>
		<td>#<?php echo $query['id']?></td>
		<td><?php echo $query['creator']?></br></br><?php echo $query['assignee']?></td>		
		<td><b><?php echo $query['title']?></b></br></br><?php echo $query['body']?></td>
		<td><?php echo $query['created_at']?></br></br><?php echo $query['updated_at']?></td>
		<td><?php echo $query['comment']?></td>
		<td><?php echo $query['commenter']?></td>
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
	