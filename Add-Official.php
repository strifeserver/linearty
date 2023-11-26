<?php
	
	session_start();
	include('Global/Model.php');
	$model = new Model();
	
	$admin_rows = $model->fetchAdminDetails($_SESSION['admin_sess']);
	
	if (!empty($admin_rows)) {
	    foreach ($admin_rows as $admin_row) {
	        $admin_username = $admin_row['username'];
	        $admin_profile = ($admin_row['profile_picture'] != null) ? $admin_row['profile_picture'] : 'default';
	        $admin_type = $admin_row['type'];
	    }
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset = "UTF-8">
	<meta http-equiv = "X-UA-Compatible" content = "IE-edge">
	<meta name = "viewport" content = "width=device-width, initial-scale=1, maximum-scale=1">
	<title> Add Barangay Official </title>
	<link rel="stylesheet" href="Css/Family.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
	<style>


	/* Styles for the custom file input container */
	.file-input-container {
	display: inline-block;
	position: relative;
	}

	/* Styles for the custom file input button */
	.custom-file-input {
	background-color: var(--vermain-color);
	width: fit-content;
	margin-left: 5px;
	border-radius: 10px;
	color: #fff;
	font-size: 13px;
	padding: .5rem 1rem;
	cursor: pointer;
	display: inline-block;
	border: 1px solid var(--vermain-color);
	}

	/* Hide the original file input */
	input[type="file"] {
	display: none;
	}

	</style>
	<form method="POST" enctype="multipart/form-data">
<!------ ANIMATED SIDE NAV BAR START ------------------------------------------------------------------------------>
	<input type="checkbox" id="nav-toggle">
	<div class="sidebar">   

		<div class="sidebar-brand">
			<h2><span class="lab la-accusoft"></span> <span> LINEARiTY </span> </h2>
		</div>

		<div class="sidebar-menu">
				<ul>
                    <?php
                    
                        if ($admin_type == 'super') {
                            
                    ?>
					<li>
						<a href="Logsign.php"><span class="bx bxs-user-detail"></span>
						<span>Administrator</span></a>
					</li>
					<?php
					
                        }
					
					?>

					<li>
						<a href="Home.php"><span class="bx bxs-grid-alt"></span>
						<span>Dashboard</span></a>
					</li>

					<li>
						<a href="<?php echo (isset($_SESSION['admin_sess'])) ? 'Profiles.php' : 'Family.php'; ?>"><span class="bx bxs-spreadsheet"></span>
						<span>Family Profile</span></a>
					</li>

					<li>
						<a href="Statistics.php"><span class="bx bxs-report"></span>
						<span>Statistics</span></a>
					</li>

					<li>
						<a href="Document.php"><span class="bx bxs-edit"></span>
						<span>Requests</span></a>
					</li>
					
					<li>
                        <a href="Officials.php"><span class="bx bxs-user"></span>
                        <span>Brgy. Officials</span></a>
                    </li>
                    
                    <?php
                    
                        if ($admin_type == 'super') {
                            
                    ?>
					<!--<li>-->
					<!--	<a href=""><span class="bx bxs-business"></span>-->
					<!--	<span>Community</span></a>-->
					<!--</li>-->
					<?php
					
                        }
					
					    if (isset($_SESSION['admin_sess'])) {
                    
                    ?>
                    <li>
                        <a href="logout.php"><span class="bx bx-log-out"></span>
                        <span>Logout</span></a>
                    </li>
                    <?php
                    
                        }
                        
                        else {
                            
                    ?>
                    <li>
                        <a href="Logsign.php"><span class="bx bxs-log-in"></span>
                        <span>Login</span></a>
                    </li>
                    <?php
                            
                        }
                    
                    ?>

				</ul>
		</div>
	</div>
<!------ ANIMATED SIDE NAV BAR ENDS  ------------------------------------------------------------------------------>

<!------ TOP NAV BAR START ---------------------------------------------------------------------------------------->
	<div class="main-content">
		<header>

			<h2>

				<label for="nav-toggle">
					<span class="las la-bars"></span>
				</label>

				Add Barangay Official
			</h2>

<!------ SEARCH BAR  ----------------------------------------------------------------->
			<div class="search-wrapper">
				<span class="las la-search"></span>
				<input type="search" placeholder="Search here" />
			</div>
<!------ SEARCH BAR  ----------------------------------------------------------------->

<!------ ADMIN PROFILE  -------------------------------------------------------------->
			<?php
            
                if (isset($_SESSION['admin_sess'])) {
            
            ?>
            <div class="user-wrapper">
				<img src="Profile/<?php echo $admin_profile ?>.jpg" width="40px" height="40px" alt="user">
				<div>
					<h4><?php echo $admin_username; ?></h4>
					<small><?php echo ucfirst($admin_type); ?> Admin</small>
				</div>
			</div>
			<?php
			
                }
                
                else {
            
            ?>
            <div class="user-wrapper">
				<div>
					<h4>Guest</h4>
					<small>Guest User</small>
				</div>
			</div>
            <?php
            
                }
			
			?>
<!------ ADMIN PROFILE  -------------------------------------------------------------->
		</header>
<!------ TOP NAV BAR ENDS ----------------------------------------------------------------------------------------->

<!------ FAMILY PAPER START DITO START---------------------------------------------------------------------------------------->  
		<main>
			<h3>Barangay Official Form</h3>


			<!--eto naman yung code nung form-->
			

				<!--eto yung title part-->
				<div class="head">
                        <br>
						
						<!--mga input fields nung first portion ng form-->
						<div class="fields">

							<div class="input-fields">
                                <img id="display-img" style="width: 200px; height: 200px; object-fit: cover;">
                                <br>
                                <label class="col-form-label"><b>Photo</b></label>
                                <!-- <input class="form-control" type="file" name="image" accept="image/*" onchange="readURL(this)" style="border: 0px; padding: 0px;" required> -->

								<div class="file-input-container"><label for="upload" class="custom-file-input" style="color: white;">Choose Upload File</label><input type="file" id="upload" name="image" onchange="readURL(this)" accept="image/*" style="padding-top: 8px;" required></div>


                            </div>

							<div class="input-fields">
								<label class="col-form-label"><b>Name</b></label>
								<input class="form-control" type="text" name="name" required maxlength="50">
							</div>

							<div class="input-fields">
								<label class="col-form-label"><b>Position</b></label>
								<input class="form-control" type="text" name="position" required maxlength="50">
							</div>

							<div class="input-fields">
								<label class="col-form-label"><b>Email</b></label>
								<input class="form-control" type="email" name="email" required maxlength="50">
							</div>

							<div class="input-fields">
								<label class="col-form-label"><b>Rendered Service</b></label>
								<input class="form-control" type="text" name="rendered_service" required maxlength="50">
							</div>

							
							<div class="fam-input">
                				<div class="fam-fields">
                					<div class="fam-btn"> <input type="submit" name="add_structure" value="IPASA ANG BRGY. PROFILE"> </div>
                				</div>
                			</div>
						</div>
					</div>
				</div>
			
		</main>
		<!--end nung first portion ng form-->




			<!--eto yung submit button-->
			
		 </div>
	</div>
	</form>
	<?php

							if (isset($_POST['add_structure'])) {
								$name = $_POST['name'];
								$email = $_POST['email'];
								$position = $_POST['position'];
								$rendered_service = $_POST['rendered_service'];
								
								
								$password = password_hash("12345", PASSWORD_DEFAULT);


								$path = 'org-structure/';
								$unique = time().uniqid(rand());
								$destination = $path . $unique . '.jpg';
								$base = basename($_FILES["image"]["name"]);
								$image = $_FILES["image"]["tmp_name"];
								move_uploaded_file($image, $destination);

								$model->addStructure($name, $email, $password, $position, $base, $unique, $rendered_service, 1);
								echo "<script>alert('Barangay Official has been added!');window.open('Officials.php', '_self')</script>";
							}

	?>
	<script src="Javascript/Family.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#display-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<!------ FAMILY PAPER ENDS ---------------------------------------------------------------------------------------->  
</body>
</html>