<?php
// all employees from employee_personal_details

$all_employees  = [];

$stmt = $conn->prepare("SELECT * FROM employee_personal_details ORDER BY id DESC");
if (!$stmt) {
    die("Preparing error: " . $conn->error);
}
if (!$stmt->execute()) {
    die("Execution error: " . $stmt->error);
}
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_employees[] = $row;
    }
}
$stmt->close();
if (isset($_GET["searchEmployeeId"]) && $_GET["searchEmployeeId"] != "") {
    $target_id = $_GET["searchEmployeeId"];
    $find_one_filter = array_filter($all_employees, function ($employee) use ($target_id) {
        if ($employee["employee_id"] == $target_id) {
            return true;
        }
        return false;
    });
    $all_employees = array_values($find_one_filter);
}
// specific target employee details for view

if (isset($_GET["view_id"]) && $_GET["view_id"] != "") {
    $view_id = (int) $_GET["view_id"];

    $stmt = $conn->prepare("SELECT * FROM employee_personal_details WHERE id=?");
    if (!$stmt) {
        die("preparing error: " . $conn->error);
    }
    $stmt->bind_param("i", $view_id);
    if (!$stmt->execute()) {
        die("execution error: " . $stmt->error);
    }
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $target_employee = $row;
        }
    }
    $stmt->close();

    // Specific target employee documents
    //nid from employee_documents
    $stmt = $conn->prepare("SELECT ssn_no, ssn_photo FROM employee_documents WHERE employee_id=?");
    if (!$stmt) {
        die("preparing error: " . $conn->error);
    }
    $stmt->bind_param("s", $target_employee["employee_id"]);
    if (!$stmt->execute()) {
        die("execution problem: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $target_nid_doc = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc())
            $target_nid_doc = $row;
    }
    $stmt->close();

    // all other documents from extra_documents table
    $emp_id_target = $target_employee["employee_id"];
    $stmt = $conn->prepare("SELECT * FROM extra_documents WHERE employee_id=?");
    if (!$stmt) {
        die("Preparing error: " . $conn->error);
    }
    $stmt->bind_param("s", $emp_id_target);
    if (!$stmt->execute()) {
        die("Execution error: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $all_other_documents = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $all_other_documents[] = $row;
        }
    }
    $stmt->close();
}

// delete an employee

if (isset($_GET["deleteEmployeeId"]) && $_GET["deleteEmployeeId"] != "") {
    $delete_id = $_GET["deleteEmployeeId"];
    $stmt = $conn->prepare("DELETE FROM employee_log WHERE employee_id=?");
    if (!$stmt) {
        die("Preparing error: " . $conn->error);
    }
    $stmt->bind_param("s", $delete_id);
    if (!$stmt->execute()) {
        die("execution error: " . $stmt->error);
    }
    if ($stmt->affected_rows > 0) {

        echo "
            <script>
                alert('User deleted');
                window.location.href= './index.php';
            </script>
        ";
    }
}
