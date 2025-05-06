<?php
// config.php
$host = 'localhost';
$db = 'task_manager';
$user = 'root';
$pass = ''; // Your MySQL password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();
?>
