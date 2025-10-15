<?php
// get all leave application for logged in user
$stmt = $conn->prepare("SELECT * FROM leave_applications ORDER BY created_at DESC");
if (!$stmt) {
    die("Preparing error: " . $conn->error);
}
if (!$stmt->execute()) {
    die("Execution problem: " . $stmt->error);
}
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_applications[] = $row;
    }
}
$stmt->close();

// approved
if (isset($_GET["approve_application"]) && $_GET["approve_application"] != "") {
    $approve_id = $_GET["approve_application"];
    $status = "approved";

    $stmt = $conn->prepare("UPDATE leave_applications SET status=? WHERE id=?");
    if (!$stmt) {
        die("Preparing error: " . $conn->error);
    }
    $stmt->bind_param("si", $status, $approve_id);

    if (!$stmt->execute()) {
        die("Execution error: " . $stmt->error);
    }
    echo "
        <script>
        alert('Application approved');
        window.location.href ='./index.php';
        </script>
    ";
}
// reject
if (isset($_GET["reject_application"]) && $_GET["reject_application"] != "") {
    $reject_id = $_GET["reject_application"];
    $status = "reject";

    $stmt = $conn->prepare("UPDATE leave_applications SET status=? WHERE id=?");
    if (!$stmt) {
        die("Preparing error: " . $conn->error);
    }
    $stmt->bind_param("si", $status, $reject_id);

    if (!$stmt->execute()) {
        die("Execution error: " . $stmt->error);
    }
    echo "
        <script>
        alert('Application rejected');
        window.location.href ='./index.php';
        </script>
    ";
}
