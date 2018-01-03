<?php
//date_default_timezone_set($shop_timezone);

//$today = strtotime(date('Y/m/d'));

$system_users = 0;
$tickets = 0;
$closed = 0;
$open = 0;


$sql = "SELECT * FROM projects_issues";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	
    while($row = $result->fetch_assoc()) {
    $tickets++;

    }
} else {

}
$sql = "SELECT * FROM projects_issues WHERE closed_at IS NULL";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	
    while($row = $result->fetch_assoc()) {
    $open++;

    }
} else {

}
$sql = "SELECT * FROM projects_issues WHERE closed_at IS NOT NULL";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	
    while($row = $result->fetch_assoc()) {
    $closed++;

    }
} else {

}
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
$system_users++;
    }
} else {

}

$conn->close();

?>


