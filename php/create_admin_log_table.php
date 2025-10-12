<?php
require_once("./db_connect.php");

$sql = "CREATE TABLE IF NOT EXISTS admin_panel_log(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) DEFAULT NULL,
    password VARCHAR(100) DEFAULT NULL,
    role VARCHAR(50) DEFAULT NULL,
    passkey INT DEFAULT NULL
)";

if (!$conn->query($sql)) {
    die("Table creation failed" . $conn->error);
} else {
    echo "admin_panel_log table successfully created";
}
