
<?php
include 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user']['id'];

// Handle filtering
$status_filter = $_GET['status'] ?? '';
$deadline_filter = $_GET['deadline'] ?? '';

$conditions = "WHERE user_id = $user_id";
if ($status_filter) {
    $conditions .= " AND status = '$status_filter'";
}
if ($deadline_filter === 'past') {
    $conditions .= " AND deadline < CURDATE()";
} elseif ($deadline_filter === 'today') {
    $conditions .= " AND deadline = CURDATE()";
} elseif ($deadline_filter === 'upcoming') {
    $conditions .= " AND deadline > CURDATE()";
}

$query = "SELECT * FROM tasks $conditions ORDER BY deadline ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Task Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between">
        <h3>Welcome, <?= $_SESSION['user']['username'] ?>!</h3>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="mt-3 mb-3">
        <a href="add_task.php" class="btn btn-success">+ Add Task</a>
    </div>

    <!-- Filters -->
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Filter by Status</option>
                <option <?= $status_filter == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option <?= $status_filter == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option <?= $status_filter == 'Completed' ? 'selected' : '' ?>>Completed</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="deadline" class="form-select">
                <option value="">Filter by Deadline</option>
                <option value="past" <?= $deadline_filter == 'past' ? 'selected' : '' ?>>Past</option>
                <option value="today" <?= $deadline_filter == 'today' ? 'selected' : '' ?>>Today</option>
                <option value="upcoming" <?= $deadline_filter == 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Task List -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Complete</th>
            <th>Title</th>
            <th>Description</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($task = $result->fetch_assoc()): ?>
            <tr>
                <td><input type="checkbox" class="mark-completed" data-id="<?= $task['id'] ?>" <?= $task['status'] == 'Completed' ? 'checked' : '' ?>></td>
                <td><?= htmlspecialchars($task['title']) ?></td>
                <td><?= htmlspecialchars($task['description']) ?></td>
                <td><?= $task['deadline'] ?></td>
                <td><?= $task['status'] ?></td>
                <td>
                    <a href="edit_task.php?id=<?= $task['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_task.php?id=<?= $task['id'] ?>" onclick="return confirm('Delete this task?')" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- AJAX for checkbox -->
<script>
    $(".mark-completed").change(function () {
        const taskId = $(this).data("id");
        const completed = $(this).is(":checked");
        $.post("update_status.php", {
            id: taskId,
            status: completed ? 'Completed' : 'Pending'
        }, function (res) {
            location.reload(); // Able to optimize this to update without reload
        });
    });
</script>
</body>
</html>
