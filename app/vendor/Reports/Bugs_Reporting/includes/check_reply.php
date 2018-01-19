<?php
include '../database/config.php';
if (isset($_GET['reply'])) {
$error_code = mysqli_real_escape_string($conn, $_GET['reply']);

$sql = "SELECT * FROM tbl_alerts WHERE code = '$error_code'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
     $description = $row['description'];
     $type = $row['type'];
     print '
<div class="alert alert-'.$type.'">
'.$description.'
</div>';
    }
} else {
}
$conn->close();

}

?>