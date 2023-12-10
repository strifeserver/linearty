<?php
	
	session_start();
	include('Global/Model.php');
	$model = new Model();

	if (isset($_POST['submit_profile'])) {
	    $pangalan = $_POST['pangalan'];
	    $email = $_POST['email'];
	    
        $path = 'Requirement/';
		$unique = time().uniqid(rand());
		$destination = $path . $unique . '.jpg';
	    $base = basename($_FILES["gov_id"]["name"]);
		$image = $_FILES["gov_id"]["tmp_name"];
		move_uploaded_file($image, $destination);
		
		$model->addEditRequest($pangalan, $unique, $email);
		$model->govImageUpdate($pangalan, $unique);
	}
	
	$admin_rows = @$model->fetchAdminDetails($_SESSION['admin_sess']);
	
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
	<title> Family Profile Form </title>
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
                    
                        if (@$admin_type == 'super') {
                            
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
                    
                        if (@$admin_type == 'super') {
                            
                    ?>
					<li>
						<a href=""><span class="bx bxs-business"></span>
						<span>Community</span></a>
					</li>
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

				Family Profile Form
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
<main class="fam-footer">
    <h3>Request Delete/Edit</h3>
    <br>

		     
			<div class="fam-input">

				<!--eto yung input fields nya-->
				<div class="fam-fields">
					<label for="pangalan">PANGALAN NG NAGSAGOT NG PROFILE:</label><br>
                    <select id="pangalan" name="pangalan" required>
                        <option value="" disabled selected>Piliin ang profile</option>
                        <?php
                        
                            $rows = $model->fetchProfilesActive();
                            
                            if (!empty($rows)) {
                                foreach ($rows as $row) {
                        
                        ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['pangalan']; ?></option>
                        <?php
                        
                                }
                            }
                        
                        ?>
                    </select>
				</div><br>
				
				<div class="fam-fields">
					<label for="">EMAIL:</label>
					<div class="fam-txt"> <input type="email" name="email" placeholder="Email" required> </div>
				</div>
				
				<div class="fam-fields">
					<label for="">GOVERNMENT ID: <span style="color: red;">( postal id, nbi clearance, umid, Philsys id )*</span></label>
					<!-- <div class="fam-txt"> <input type="file" name="gov_id" style="padding-top: 8px;" required> </div> -->

					<div class="file-input-container">
						<label for="gov_id" class="custom-file-input">
							Choose Upload File
						</label>
						<input input id="gov_id" type="file" name="gov_id" style="padding-top: 8px;" required>
					</div>




				</div>
			</div>


			<!--eto yung submit button-->
			<div class="fam-input">
				<div class="fam-fields">
					<div class="fam-btn"> <input type="submit" name="submit_profile" value="IPASA ANG REQUEST"> </div>
				</div>
			</div>
</main>


		 
	</div>
	</form>
	
	<script src="Javascript/Family.js"></script>
<!------ FAMILY PAPER ENDS ---------------------------------------------------------------------------------------->  
</body>
</html>