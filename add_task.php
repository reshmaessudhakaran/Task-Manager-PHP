<?php
include 'config.php';
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['description']);
    $deadline = $_POST['deadline'];
    $status = $_POST['status'];
    $user_id = $_SESSION['user']['id'];

    $conn->query("INSERT INTO tasks (user_id, title, description, deadline, status) 
                  VALUES ($user_id, '$title', '$desc', '$deadline', '$status')");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Task</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head>
<body><div class="container mt-4">
    <h3>Add Task</h3>
    <form method="POST">
        <div class="mb-3"><label>Title</label><input name="title" class="form-control" required></div>
        <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"></textarea></div>
        <div class="mb-3"><label>Deadline</label><input type="date" name="deadline" class="form-control" required></div>
        <div class="mb-3"><label>Status</label>
            <select name="status" class="form-select">
                <option>Pending</option>
                <option>In Progress</option>
                <option>Completed</option>
            </select>
        </div>
        <button class="btn btn-primary">Save Task</button>
    </form>
</div></body></html>
