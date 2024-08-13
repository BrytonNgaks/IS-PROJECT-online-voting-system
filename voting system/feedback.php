<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
    <title>County Authorities | Secure Elections</title>

    <!-- Bootstrap -->
    <link href="feedback.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- Include Font Awesome -->

    <style>
      /* Reset default margin and padding */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body, html {
        height: 100%;
        width: 100%;
        background-color: white; /* Body background color */
        display: flex;
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
        overflow: hidden; /* Hide overflow to prevent scrolling */
      }

      .container {
        width: 100%;
        max-width: 400px; /* Set a max width for the form */
        background: white; /* Inside container color (form box) */
        padding: 20px;
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
      }

      .form-box {
        background: white; /* Form background */
        color: black; /* Form text color */
        padding: 20px; /* Adjust padding as needed */
        border-radius: 5px; /* Rounded corners */
        margin-top: 20px; /* Space above form */
      }

      .form-group {
        border: 1px solid black; /* Black border */
        border-radius: 5px; /* Rounded corners for input groups */
        margin-bottom: 15px; /* Space between form groups */
        overflow: hidden; /* Clear floats */
      }

      .login-box {
        text-align: center; /* Center text */
      }

      .logo {
        height: auto;
        width: 100%;
        max-height: 70px;
        margin-bottom: 20px; /* Space below logo */
      }

      .form-control {
        border: none; /* Remove default border */
        padding: 10px; /* Add padding */
        width: 100%; /* Full width */
        box-shadow: none; /* Remove box-shadow */
        outline: none; /* Remove outline on focus */
      }

      .form-control:focus {
        border: none; /* Keep it consistent */
        box-shadow: none; /* No shadow on focus */
      }

      .btn-primary {
        background-color: #007bff; /* Button background color */
        border: none; /* Remove default border */
        padding: 10px 20px; /* Adjust padding as needed */
        color: white; /* Button text color */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
      }

      .btn-primary:hover {
        background-color: #0056b3; /* Darker button background on hover */
      }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?=$_SESSION["msg_type"]?>">
            <?php
                echo $_SESSION["message"];
                unset($_SESSION["message"]);
            ?>
        </div>
    <?php endif ?>

    <div class="container">
        <div class="login-box">
            <h2>
                <a href="index.php" class="navbar-brand headerFont text-lg" style="color: white;">
                    <strong>
                        <a href="home.php">
                            <img itemprop="image" class="logo" src="https://wallpapercave.com/wp/wp4211390.jpg" alt="Logo">
                        </a>
                    </strong>
                </a>
            </h2>

            <div class="form-box">
                <h2>Give us your feedback</h2>
                <form action="processfeedback.php" method="post">
                    <div class="form-group">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <input type="text" placeholder="Username" name="username" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="usertype" style="font-weight: bold;">Feedback Type:</label>
                        <select name="ftype" id="ftype" class="form-control" required>
                            <option value="Comments">Comments</option>
                            <option value="Suggestions">Suggestions</option>
                            <option value="Questions">Questions</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <i class="fa fa-pen" aria-hidden="true"></i>
                        <textarea cols="15" rows="5" placeholder="Enter your opinion here" name="tarea" class="form-control"></textarea>
                    </div>

                    <button type="submit" name="send" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
