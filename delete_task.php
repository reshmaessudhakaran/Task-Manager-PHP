<?php
include 'config.php';
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }

$id = $_GET['id'];
$conn->query("DELETE FROM tasks WHERE id=$id AND user_id=".$_SESSION['user']['id']);
header("Location: index.php");
exit;
