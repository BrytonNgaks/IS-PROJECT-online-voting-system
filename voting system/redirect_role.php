<?php
session_start(); // Start the session

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    if ($role === 'voter') {
        header('Location: login.php'); // Redirect to voter login page
    } elseif ($role === 'admin') {
        header('Location: admin/index.php'); // Redirect to admin login page
    } else {
        $_SESSION['message'] = "Invalid role selected.";
        header('Location: role_selection.php'); // Redirect back to role selection
    }
    exit();
} else {
    header('Location: role_selection.php'); // Redirect back to role selection if accessed directly
    exit();
}
?>
