<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    session_start();
    include('Global/Model.php');
    $model = new Model();

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
					<div class="title">Forgot password</div>

					<div class="input-boxes">

						<div class="input-box">
							<i class="bx bxs-contact"></i>
							<input type="text" name="username" placeholder="Enter your email" required>
							<!--Put back the "required" syntax on input text to lock-->
							
						</div>
						
						<?php 
						
						if (isset($_POST['search'])) {
											$model = new Model();
											$status = $model->fetchAdminEmailID($_POST['username']);

											if($status != false) {
												$verification_key = random_int(100000, 999999);

												require 'vendor/autoload.php';

												$mail = new PHPMailer(true);
												
												$mail->SMTPDebug = SMTP::DEBUG_SERVER;
												$mail->isSMTP();
												$mail->Host = 'smtp.gmail.com';
												$mail->SMTPAuth = true;
												$mail->Username = 'azraelgriffin.riego@gmail.com';
												$mail->Password = 'ecavbuyseyfggbcm';
												$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
												$mail->Port = 465;

												$mail->setFrom("azraelgriffin.riego@gmail.com", 'AIHS E-Learning Management System');
												$mail->addAddress($_POST['username']);

												$mail->isHTML(true);
												$mail->Subject = 'Account Verification - Please take action';
												$mail->Body = "Hi,<br><br>Your verification code is: $verification_key<br>You can enter the code with or without spaces.";

												if ($mail->send()) {
													$_SESSION['verification'] = [$status, $verification_key];
													echo "<script>window.open('Verification-code.php','_self');</script>";
												} 

												else {
													echo $mail->ErrorInfo;
												}
											}

											else {
												echo "<h5 style='color: red;'>Email not found in database!</h5>";
											}
										}
						?>

	
						<div class="button input-box">
							<input class="btn" type="submit" name="search" value="SEARCH">
						</div>

					</div>
				</div>

				</div>
			</form>
		</div>
</body>