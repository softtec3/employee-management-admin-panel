<?php
$sql = "CREATE TABLE IF NOT EXISTS tasks(
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50) NOT NULL,
    task_title VARCHAR(255) NOT NULL,
    task_description TEXT NOT NULL,
    task_document TEXT NOT NULL,
    dead_line VARCHAR(100) NOT NULL,
    status ENUM('pending', 'assigned', 'in-progress', 'completed') DEFAULT 'assigned',
    completed_date VARCHAR(100) DEFAULT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(employee_id) REFERENCES employee_log(employee_id) ON DELETE CASCADE ON UPDATE CASCADE
)";

if (!$conn->query($sql)) {
    die("Error creating tasks table:" . $conn->error);
}
// upload file and get name
function upload_file_get_name($name)
{
    if ($_FILES["$name"]) {
        $path = "./uploads/" . $_FILES["$name"]["name"];
        $file_name = $_FILES["$name"]["name"];
        move_uploaded_file($_FILES["$name"]["tmp_name"], $path);
        return $file_name;
    } else {
        die("Something went wrong during file upload!");
    };
};
// Create task
if (isset($_POST["employeeId"]) && $_POST["employeeId"] != "") {
    $employeeId = $_POST["employeeId"];
    $taskTitle = $_POST["taskTitle"];
    $taskDescription = $_POST["taskDescription"];
    $deadline = $_POST["deadline"];
    $task_document = upload_file_get_name("taskDocument");

    $stmt = $conn->prepare("INSERT INTO tasks(employee_id, task_title, task_description, task_document, dead_line) VALUES(?,?,?,?,?)");

    if (!$stmt) {
        die("Preparing error: " . $conn->error);
    }
    $stmt->bind_param("sssss", $employeeId, $taskTitle, $taskDescription, $task_document, $deadline);

    if (!$stmt->execute()) {
        die("Execution error: " . $stmt->error);
    }
    $stmt->close();
    echo "
        <script>
            alert('Successfully assigned');
            window.location.href = './index.php';
        </script>
    ";
}

// Get all tasks

$stmt = $conn->prepare("SELECT * FROM tasks");
if (!$stmt) {
    die("Preparing error: " . $conn->error);
}
if (!$stmt->execute()) {
    die("Execution error: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_tasks[] = $row;
    }
}
$stmt->close();

if (isset($_GET["filter_activity"]) && $_GET["filter_activity"] != "") {
    $target_status  = $_GET["filter_activity"];
    $filtered_arr = array_filter($all_tasks, function ($task) use ($target_status) {
        if ($task["status"] != $target_status) {
            return false;
        }
        return true;
    });
    $all_tasks = array_values($filtered_arr);
}
