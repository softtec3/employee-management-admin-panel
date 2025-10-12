<?php
session_start();
require_once("./db_connect.php");
$passkey_error = NULL;
if (isset($_POST["passkey"]) && $_POST["passkey"] != "") {
    $user_id = $_SESSION["user_id"];
    $user_role = $_SESSION["user_role"];
    $passkey = $_POST["passkey"];

    if ($user_role == "super-admin") {
        $stmt = $conn->prepare("SELECT passkey, role FROM admin_panel_log WHERE user_id=? AND role=?");
        if (!$stmt) {
            die("Preparing error: " . $conn->error);
        }
        $stmt->bind_param("ss", $user_id, $user_role);
        if (!$stmt->execute()) {
            die("Execution error: " . $stmt->error);
        }
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = $row;
            }
            if ($user["passkey"] != $passkey) {
                echo "<script>
                alert('Passkey not matched');
                window.location.href = '../index.php';
            </script>";
            } else {
                $_SESSION["valid_role"] = $user["role"];
                header("Location: ../invoices.php");
            }
        } else {
            echo "<script>
                alert('Not allowed. Only super admin allowed');
            </script>";
        }
    } else {
        header("./index.php");
    }
}
