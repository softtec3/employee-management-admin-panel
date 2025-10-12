<?php
$all_invoices = [];
// Get all invoices details
$sql = $conn->query("SELECT * FROM invoices");

if ($sql) {
    // Fetch all rows as an associative array
    $all_invoices = $sql->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Query failed: " . $conn->error;
}
// unpaid invoices
$unpaid_filter = array_filter($all_invoices, function ($invoice) {
    if ($invoice["status"] != "unpaid") {
        return false;
    }
    return true;
});

$unpaid_invoices = array_values($unpaid_filter);

// pending invoices
$pending_filter = array_filter($all_invoices, function ($invoice) {
    if ($invoice["status"] != "pending") {
        return false;
    }
    return true;
});

$pending_invoices = array_values($pending_filter);

// paid invoices
$paid_filter = array_filter($all_invoices, function ($invoice) {
    if ($invoice["status"] != "paid") {
        return false;
    }
    return true;
});

$paid_invoices = array_values($paid_filter);

// rejected invoices
$rejected_filter = array_filter($all_invoices, function ($invoice) {
    if ($invoice["status"] != "rejected") {
        return false;
    }
    return true;
});

$rejected_invoices = array_values($rejected_filter);

// rejected invoices
$requested_filter = array_filter($all_invoices, function ($invoice) {
    if ($invoice["status"] != "requested") {
        return false;
    }
    return true;
});

$requested_invoices = array_values($requested_filter);
