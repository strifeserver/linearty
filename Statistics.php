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
    <title> Statistics </title>

    <!--eto yung links nung external css nya-->
    <link rel="stylesheet" href="Css/HomeCss.css">

    <!--eto yung naman yung link nung assets natin logo, icons etc..upload sya lahat online so need mo ng net-->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>

    <!--side nav bar dito-->
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
                    <!--    <a href=""><span class="bx bxs-business"></span>-->
                    <!--    <span>Community</span></a>-->
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


    <div class="main-content">
        <header>

            <h2>

                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>

                Statistics Count
            </h2>

            <!--eto yung search bar input-->
            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search here" />
            </div>

            <!--eto yung dummy data ni admin-->
            <?php
            
                if (isset($_SESSION['admin_sess'])) {
            
            ?>
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

        </header>

<!--start nung main view nung lahat nung statistics-->
        <main class="stats-main">
            <form method="POST">
                <!--<div class="stats-header">-->
                <!--    <h3>Current Statistics</h3>-->
                <!--    <button type="submit" name="generate_statistics">Generate Statistics..<span class="bx bxs-pencil"></span></button>-->
                <!--    <select name="year" required>-->
                <!--        <option value="" disabled selected>Select Year</option>-->
                <!--        <option value="All">All</option>-->
                <!--        <option value="2023" <?php if ($_POST['year'] == '2023') {echo 'selected'; } ?>>2023</option>-->
                <!--        <option value="2024" <?php if ($_POST['year'] == '2024') {echo 'selected'; } ?>>2024</option>-->
                <!--        <option value="2025" <?php if ($_POST['year'] == '2025') {echo 'selected'; } ?>>2025</option>-->
                <!--        <option value="2026" <?php if ($_POST['year'] == '2026') {echo 'selected'; } ?>>2026</option>-->
                <!--        <option value="2027" <?php if ($_POST['year'] == '2027') {echo 'selected'; } ?>>2027</option>-->
                <!--        <option value="2028" <?php if ($_POST['year'] == '2028') {echo 'selected'; } ?>>2028</option>-->
                <!--      </select>-->
                <!--</div>-->
            </form>
          
            <?php
            
                
            
                $stat_rows = $model->fetchStatistics();

                if (!empty($stat_rows)) {
                    foreach ($stat_rows as $stat_row) {
                        $total_population = $stat_row['total_population'];
                        $active_residents = $stat_row['active_residents'];
                        $infants = $stat_row['infants'];
                        $infants_count = $stat_row['infants']; // infants count
                        
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
                if (isset($_POST['generate_statistics'])) {
                    $year = $_POST['year'];
                    
                    if ($year != 'All') {
                            $stat_rows = $model->fetchStatisticsByYear($year);
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
                                    
                                        $stat_rows = $model->countPopulationMFYear();
                                        if (!empty($stat_rows)) {
                                            foreach ($stat_rows as $stat_row) {
                                                $men = $stat_row['men'];
                                                $females = $stat_row['females'];
                                                $total_population = $men + $females;
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
                    }
                    else {
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
                                    
                                        $stat_rows1 = $model->countPopulationMF();
                                        if (!empty($stat_rows1)) {
                                            foreach ($stat_rows1 as $stat_row1) {
                                                $men = $stat_row1['men'];
                                                $females = $stat_row1['females'];
                                                $total_population = $men + $females;
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
                    }
                
               
                
                }
                    
                
            ?>
            
            <!--dito yung individual cards per statistics data/separated sya ng "card-single division"-->
            <div class="cards">
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
                        <a href="Statistics-profile.php?type=2&year=<?php echo $year; ?>">
                            <h1><?php echo $active_residents; ?></h1>
                            <span>Active Residents</span>
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
                            <h1><?php echo $females; ?></h1>
                            <span>Women</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=6&year=<?php echo $year; ?>">
                            <h1><?php echo $senior; ?></h1>
                            <span>Seniors</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=7&year=<?php echo $year; ?>">
                            <h1><?php echo $pwd; ?></h1>
                            <span>PWD</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=8&year=<?php echo $year; ?>">
                            <h1><?php echo $solo_parents; ?></h1>
                            <span>Solo parents</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=9&year=<?php echo $year; ?>">
                            <h1><?php echo $out_of_school; ?></h1>
                            <span>Out of school</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=10&year=<?php echo $year; ?>">
                            <h1><?php echo $unemployed; ?></h1>
                            <span>Unemployed</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=11&year=<?php echo $year; ?>">
                            <h1><?php echo $infants_count; ?></h1>
                            <span>Infants</span>
                            <span>(0-9 months)</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=12&year=<?php echo $year; ?>">
                            <h1><?php 
                            
                            $inactive_residents = $stat_row['inactive_residents'];
                            echo $inactive_residents;
                            
                            ?></h1>
                            <span>Inactive Residents</span>
                            <small>Year: <?php echo $year-1; ?></small>
                        </a>
                    </div>

                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>
                
                <div class="card-single">
                    <div>
                        <h1 class="last-stats">...</h1>
                        <span>....</span>
                        <small class="last-card">Year: <?php echo $year; ?></small>
                    </div>

                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>
                
            </div>
            <!--end nung container nung statistics cards-->
            
        </main>
        <!--end nung statistics form-->
    </div>

</body>

