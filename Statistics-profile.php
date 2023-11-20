<?php

    require_once 'vendor/autoload.php';

    use Twilio\Rest\Client;
    
    $accountSid = 'AC7e2863931cfad9261ddbfdee59a66f13';
    $authToken = 'af5cd311eb3551db88cda47f7cdd1750';
    
    $client = new Client($accountSid, $authToken);
        
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
    <title> Statistics Profiles </title>
    <link rel="stylesheet" href="Css/DocCss.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .status.approved {
            background-color: #86e49d;
            color: #006b21;
        }
        
        .status.declined {
            background: #d893a3;
            background-color: #d893a3;
            color: #b30021;
        }

        .modal-content{
            width: 960px;
            margin-left: 20%;
            margin-top: 10%;
        }
    </style>
</head>
<body>

    <!--start nung side navigation bar-->
    <input type="checkbox" id="nav-toggle">
    <div class="sidebar">   

        <!--eto yung sa LINEARITY LOGO-->
        <div class="sidebar-brand">
            <h2><span class="lab la-accusoft"></span> <span> LINEARiTY </span> </h2>
        </div>

        <!--container nung buttons-->
        <div class="sidebar-menu">
                <ul>

                    <!--A yung buttons mga naka hyper links links-->
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
                        <a href="Profiles.php"><span class="bx bxs-spreadsheet"></span>
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
                    
                    ?>

                </ul>
        </div>
    </div>
    <!--end nung side bar nav-->


    <div class="main-content">
            <!--start nung sa top navi-->
        <header>

            <h2>

                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>

                Statistics Profiles
            </h2>

            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" id="search" placeholder="Search here" />
            </div>

            
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

        </header>
<!--end nung sa top navi-->

        <!--eto na yung sa table-->
        <div class="main-content">
        
        
<?php

                            $type = isset($_GET['type']) ? $_GET['type'] : '';
                            $year = isset($_GET['year']) ? $_GET['year'] : '';
                            
                            if ($type == "1") {
                                $type_name = "TOTAL POPULATION";
                                include('Statistics/1.php');
                                
                            }
                            else if ($type == "2") {
                                $type_name = "ACTIVE RESIDENTS";
                                include('Statistics/2.php');
                            }
                            else if ($type == "3") {
                                $type_name = "HOUSEHOLDS";
                                include('Statistics/3.php');
                            }
                            else if ($type == "4") {
                                $type_name = "MEN";
                                include('Statistics/4.php');
                            }
                            else if ($type == "5") {
                                $type_name = "WOMEN";
                                include('Statistics/5.php');
                            }
                            else if ($type == "6") {
                                $type_name = "SENIORS";
                                include('Statistics/6.php');
                            }
                            else if ($type == "7") {
                                $type_name = "";
                                include('Statistics/7.php');
                            }
                            else if ($type == "8") {
                                $type_name = "SOLO PARENTS";
                                include('Statistics/8.php');
                            }
                            else if ($type == "9") {
                                $type_name = "OUT OF SCHOOL";
                                include('Statistics/9.php');
                            }
                            else if ($type == "10") {
                                $type_name = "UNEMPLOYED";
                                include('Statistics/10.php');
                            }
                            else if ($type == "11") {
                                $type_name = "INFANTS (0-9 MONTHS)";
                                include('Statistics/11.php');
                            }
                            else if ($type == "12") {
                                $type_name = "INACTIVE RESIDENTS";
                                include('Statistics/12.php');
                            }
                            else {
                                $type_name = "TOTAL POPULATION";
                                include('Statisticss/1.php');
                            }
?>
            <!--dulo nung buong container nung table-->
        </div>
    </div>

    <div id="loginForm" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeLoginForm()">&times;</span>
          <h2>Request</h2>
          <form method="POST" enctype="multipart/form-data">
            <label for="housenum">House No.</label>
            <input type="number" id="housenum" name="house_no" placeholder="House Number" required>

            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="pangalan" placeholder="Full name" required>

            <label for="contactnum">Contact No.</label>
            <input type="tel" id="contactnum" name="contact_no" placeholder="Contact Number" pattern="[0-9]{11}" required>

            <label for="doc">Type of Document</label>
            <select id="doc" name="document" required>
                <option value="" disabled selected>Select your document</option>
                <optgroup label="Certification">
                    <option value="Business Closure">Business Closure</option>
                    <option value="First Time Job Seeker">First Time Job Seeker</option>
                    <option value="Solo Parent">Solo Parent</option>
                    <option value="Senior Citizen">Senior Citizen</option>
                </optgroup>
                <optgroup label="Clearance">
                    <option value="Residency">Residency</option>
                    <option value="Indigency">Indigency</option>
                    <option value="Bonafide Residence">Bonafide Residence</option>
                </optgroup>
              <!--<option value="male">NBI Clearance</option>-->
              <!--<option value="female">Business Permit</option>-->
              <!--<option value="female">Will para mabuhay</option>-->
              <!--<option value="other">Other</option>-->
            </select>
            <div id="file-upload">
                
            </div>
            <button id="login-btn" name="send_request" type="submit">Submit</button>
          </form>
        </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script src="Javascript/Profiles.js"></script>
    <script src="Javascript/DocsReq.js"></script>
    
    <script>
        $(function() {
            $('#search').keyup(function() {
                var term = $(this).val();
                 
                $.ajax({
                   url: "search_profiles.php",
                   type: "POST",
                   data: {
                     term: term
                   },
                   success: function(data) {
                       $('#profile_table').html(data);
                   }
                });
            });
        });
    </script>
</body>
</html>
