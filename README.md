# Task-Manager-PHP

A basic Task Management System built using **Core PHP** (no frameworks) and **MySQL**. It includes user authentication, task CRUD operations, task filtering, AJAX-based task status updates, and a simple responsive frontend using Bootstrap.

---

## 🔧 Features

### ✅ User Authentication
- Simple login and logout system.
- Hardcoded user credentials stored in the MySQL database.
- No user registration.

### 🗂️ Task Management (CRUD)
- **Create** new tasks with: Title, Description, Deadline, and Status (Pending, In Progress, Completed).
- **Read**: List all tasks for the logged-in user.
- **Update**: Edit existing tasks.
- **Delete**: Remove tasks.

### 🔍 Task Filters
- **Filter by Status**: View tasks based on current status.
- **Filter by Deadline**:
  - Past Tasks
  - Today's Tasks
  - Upcoming Tasks

### ⚡ AJAX Functionality
- Mark tasks as "Completed" using a checkbox with AJAX
