<?php 

include 'includes/conn.php'; // Database connection

if (!isset($_SESSION['user_id']) || !isset($_SESSION['password_verified'])) {
    header('Location: login.php');
    exit();
}

// Fetch current voter details
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM voters WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$voter = $result->fetch_assoc();

if (!$voter) {
    echo "User not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Get password input
    $photo = $_FILES['photo'];

    // Handle file upload
    if ($photo['size'] > 0) {
        $photoPath = 'uploads/' . basename($photo['name']);
        move_uploaded_file($photo['tmp_name'], $photoPath);
    } else {
        $photoPath = $voter['photo']; // Keep existing photo if no new file is uploaded
    }

    // Update the voter details
    $sql = "UPDATE voters SET firstname = ?, lastname = ?, username = ?, photo = ?, password = ? WHERE id = ?";
    
    // Hash the password if it's provided
    $hashedPassword = $password ? password_hash($password, PASSWORD_DEFAULT) : $voter['password'];
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $firstname, $lastname, $username, $photoPath, $hashedPassword, $userId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['message'] = "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
}
unset($_SESSION['access_update_profile']);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Update Profile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background: url('https://th.bing.com/th/id/OIP.u0Di-HH_1TN7d6Un4yDs5wHaFj?rs=1&pid=ImgDetMain') no-repeat center fixed;
            background-size: cover;
        }

        .update-container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .update-card {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .update-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .toggle-password {
            cursor: pointer;
        }
    </style>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const toggleIcon = document.getElementById("toggle-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
</head>
<body>
    <div class="update-container">
        <div class="card update-card">
            <h2>Update Profile</h2>
            <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']);
            }
            ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" name="firstname" class="form-control" value="<?php echo htmlspecialchars($voter['firstname']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" name="lastname" class="form-control" value="<?php echo htmlspecialchars($voter['lastname']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($voter['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Leave empty to keep current password">
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" id="toggle-icon" onclick="togglePassword()">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="photo">Profile Photo:</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <small>(Leave empty to keep current photo)</small>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
