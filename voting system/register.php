<?php
session_start(); // Start the session

$conn = new mysqli('localhost', 'root', '', 'votesystem');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voters_id = $_POST['voters_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $photo = $_FILES['photo'];
    $joined = date('Y-m-d H:i:s'); // Current timestamp for 'joined'

    // Handle file upload
    $photoPath = 'uploads/' . basename($photo['name']);
    
    // Ensure the uploads directory exists
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }

    // Check if the voters_id already exists
    $check_id_sql = "SELECT * FROM voters WHERE voters_id = ?";
    $check_id_stmt = $conn->prepare($check_id_sql);
    $check_id_stmt->bind_param("s", $voters_id);
    $check_id_stmt->execute();
    $id_result = $check_id_stmt->get_result();

    // Check if the username (email) already exists
    $check_username_sql = "SELECT * FROM voters WHERE username = ?";
    $check_username_stmt = $conn->prepare($check_username_sql);
    $check_username_stmt->bind_param("s", $username);
    $check_username_stmt->execute();
    $username_result = $check_username_stmt->get_result();

    if ($id_result->num_rows > 0) {
        // Voter ID already exists
        $_SESSION['message'] = "Error: Voter ID already exists.";
    } elseif ($username_result->num_rows > 0) {
        // Username (email) already exists
        $_SESSION['message'] = "Error: Username (email) already exists.";
    } else {
        // Proceed with the insertion
        if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
            // Prepare the SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO voters (voters_id, firstname, lastname, username, password, photo, joined) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $voters_id, $firstname, $lastname, $username, $password, $photoPath, $joined);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Registration successful! Please log in.";
                header("Location: login.php"); // Redirect to login page after registration
                exit();
            } else {
                $_SESSION['message'] = "Error: " . $stmt->error;
            }
        } else {
            $_SESSION['message'] = "Error uploading file.";
        }

        $stmt->close();
    }

    $check_id_stmt->close();
    $check_username_stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

        .register-container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.8); /* Slight white background for readability */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .register-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>


    <div class="register-container">
        <div class="card register-card">
            <h2>Register to Vote</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="voters_id" class="form-control" placeholder="Voter's ID" required>
                </div>
                <div class="form-group">
                    <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label>Gender:</label>
                    <select name="gender" class="form-control" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="file" name="photo" class="form-control-file" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
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
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Log in here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
