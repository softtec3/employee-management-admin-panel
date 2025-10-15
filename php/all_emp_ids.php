<?php
$stmt = $conn->prepare("SELECT employee_id FROM employee_log");
if (!$stmt) {
    die("Preparing error: " . $conn->error);
}
if (!$stmt->execute()) {
    die("Execution error: " . $stmt->error);
}
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_emp_ids[] = $row;
    }
}
$all_emp_ids = array_column($all_emp_ids, "employee_id");

$stmt->close();
