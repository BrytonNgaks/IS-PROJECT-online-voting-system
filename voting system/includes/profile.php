<?php
include 'includes/conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']))

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

// Password verification logic
if (isset($_POST['verify_password'])) {
    $password = $_POST['password'];

    // Verify the password
    if (password_verify($password, $voter['password'])) {
        $_SESSION['password_verified'] = true;
        $_SESSION['access_update_profile'] = true; // Set session variable
        header('Location: update.php');
        exit();
    } else {
        $error = "Wrong password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <title>User Profile | County Voting Hub</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <link rel="stylesheet" href="skins/_all-skins.min.css">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <style>
        body {
            background: #f5f5f5;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

        .ui-w-80 {
            width: 80px !important;
            height: auto;
        }

        .btn-default {
            border-color: rgba(24, 28, 33, 0.1);
            background: rgba(0, 0, 0, 0);
            color: #4E5155;
        }

        label.btn {
            margin-bottom: 0;
        }

        .btn-outline-primary {
            border-color: #26B4FF;
            background: transparent;
            color: #26B4FF;
        }

        .btn {
            cursor: pointer;
        }

        .text-light {
            color: #babbbc !important;
        }

        .btn-facebook {
            border-color: rgba(0, 0, 0, 0);
            background: #3B5998;
            color: #fff;
        }

        .btn-instagram {
            border-color: rgba(0, 0, 0, 0);
            background: #000;
            color: #fff;
        }

        .card {
            background-clip: padding-box;
            box-shadow: 0 1px 4px rgba(24, 28, 33, 0.012);
        }

        .row-bordered {
            overflow: hidden;
        }

        .account-settings-fileinput {
            position: absolute;
            visibility: hidden;
            width: 1px;
            height: 1px;
            opacity: 0;
        }

        .account-settings-links .list-group-item.active {
            font-weight: bold !important;
        }

        html:not(.dark-style) .account-settings-links .list-group-item.active {
            background: transparent !important;
        }

        .account-settings-multiselect~.select2-container {
            width: 100% !important;
        }

        .light-style .account-settings-links .list-group-item {
            padding: 0.85rem 1.5rem;
            border-color: rgba(24, 28, 33, 0.03) !important;
        }

        .light-style .account-settings-links .list-group-item.active {
            color: #4e5155 !important;
        }

        .material-style .account-settings-links .list-group-item {
            padding: 0.85rem 1.5rem;
            border-color: rgba(24, 28, 33, 0.03) !important;
        }

        .material-style .account-settings-links .list-group-item.active {
            color: #4e5155 !important;
        }

        .dark-style .account-settings-links .list-group-item {
            padding: 0.85rem 1.5rem;
            border-color: rgba(255, 255, 255, 0.03) !important;
        }

        .dark-style .account-settings-links .list-group-item.active {
            color: #fff !important;
        }

        .light-style .account-settings-links .list-group-item.active {
            color: #4E5155 !important;
        }

        .light-style .account-settings-links .list-group-item {
            padding: 0.85rem 1.5rem;
            border-color: rgba(24, 28, 33, 0.03) !important;
        }

        .profile-header {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .profile-details {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-details img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .profile-details h3 {
            margin-bottom: 20px;
        }

        .profile-details p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        #passwordForm {
            display: none; /* Initially hidden */
            margin: 20px auto; /* Centered with margin */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.9);
            max-width: 400px; /* Set a max width */
            width: 100%; /* Full width within the max */
        }

        .btn-primary, .btn-success, .btn-danger, .btn-secondary {
            margin-top: 10px;
        }

        .alert {
            margin-top: 20px;
        }

        .text-center {
            margin-top: 20px;
        }
    </style>
    <script>
        function showPasswordPrompt() {
            document.getElementById('passwordForm').style.display = 'block';
        }
    </script>
</head>
<body>

<div class="container">
    <div class="profile-header">
        <h1><?php echo htmlspecialchars($voter['firstname']) . ' ' . htmlspecialchars($voter['lastname']); ?>'s Profile</h1>
    </div>
    
    <div class="profile-details">
        <img src="<?php echo !empty($voter['photo']) ? htmlspecialchars($voter['photo']) : 'images/profile.jpg'; ?>" alt="Profile Photo">
        <h3>Profile Details</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($voter['firstname'] . ' ' . $voter['lastname']); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($voter['username']); ?></p>
        <p><strong>Password:</strong> ******</p>
        <p><strong>Joined:</strong> <?php echo date('M. Y', strtotime($voter['joined'])); ?></p>
    </div>

    <div class="text-center">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <button class="btn btn-primary" onclick="showPasswordPrompt()">Update Profile</button>
        
        <form method="POST" id="passwordForm">
            <input type="hidden" name="verify_password" value="true">
            <div class="form-group">
                <label for="password">Enter Your Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('passwordForm').style.display='none'">Cancel</button>
        </form>
        <br>
        <a href="logout.php" class="btn btn-danger">Log Out</a>
    </div>
</div>

</body>
</html>
