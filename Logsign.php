<?php
    
    session_start();
    include('Global/Model.php');
    $model = new Model();

    if (isset($_POST['login'])) {
        $model->signIn($_POST['username'], $_POST['password']);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset = "UTF-8">
	<meta http-equiv = "X-UA-Compatible" content = "IE-edge">
	<meta name = "viewport" content = "width=device-width, initial-scale=1, maximum-scale=1">
	<title> Logsign </title>
	<link rel="stylesheet" href="Css/Logsign.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
	<div class="container">
		<!--yung check box para yan sa page flip animation-->
		<input type="checkbox" id="flip">

		<!--eto naman yung front and back nung animated cover-->
		   <div class="cover">

			<div class="front">
				<img src="https://wallpapercave.com/wp/wp6658488.jpg" alt="">

				<div class="text">
					<span class="text-1">Join us to create a <br> society where everybody counts</span>
					<span class="text-2">Let's get connected</span>
				</div>

			</div>

			<div class="back">
				<img class="backimg" src="https://wallpapercave.com/wp/wp3990424.jpg" alt="">

				<div class="text">
					<span class="text-1"> No one gets left behind <br>  </span>
					<span class="text-2">Let's get conected!</span>
				</div>

			</div>
		 </div>

		 <!--andtio yung main content na sasagutin-->
		 <form method="POST">
			<div class="form-content">

				<!--dito yung input fields-->
				<div class="login-form">
					<div class="title">Login</div>

					<div class="input-boxes">

						<div class="input-box">
							<i class="bx bxs-contact"></i>
							<input type="text" name="username" placeholder="Enter your Admin ID" required>
							<!--Put back the "required" syntax on input text to lock-->
						</div>
	
						<div class="input-box">
							<i class="bx bxs-lock-open"></i>
							<input type="password" name="password" placeholder="Enter your Password" required>
						</div>
	
						<div class="text"><a href="Forgot-password.php">Forgot password?</a></div>
	
						<div class="button input-box">
							
							<!-- <a class="btn" href="Home.php">LOGIN</a> -->
							
							<input class="btn" type="submit" name="login" value="LOGIN">
						</div>
<!-- 	
						<div class="text login-text">Don't have an account? <label for="flip">Signup now</label></div> -->
					</div>
				</div>

				<!--dito naman yung sa sign up part-->
<!-- 				<div class="signup-form">
					<div class="title">Signup</div> -->

					<!--input fields nung signup-->
<!-- 					<div class="input-boxes">

						<div class="input-box">
							<i class="bx bxs-contact"></i>
							<input type="text" placeholder="Enter your Admin ID" required>
						</div>
	
						<div class="input-box">
							<i class="bx bxs-lock-open"></i>
							<input type="password" placeholder="Enter your Password" required>
						</div>
	
						<div class="input-box">
							<i class="bx bxs-lock"></i>
							<input type="password" placeholder="Confirm your Password" required>
						</div>
						
						<div class="button input-box">
							<a class="btn" href="Home.php">SIGNUP</a>
						</div>
	
						  <div class="text sign-up-text">Already have an account? <label for="flip">Login now now</label></div>
						</div>
					</div> -->
				</div>
			</form>
		</div>
</body>