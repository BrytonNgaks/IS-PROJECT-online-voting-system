<?php
include 'includes/conn.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $sql = "SELECT * FROM voters WHERE id = '".$_SESSION['user_id']."'";
    $query = $conn->query($sql);
    if ($query) {
        $voter = $query->fetch_assoc();
    } else {
        // Handle SQL query error
        die("Error: " . $conn->error);
    }
} else {
    header('location: preoverview.php');
    exit();
}
?>
