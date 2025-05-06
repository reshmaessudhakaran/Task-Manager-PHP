<?php
include 'config.php';
if (!isset($_SESSION['user'])) { exit; }

$id = $_POST['id'];
$status = $_POST['status'];

$conn->query("UPDATE tasks SET status='$status' WHERE id=$id AND user_id=".$_SESSION['user']['id']);
echo "OK";
