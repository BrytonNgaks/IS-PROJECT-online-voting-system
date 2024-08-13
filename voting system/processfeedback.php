<?php
// Start the session if necessary
session_start();

// Database connection details
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'votesystem';

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if (isset($_POST['send'])) {
    // Retrieve and sanitize input data
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $feedbackType = mysqli_real_escape_string($conn, $_POST["ftype"]);
    $message = mysqli_real_escape_string($conn, $_POST["tarea"]);

    // Prepare the SQL query
    $query = "INSERT INTO feedback (username, feedback_type, message, created_at) VALUES ('$username', '$feedbackType', '$message', NOW())";

    // Execute the query and handle potential errors
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Feedback has been sent');</script>";
        echo "<script>window.location='preoverview.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Error: Feedback not sent.";
}
?>
