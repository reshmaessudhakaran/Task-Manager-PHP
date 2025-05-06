<?php
include 'config.php';
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; }

$id = $_GET['id'];
$res = $conn->query("SELECT * FROM tasks WHERE id=$id AND user_id=".$_SESSION['user']['id']);
$task = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $desc = $conn->real_escape_string($_POST['description']);
    $deadline = $_POST['deadline'];
    $status = $_POST['status'];

    $conn->query("UPDATE tasks SET title='$title', description='$desc', deadline='$deadline', status='$status' WHERE id=$id");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Task</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head>
<body><div class="container mt-4">
    <h3>Edit Task</h3>
    <form method="POST">
        <div class="mb-3"><label>Title</label><input name="title" class="form-control" value="<?= $task['title'] ?>"></div>
        <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"><?= $task['description'] ?></textarea></div>
        <div class="mb-3"><label>Deadline</label><input type="date" name="deadline" class="form-control" value="<?= $task['deadline'] ?>"></div>
        <div class="mb-3"><label>Status</label>
            <select name="status" class="form-select">
                <option <?= $task['status']=='Pending'?'selected':'' ?>>Pending</option>
                <option <?= $task['status']=='In Progress'?'selected':'' ?>>In Progress</option>
                <option <?= $task['status']=='Completed'?'selected':'' ?>>Completed</option>
            </select>
        </div>
        <button class="btn btn-primary">Update Task</button>
    </form>
</div></body></html>
