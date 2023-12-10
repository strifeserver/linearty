<?php

	
	session_start();
	include('Global/Model.php');
	$model = new Model();

	$admin_rows = @$model->fetchAdminDetails($_SESSION['admin_sess']);
	$currentYearSet = $model->fetchGeneratedYearDisplaySetting();
	if (!empty($admin_rows)) {
	    foreach ($admin_rows as $admin_row) {
	        $admin_username = $admin_row['username'];
	        $admin_profile = ($admin_row['profile_picture'] != null) ? $admin_row['profile_picture'] : 'default';
	        $admin_type = $admin_row['type'];
	    }
	}else{
        $_POST['year'] = $currentYearSet;
        $_GET['year'] = $currentYearSet;

   
    }
    $year = $currentYearSet;


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
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-bold-straight/css/uicons-bold-straight.css'>
</head>

<style>

main{
            background-image: url("images/bgwbanoverlay.jpg");
            /* background-position: right -80px; */
            /* background-repeat: no-repeat; */
            /* background-size: cover; */
        }
        .card-single{
            border: 5px solid #FF10F0 ;
            /* background-color: #00a4ef7d; */
            /* background-color: #ffffffd4; */
            background-color: white;
        }
        .table_body{

            background-color: #00000000;
        }
        
        .text-color{
            color:#aa10ff !important;
        }

        .stats-header button{
            background-color: white;
            color: black;
        }

</style>
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
                        <a href="Events.php"><span class="bx bxs-edit"></span>
                        <span>Events</span></a>
                    </li>
                    
                    <li>
                        <a href="Officials.php"><span class="bx bxs-user"></span>
                        <span>Brgy. Officials</span></a>
                    </li>
                    
                    <?php
                    
                        if (@$admin_type == 'super') {
                            
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
        <?php
                    
            
                if (isset($_SESSION['admin_sess'])) {
            
            ?>
            <form method="POST">
                <div class="stats-header">
                   <h3 style="color: white;">Current Statistics</h3>
                   <button type="submit" name="generate_statistics">Generate Statistics..<span class="bx bxs-pencil"></span></button>
                   <select name="year" required>
                       <option value="" disabled selected>Select Year</option>
                       <option value="All">All</option>
                       <option value="2023" <?php if (@$_POST['year'] == '2023') {echo 'selected'; } ?>>2023</option>
                       <option value="2024" <?php if (@$_POST['year'] == '2024') {echo 'selected'; } ?>>2024</option>
                       <option value="2025" <?php if (@$_POST['year'] == '2025') {echo 'selected'; } ?>>2025</option>
                       <option value="2026" <?php if (@$_POST['year'] == '2026') {echo 'selected'; } ?>>2026</option>
                       <option value="2027" <?php if (@$_POST['year'] == '2027') {echo 'selected'; } ?>>2027</option>
                       <option value="2028" <?php if (@$_POST['year'] == '2028') {echo 'selected'; } ?>>2028</option>
                     </select>
                </div>
            </form>
          <?php }?>
            <?php
            
                
                $active_residentsv1 = $model->activeResidents();
    
                $stat_rows = $model->fetchStatistics();

                if (!empty($stat_rows)) {
                    foreach ($stat_rows as $stat_row) {
                        $total_population = $stat_row['total_population'];
                        $active_residents = $stat_row['active_residents'];
                        $infants = $stat_row['infants'];
                        $infants_count = $stat_row['infants']; // infants count
                        $inactive_residents = $stat_row['inactive_residents'];
                     
                        
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
                
	
                
                if (isset($_POST['generate_statistics'])) {
                    $year = $_POST['year'];
                    

                    
            
                    if($year != 'All'){
                        $setDisplayYear = $model->updateGeneratedYearDisplaySetting($year);
                    }


                    if ($year != 'All') {
                            $stat_rows = $model->fetchStatisticsByYear($year);
                            if (!empty($stat_rows)) {
                                foreach ($stat_rows as $stat_row) {
                                    $total_population = $stat_row['total_population'];
                                    $active_residents = $stat_row['active_residents'];
                                    $inactive_residents = $stat_row['inactive_residents'];
                                    $infants = $stat_row['infants'];
                                    $households = $stat_row['households'];
                                    $men = $stat_row['men'];
                                    $females = $stat_row['females'];
                                    $senior = $stat_row['senior'];
                                    $pwd = $stat_row['pwd'];
                                    $solo_parents = $stat_row['solo_parents'];
                                    $out_of_school = $stat_row['out_of_school'];
                                    $unemployed = $stat_row['unemployed'];
                                    
                                        // $stat_rows = $model->countPopulationMFYear();
                                        // if (!empty($stat_rows)) {
                                        //     foreach ($stat_rows as $stat_row) {
                                        //         $men = $stat_row['men'];
                                        //         $females = $stat_row['females'];
                                        //         $total_population = $men + $females;
                                        //     }
                                        // }
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
                            <h1 class="text-color"><?php 
                            
                            
                            if(is_array($model->totalPopQry())){
                                echo count($model->totalPopQry());
                            }else{
                                echo 0;
                            }
                            
                            
                            ?></h1>
                            <span class="text-color">Total Population</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <i class="fi fi-sr-users-alt text-color" style="font-size: 30px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=2&year=<?php echo $year; ?>">
               
                            <h1 class="text-color"><?php 
                            
                            $profiles = $model->fetchProfiles2();
$profilesCount = is_array($profiles) ? count($profiles) : 0;

echo $profilesCount;
                            
                            ?></h1>
                            <span class="text-color">Active Residents</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                    <i class="fi fi-ss-user-add text-color" style="font-size: 30px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=3&year=<?php echo $year; ?>">
                            <h1 class="text-color"><?php 
                            
                            
                            $householdss = $model->fetchProfiles2();
                         
                                                        
                            if(is_array($householdss)){
                                echo count($householdss);
                            }else{
                                echo 0;
                            }
                            
                            
                            ?></h1>
                            <span class="text-color">Households</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                    <i class="fi fi-rs-house-chimney text-color" style="font-size: 30px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=4&year=<?php echo $year; ?>">
                            <h1 class="text-color"><?php
                            
                            
                            $gender = "M";
                            $menrows = $model->fetchProfiles4_5($gender);
                            
                     
                            
                            if(is_array($menrows)){
                                echo count($menrows);
                            }else{
                                echo 0;
                            }
                            
                            
                            
                            
                            ?></h1>
                            <span class="text-color">Men</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <i class="fi fi-rr-mars text-color" style="font-size: 30px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=5&year=<?php echo $year; ?>">
                            <h1 class="text-color"><?php 
                            
                
                            
                            $wgender = "F";
                            $women = $model->fetchProfiles4_5($wgender);
                         
                                                        
                            if(is_array($women)){
                                echo count($women);
                            }else{
                                echo 0;
                            }
                            
                            
                            
                            
                            
                            ?></h1>
                            <span class="text-color">Women</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <i class="fi fi-rr-venus text-color" style="font-size:30px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=6&year=<?php echo $year; ?>">
                            <h1 class="text-color"><?php echo $senior; ?></h1>
                            <span class="text-color">Seniors</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <i class="fi fi-sr-people text-color" style="font-size:30px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=7&year=<?php echo $year; ?>">
                            <h1 class="text-color"><?php echo $pwd; ?></h1>
                            <span class="text-color">PWD</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                    <i class="fi fi-br-wheelchair text-color" style="font-size:30px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=8&year=<?php echo $year; ?>">
                            <h1 class="text-color"><?php 
                            
                            
                            $soloparent = "Solo-Parent";
                            $soloparentrows = $model->fetchProfiles6_7_8_9_10($soloparent);
                         
                                                        
                            if(is_array($soloparentrows)){
                                echo count($soloparentrows);
                            }else{
                                echo 0;
                            }
                             ?></h1>
                            <span class="text-color">Solo parents</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <i class="fi fi-rr-user text-color" style="font-size: 30px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=9&year=<?php echo $year; ?>">
                            <h1 class="text-color"><?php echo $out_of_school; ?></h1>
                            <span class="text-color">Out of school</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <i class="fi fi-rr-backpack text-color" style="font-size: 30px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=10&year=<?php echo $year; ?>">
                            <h1 class="text-color"><?php 
                            
                            $unemployed = "Unemployed";
                            $unemployedrows = $model->fetchProfiles6_7_8_9_10($unemployed);
                            
                            if(is_array($unemployedrows)){
                                echo count($unemployedrows);
                            }else{
                                echo 0;
                            }
                            
                            
                            
                            
                            
                            
                            ?></h1>
                            <span class="text-color">Unemployed</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                        <i class="fi fi-bs-chalkboard-user text-color" style="font-size: 30px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=11&year=<?php echo $year; ?>">
                            <h1 class="text-color"><?php 
                            
                            if(is_array($model->fetchProfiles11())){
                                echo count($model->fetchProfiles11());
                            }else{
                                echo 0;
                            }
                            
                            
                            ?></h1>
                            <span class="text-color">Infants</span>
                            <span class="text-color">(0-9 months)</span>
                            <small>Year: <?php echo $year; ?></small>
                        </a>
                    </div>

                    <div>
                    <i class="fi fi-br-child-head text-color" style="font-size: 25px;"></i>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <a href="Statistics-profile.php?type=12&year=<?php echo $year; ?>">
                            <h1 class="text-color"><?php 
                      
                            $inactive_residents = $stat_row['inactive_residents'];
                            echo $inactive_residents;
                            
                            ?></h1>
                            <span class="text-color">Inactive Residents</span>
                            <small>Year: <?php 
                            
                            if(!empty($year) && $year != 'All'){
                               
                                echo $year-1; 
                            }else{
                                echo 'All';
                            }
                            
                            ?></small>
                        </a>
                    </div>

                    <div>
                        <i class="fi fi-bs-street-view text-color" style="font-size: 30px;"></i>
                    </div>
                </div>
                
                <div class="card-single">
                    <div>
                        <h1 class="">...</h1>
                        <span>....</span>
                        <small class="">Year: <?php echo $year; ?></small>
                    </div>

                    <div>
                        <span class="las la-users text-color"></span>
                    </div>
                </div>










                <div class="card-single" style="opacity: 0;">
                    <div>
                        <a href="#>">
                        <h1 class="last-stats">...</h1>
                        <span>....</span>
                        <small class="last-card">Year: <?php echo $year; ?></small>
                        </a>
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
    <?php
    $clickable = true; // Set this dynamically based on your logic
?>

<script>
    // Check the value of the clickable variable
    var clickable = <?php echo json_encode($admin_rows); ?>;
    console.log(clickable);
    
    if (clickable == null) {

        document.addEventListener("DOMContentLoaded", function () {
            // Get all anchor links containing "Statistics-profile.php?type"
            var links = document.querySelectorAll('a[href*="Statistics-profile.php?type"]');

            // Loop through the links and remove only the href attribute
            links.forEach(function (link) {
                console.log(link);
                link.removeAttribute('href');
            });
        });

    }
</script>

</body>

