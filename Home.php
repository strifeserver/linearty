<?php
	
	session_start();
	include('Global/Model.php');
	$model = new Model();

	if (isset($_POST['addAdmin'])) {
		$model->addAdmin($_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT), 'regular');
	}
	
	$admin_rows = $model->fetchAdminDetails($_SESSION['admin_sess']);
	
	if (!empty($admin_rows)) {
	    foreach ($admin_rows as $admin_row) {
	        $admin_username = $admin_row['username'];
	        $admin_profile = ($admin_row['profile_picture'] != null) ? $admin_row['profile_picture'] : 'default';
	        $admin_type = $admin_row['type'];
	    }
	}

	$model->inactiveFamilyChecker();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset = "UTF-8">
	<meta http-equiv = "X-UA-Compatible" content = "IE-edge">
	<meta name = "viewport" content = "width=device-width, initial-scale=1, maximum-scale=1">
	<title> Dashboard </title>
	<link rel="stylesheet" href="Css/HomeCss.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
<!------ ANIMATED SIDE NAV BAR START ------------------------------------------------------------------------------>

	   <div id="myModal" class="modal">
		   <form class="modal-content" method="POST">
			 <span class="close" id="closeFormBtn">&times;</span>
			 <h2>New user</h2>
			 <label for="username">Username</label>
			 <input type="text" id="username" placeholder="Enter Username" name="username" required>
			 
			 <label for="email">Email</label>
			 <input type="email" id="email" placeholder="Enter Email" name="email" required>
  
			 <label for="password">Password</label>
			 <input type="password" id="password" placeholder="Enter Password" name="password" required>
  
			 <label for="confirmPassword">Confirm Password</label>
			 <input type="password" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword" required>
  
			 <!--<label for="adminType">Admin Type</label>-->
			 <!--<select id="adminType" name="adminType" required>-->
			 <!--  <option value="" disabled selected>Select Admin level</option>-->
			 <!--  <option value="regular">Regular admin</option>-->
			 <!--  <option value="super">Super Admin</option>-->
			 <!--</select>-->
  
			 <button type="submit" id="submit-btn" name="addAdmin">Create</button>
		   </form>
		 </div> 

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
						<span>Administrator log</span></a>
					</li>
					<li>
						 <!-- The Sign-Up Form Trigger -->
						<a href="#" id="openModalBtn" class="button"><span class="bx bx-user-plus"></span>
						<span>New user</span></a>
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

				Dashboard
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

<!------ START NUNG MAIN CONTENT  -------------------------------------------------------------->
		<main>
			<!--eto yung dashboard preview nung sa statistics-->
			<div class="cards">
			    <?php
            
               $stat_rows = $model->fetchStatistics();
                if (!empty($stat_rows)) {
                    foreach ($stat_rows as $stat_row) {
                        $total_population = $stat_row['total_population'];
                        $active_residents = $stat_row['active_residents'];
                        $infants = $stat_row['infants'];
                        $households = $stat_row['households'];
                        $men = $stat_row['men'];
                        $females = $stat_row['females'];
                        $senior = $stat_row['senior'];
                        $pwd = $stat_row['pwd'];
                        $solo_parents = $stat_row['solo_parents'];
                        $out_of_school = $stat_row['out_of_school'];
                        $unemployed = $stat_row['unemployed'];
                        
                        $households = $stat_row['active_residents'];
                        
                            $stat_rows1 = $model->countPopulationMF();
                            if (!empty($stat_rows1)) {
                                foreach ($stat_rows1 as $stat_row1) {
                                    $men = $stat_row1['men'];
                                    $females = $stat_row1['females'];
                                    $total_population = $men + $females;
                                }
                            }
                            
                            $stat_rows1 = $model->countStatusFam();
                            if (!empty($stat_rows1)) {
                                foreach ($stat_rows1 as $stat_row1) {
                                    $senior = $stat_row1['senior'];
                                    $pwd = $stat_row1['pwd'];
                                    $solo_parents = $stat_row1['solo_parent'];
                                    $out_of_school = $stat_row1['school_dropout'];
                                    $unemployed = $stat_row1['unemployed'];
                                }
                            }
                            
                            $stat_rows1 = $model->countInfant();
                            if (!empty($stat_rows1)) {
                                foreach ($stat_rows1 as $stat_row1) {
                                    $infants = $stat_row1['infants'];
                                }
                            }
                            
                    }
                }
                
                else {
                    $total_population = "N/A";
                    $active_residents = "N/A";
                    $infants = "N/A";
                    $households = "N/A";
                    $men = "N/A";
                    $females = "N/A";
                    $senior = "N/A";
                    $pwd = "N/A";
                    $solo_parents = "N/A";
                    $out_of_school = "N/A";
                    $unemployed = "N/A";
                }
                
	
                $year = "2023";
            
            ?>

							<!--yung card-single yan yung individual boxes-->
				<div class="card-single">
					<div>
                        <a href="Statistics-profile.php?type=1&year=<?php echo $year; ?>">
                            <h1><?php echo $total_population; ?></h1>
                            <span>Total Population</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

					<div>
						<span class="las la-users"></span>
					</div>
				</div>

				<div class="card-single">
					<div>
						<a href="Statistics-profile.php?type=3&year=<?php echo $year; ?>">
                            <h1><?php echo $households; ?></h1>
                            <span>Households</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
					</div>

					<div>
						<span class="las la-users"></span>
					</div>
				</div>

				<div class="card-single">
					<div>
						<a href="Statistics-profile.php?type=4&year=<?php echo $year; ?>">
                            <h1><?php echo $men; ?></h1>
                            <span>Men</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
					</div>

					<div>
						<span class="las la-users"></span>
					</div>
				</div>
				
				<div class="card-single">
					<div>
						<a href="Statistics-profile.php?type=5&year=<?php echo $year; ?>">
                            <h1><?php echo $men; ?></h1>
                            <span>Women</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
					</div>

					<div>
						<span class="las la-users"></span>
					</div>
				</div>

				<!--<div class="card-single">-->
				<!--	<div>-->
				<!--		<a href="Statistics-profile.php?type=5&year=<?php echo $year; ?>">-->
    <!--                        <h1><?php echo $females; ?></h1>-->
    <!--                        <span>Women</span>-->
    <!--                        <small>Year: <?php echo $year; ?></small>-->
    <!--                    </a>-->
				<!--	</div>-->

				<!--	<div>-->
				<!--		<span class="las la-users"></span>-->
				<!--	</div>-->
				<!--</div>-->


			</div>
			<!--end nung statistics cards-->

			<!--eto yung sa quick preview nung sa document request-->
			<div class="recent-grid" style="align-items: start;">

				<div class="request">
					<div class="card">

						<!--yung see all button-->
						<div class="card-header">
							<h3>Recent Requests</h3>
							<a href="Document.php"><button> See All  <span class="las la-arrow-right"></span></button></a>
						</div>

						<!--body nung table para sa document request/-->
						<div class="card-body">
							<div class="table-responsive">
								<table width="100%">
								<thead>
									<tr>
										<td>House num</td>
										<td>Document Type</td>
										<td>Status</td>
									</tr>
								</thead>

								<!--eto naman yung contents nung table-->
								<!--dummy data pa lahat ng yan/yung laman nung TD or table data-->
								<tbody>
								    <?php
								    
								        $rows = $model->fetchRecentRequests();
								        
								        if (!empty($rows)) {
								            foreach ($rows as $row) {
								        
								    
								    ?>
									<tr>
										<td><?php echo $row['house_no']; ?></td>
										<td><?php echo $row['document_type']; ?></td>
										<td><span class="status purple"></span>
											<?php echo strtolower($row['status']); ?>
										</td>
									</tr>
									<?php
									        
								            }
								        }
									
									?>

									<!--<tr>-->
									<!--	<td>456</td>-->
									<!--	<td>Permit</td>-->
									<!--	<td><span class="status pink"></span>-->
									<!--		review-->
									<!--	</td>-->
									<!--</tr>-->

									<!--<tr>-->
									<!--	<td>456</td>-->
									<!--	<td>Certificate</td>-->
									<!--	<td><span class="status orange"></span>-->
									<!--		pending-->
									<!--	</td>-->
									<!--</tr>-->

									<!--<tr>-->
									<!--	<td>123</td>-->
									<!--	<td>NBI</td>-->
									<!--	<td><span class="status purple"></span>-->
									<!--		in progress-->
									<!--	</td>-->
									<!--</tr>-->

									<!--<tr>-->
									<!--	<td>456</td>-->
									<!--	<td>Permit</td>-->
									<!--	<td><span class="status pink"></span>-->
									<!--		review-->
									<!--	</td>-->
									<!--</tr>-->

									<!--<tr>-->
									<!--	<td>456</td>-->
									<!--	<td>Certificate</td>-->
									<!--	<td><span class="status orange"></span>-->
									<!--		pending-->
									<!--	</td>-->
									<!--</tr>-->
								</tbody>
							</table>
						</div>
						<!--end nung table-->

						</div>
					</div>
				</div>

				<!--eto naman yung sa quick preview nung sa community corner-->
				<div class="docs">
					<div class="card">

						<!--title part-->
						<div class="card-header">
							<h3>Events posted</h3>
							<a href="Events.php"><button> See All  <span class="las la-arrow-right"></span></button></a>
						</div>

						<!--eto naman yung contents nung sa events-->
						<div class="card-body">

							<!--yung events div, yan yung row-->
							<?php
							
							    $event_rows = $model->fetchEvents();
							    
							    if (!empty($event_rows)) {
							        $event_i = 1;
							        
							        foreach ($event_rows as $event_row) {
							            if ($event_i <= 3) {
							
							?>
							<div class="events">

								<!--eto yung container nung dummy data/yung link na yan is yung sa image nung event-->
								<div class="info">
									<img src="Events/<?php echo $event_row['event_image']; ?>.jpg" 
									width="40px" height="40px" alt="">
									
									<div>
										<h4><?php echo $event_row['event']; ?> </h4>
										<small><?php echo $event_row['event_place']; ?></small>
									</div>
								</div>

								<div class="date">
									<small><?php echo date('F j, g:i A', strtotime($event_row['datetime'])); ?></small>
								</div>
							</div>
							<?php   
							            }
							            $event_i++;
							        }
							    }
							
							?>
						</div>
				</div>
			</div>

		</main>
		<!------ END NUNG MAIN CONTENT  -------------------------------------------------------------->
	</div>

	<script src="Javascript/Home.js"></script>
</body>
</html>