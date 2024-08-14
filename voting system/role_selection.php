<?php
// role_selection.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Your Role</title>
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
        .role-container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .role-card {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .role-card h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-role {
            margin: 10px 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="role-container">
        <div class="card role-card">
            <h2>Select Your Role</h2>
            <form action="redirect_role.php" method="POST">
                <button type="submit" name="role" value="voter" class="btn btn-success btn-role">Login as Voter</button>
                <button type="submit" name="role" value="admin" class="btn btn-primary btn-role">Login as Admin</button>
                <div class="form-group">
    <a href="preoverview.php" class="btn btn-secondary btn-block">Back</a>
</div>
            </form>
        </div>
    </div>
</body>
</html>
