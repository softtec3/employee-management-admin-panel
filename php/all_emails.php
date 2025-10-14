<?php

$stmt = $conn->prepare("SELECT * FROM emails");
if (!$stmt) {
    die("Preparing error: " . $conn->error);
}
if (!$stmt->execute()) {
    die("Execution error: " . $stmt->error);
}
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $all_emails[] = $row;
    }
}
$stmt->close();
