<?php
session_start(); // Start the session

$conn = new mysqli('localhost', 'root', '', 'votesystem');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure that form fields are set
    $voters_id = isset($_POST['voters_id']) ? $_POST['voters_id'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($voters_id && $username && $password) {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM voters WHERE username = ? AND voters_id = ?");
        $stmt->bind_param("ss", $username, $voters_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $voter = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $voter['password'])) {
                $_SESSION['user_id'] = $voter['id']; // Store user ID in session
                header("Location: overview.php"); // Redirect to overview page
                exit();
            } else {
                $_SESSION['message'] = "Invalid password. Please try again.";
            }
        } else {
            $_SESSION['message'] = "Invalid username or voter ID. Please try again.";
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Please fill in all fields.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        body {
            background: url('https://th.bing.com/th/id/OIP.u0Di-HH_1TN7d6Un4yDs5wHaFj?rs=1&pid=ImgDetMain') no-repeat center fixed;
            background-size: cover;
        }

        .login-container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.8); /* Slight white background for readability */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .signup-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card login-card">
            <h2>Login to Vote</h2>
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="voters_id" class="form-control" placeholder="Voter's ID" required>
                </div>
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <div class="form-group">
    <a href="preoverview.php" class="btn btn-secondary btn-block">Back</a>
</div>
            </form>

            <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-danger mt-3" role="alert">' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']);
            }
            ?>
            <div class="signup-link">
                <p>Don't have an account? <a href="register.php">Sign up here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
