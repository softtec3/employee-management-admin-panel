<?php
if (isset($_GET["invoice_logout"])) {
    unset($_SESSION["valid_role"]);
    header("Location: ./index.php");
}
