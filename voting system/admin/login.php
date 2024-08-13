<?php
    session_start();
    include 'includes/conn.php'; // Ensure this file contains your database connection

    if(isset($_POST['login'])){
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']); // Escape password for security

        // Query to select user from the 'admin' table
        $sql = "SELECT * FROM votesystem.admin WHERE username = '$username'";
        $query = $conn->query($sql);

        if($query->num_rows < 1){
            $_SESSION['error'] = 'Cannot find an account with the username';
        } else {
            $row = $query->fetch_assoc();
            if($password === $row['password']){
                $_SESSION['admin'] = $row['id'];
                header('location: home.php'); // Redirect to the main page upon successful login
                exit();
            } else {
                $_SESSION['error'] = 'Incorrect password';
            }
        }
    } else {
        $_SESSION['error'] = 'Input admin credentials first';
    }

    header('location: index.php'); // Redirect back to login.php to display the error
    exit();
?>
