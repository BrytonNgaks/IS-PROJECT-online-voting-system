<?php
  	session_start();
  	if(isset($_SESSION['admin'])){
    	header('location:home.php');
  	}
?>
<?php include 'includes/header.php'; ?>
<style>
  body {
    background: url('https://mir-s3-cdn-cf.behance.net/project_modules/1400/3f2eef13443655.56273e464916a.jpg') no-repeat center center !important;
    background-size: cover !important; /* Adjust to cover the entire viewport */
  }
  /* Inline CSS for login container and logo */
  .login-container {
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center;     /* Center vertically */
    height: 100vh;           /* Full viewport height */
    background-color: #333;  /* Background color, adjust as needed */
  }
  .login-logo {
    text-align: center;      /* Center text inside .login-logo */
  }

  .login-box {
    width: 100%;
    max-width: 360px;
    padding: 20px;
    margin: auto;
  }

  .login-box-body {
    background-color: #E4B43A;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .login-box-msg {
    color: red;
    font-size: 20px;
    margin-bottom: 20px;
    text-align: center;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-control {
    border-radius: 5px;
    box-shadow: none;
  }

  .form-control:focus {
    border-color: #ddd;
    box-shadow: none;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 5px;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
  }

  .has-feedback .form-control-feedback {
    top: 50%;
    right: 15px;
    margin-top: -12px;
  }

  .login-box .btn-block {
    width: 100%;
  }

    .btn-custom {
        width: 100%;
        white-space: nowrap;
    }

</style>

<body class="hold-transition login-page">
<div class="login-box" >
  	
  	<div class="login-box-body" style="background-color: #E4B43A;height: 250px!important;">
    	<p class="login-box-msg" style="color: red;font-size: 20px;">ADMIN </p>

    	<form action="login.php" method="POST">
      		<div class="form-group has-feedback">
        		<input type="text" class="form-control" name="username" placeholder="Username" required>
        		<span class="glyphicon glyphicon-user form-control-feedback"></span>
      		</div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
      		<div class="row">
    <div class="row">
    <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-flat btn-custom" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
    </div>
    <div class="col-xs-4">
        <button type="button" class="btn btn-primary btn-flat btn-custom" onclick="window.location.href='../login.php'"><i class="fa fa-user"></i> As Voter</button>
    </div>
<div class="form-group">
    <a href="../preoverview.php" class="btn btn-secondary btn-block">Back</a>
</div>
</div>


    	</form>
  	</div>
  	<?php
  		if(isset($_SESSION['error'])){
  			echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>".$_SESSION['error']."</p> 
			  	</div>
  			";
  			unset($_SESSION['error']);
  		}
  	?>
</div>
	
<?php include 'includes/scripts.php' ?>
</body>
</html>
