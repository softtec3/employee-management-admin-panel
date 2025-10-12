
<?php
session_start();
$login_error  = NULL;

if (isset($_POST["user_id"]) && $_POST["user_id"] != "") {
    $user_id = $_POST["user_id"];
    $user_password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM admin_panel_log WHERE user_id=?");
    if (!$stmt) {
        die("Preparing error" . $conn->error);
    }
    $stmt->bind_param("s", $user_id);

    if (!$stmt->execute()) {
        die("Execution error: " . $stmt->error);
    }
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user = $row;
        }
        if ($user["password"] != $user_password) {
            $login_error = "Password not matched";
        } else {
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["user_role"] = $user["role"];
            header("Location: ./index.php");
        }
    } else {
        $login_error = "No user found";
    }
}
?>