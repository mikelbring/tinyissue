<?php
$db_host = 'localhost'; // Server Name
$db_user = 'UserName'; // Username
$db_pass = 'PassWord'; // Password
$db_name = 'DataName'; // Database Name

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
