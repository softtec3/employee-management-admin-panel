<?php
$created_by = $logged_in_user;
// create project table
$sql = "CREATE TABLE IF NOT EXISTS projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    attachment VARCHAR(255) DEFAULT NULL,
    start_date VARCHAR(100) NOT NULL,
    deadline VARCHAR(100) NOT NULL,
    status ENUM('pending','completed','hold') DEFAULT 'pending',
    created_by VARCHAR(50) NOT NULL,
    completed_date VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admin_panel_log (user_id) ON DELETE CASCADE ON UPDATE CASCADE
)";

if (!$conn->query($sql)) {
    die('Error creating projects table: ' . $conn->error);
}

// create projects_task table
$sql2 = "CREATE TABLE IF NOT EXISTS projects_tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    project_id INT NOT NULL,
    project_title VARCHAR(255) DEFAULT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    attachment VARCHAR(255) DEFAULT NULL,
    correction LONGTEXT DEFAULT NULL,
    assign_to VARCHAR(100) NOT NULL,
    deadline VARCHAR(100) NOT NULL,
    status ENUM('pending','completed','in-progress') DEFAULT 'pending',
    assign_by VARCHAR(100) NOT NULL,
    completed_date VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(assign_to) REFERENCES employee_log(employee_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(assign_by) REFERENCES admin_panel_log(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(project_id) REFERENCES projects(id) ON DELETE CASCADE ON UPDATE CASCADE
)";

if (!$conn->query($sql2)) {
    die('Error creating projects_tasks table: ' . $conn->error);
}

// creating project
if (isset($_POST["project_title"]) && $_POST["project_title"] != "") {
    $project_title = $_POST["project_title"];
    $project_description = $_POST["project_description"];
    $project_attachment = upload_file_get_name("project_attachment");
    $project_start = $_POST["project_start"];
    $project_deadline = $_POST["project_deadline"];


    $stmt = $conn->prepare("INSERT INTO projects (title, description, attachment,start_date, deadline, created_by) VALUES (?,?,?,?,?,?)");

    if (!$stmt) {
        die("Preparing error creating project: " . $conn->error);
    }
    $stmt->bind_param("ssssss", $project_title, $project_description, $project_attachment, $project_start, $project_deadline, $created_by);
    if (!$stmt->execute()) {
        die("execution error: " . $stmt->error);
    }
    $stmt->close();
    echo "
        <script>
            alert('Project successfully created');
            window.location.href = './index.php';
        </script>
    ";
}

// all projects
$all_projects = [];


$stmt = $conn->prepare("SELECT * FROM projects WHERE created_by=?");
if (!$stmt) {
    die("Preparing error: " . $conn->error);
}
$stmt->bind_param("s", $created_by);
if (!$stmt->execute()) {
    die("execution error: " . $stmt->error);
}
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_projects[] = $row;
    }
}
$stmt->close();
// all projects tasks
$all_projects_tasks = [];


$stmt = $conn->prepare("SELECT * FROM projects_tasks WHERE assign_by=?");
if (!$stmt) {
    die("Preparing error: " . $conn->error);
}
$stmt->bind_param("s", $created_by);
if (!$stmt->execute()) {
    die("execution error: " . $stmt->error);
}
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_projects_tasks[] = $row;
    }
}
$stmt->close();

// creating task for project
if (isset($_POST["task_title"]) && $_POST["task_title"] != "") {

    $project_id = (int) $_POST["project_id"];
    $project_title = $_POST["project_title_task"];
    $assign_to = $_POST["assign_to"];
    $assign_by = $_POST["assign_by"];
    $task_title = $_POST["task_title"];
    $task_description = $_POST["task_description"];
    $assign_date = $_POST["assign_date"];
    $task_deadline = $_POST["task_deadline"];
    $task_attachment = upload_file_get_name("task_attachment") ?? NULL;

    $stmt = $conn->prepare("INSERT INTO projects_tasks (project_id, project_title, title, description, attachment, assign_to, deadline, assign_by) VALUES (?,?,?,?,?,?,?,?)");
    if (!$stmt) {
        die("Preparing error creating project task: " . $conn->error);
    }
    $stmt->bind_param("isssssss", $project_id, $project_title, $task_title, $task_description, $task_attachment, $assign_to, $task_deadline, $assign_by);
    if (!$stmt->execute()) {
        die("execution error: " . $stmt->error);
    }
    echo "
        <script>
            alert('Successfully assigned employee');
            window.location.href = './index.php';
        </script>
    ";
    $stmt->close();
}

// complete a project
if (isset($_GET["complete_project"]) && $_GET["complete_project"] != "") {
    $complete_project_id = (int) $_GET["complete_project"];
    $status = "completed";
    $completed_date = date("Y-m-d");
    $stmt = $conn->prepare("UPDATE projects SET status=?, completed_date=? WHERE id=?");
    if (!$stmt) {
        die("Preparing error: " . $conn->error);
    }
    $stmt->bind_param("ssi", $status, $completed_date, $complete_project_id);
    if (!$stmt->execute()) {
        die("execution error: " . $stmt->error);
    }
    if ($stmt->affected_rows > 0) {
        echo "
        <script>
            alert('Successfully updated status');
            window.location.href= './index.php';
        </script>
    ";
    }
    $stmt->close();
}
// Delete a project
if (isset($_GET["delete_project"]) && $_GET["delete_project"] != "") {
    $delete_project_id = (int) $_GET["delete_project"];
    $stmt = $conn->prepare("DELETE FROM projects WHERE id=?");
    if (!$stmt) {
        die("Preparing error: " . $conn->error);
    }
    $stmt->bind_param("i", $delete_project_id);
    if (!$stmt->execute()) {
        die("execution error: " . $stmt->error);
    }
    if ($stmt->affected_rows > 0) {
        echo "
        <script>
            alert('Successfully deleted');
            window.location.href= './index.php';
        </script>
    ";
    }
    $stmt->close();
}
// Delete a task
if (isset($_GET["delete_task"]) && $_GET["delete_task"] != "") {
    $delete_task_id = (int) $_GET["delete_task"];
    $stmt = $conn->prepare("DELETE FROM projects_tasks WHERE id=?");
    if (!$stmt) {
        die("Preparing error: " . $conn->error);
    }
    $stmt->bind_param("i", $delete_task_id);
    if (!$stmt->execute()) {
        die("execution error: " . $stmt->error);
    }
    if ($stmt->affected_rows > 0) {
        echo "
        <script>
            alert('Successfully deleted');
            window.location.href= './index.php';
        </script>
    ";
    }
    $stmt->close();
}

// update correction
if (isset($_POST["correction_id"]) && $_POST["correction_id"]) {
    $correction_id = (int) $_POST["correction_id"];
    $correction = $_POST["correction"];
    $status = "pending";

    $stmt = $conn->prepare("UPDATE projects_tasks SET correction=?,completed_date=null, status=? WHERE id=?");
    if (!$stmt) {
        die("Preparing error: " . $conn->error);
    }
    $stmt->bind_param("ssi", $correction, $status, $correction_id);
    if (!$stmt->execute()) {
        die("execution error: " . $stmt->error);
    }
    if ($stmt->affected_rows > 0) {
        echo "
        <script>
            alert('Successfully given correction');
            window.location.href= './index.php';
        </script>
    ";
    }
    $stmt->close();
}
