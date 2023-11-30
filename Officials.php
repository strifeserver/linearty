<?php

    require_once 'vendor/autoload.php';

    use Twilio\Rest\Client;
    
    $accountSid = 'AC7e2863931cfad9261ddbfdee59a66f13';
    $authToken = 'fda229c6636feb539074f771eb3978ad';
    
    $client = new Client($accountSid, $authToken);
        
	session_start();
	include('Global/Model.php');
	$model = new Model();
	
	$admin_rows = $model->fetchAdminDetails(@$_SESSION['admin_sess']);
	
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
    <title> Barangay Officials </title>
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

        body{
            background-image: url("images/bgwbanoverlay.jpg");
            background-position: right -80px;
            background-repeat: no-repeat;
            background-size: cover;
        }


        .table{
            border: 5px solid #FF10F0 ;
            /* background-color: #00a4ef7d; */
            background-color: #ffffffd4;
        }
        .table_body{

            background-color: #00000000;
        }

    </style>
    <style>
.custom-button {
    background-color: red; /* Background color changed to red */
    color: #fff; /* Text color (white in this case) */
    padding: 10px 20px; /* Padding around the text */
    border: none; /* Remove the button border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Cursor style on hover */
    font-size: 16px; /* Text size */
}

/* Define styles for button on hover */
.custom-button:hover {
    background-color: #c40000; /* Button background color on hover (a different shade of red) */
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
    <!--end nung side bar nav-->


    <div class="main-content">
            <!--start nung sa top navi-->
        <header>

            <h2>

                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>

                Barangay Officials
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
        
        
        
        
        
        
        
        
        
        
        
        
             <main class="table">
                <section class="table_header">
                    <h1>Brgy. Officials</h1>
                    <?php
					
					
					    if (isset($_SESSION['admin_sess'])) {
                    
                    ?>
                    <div class="head-btn"> <!--<a href=""><div class="del"> <button type="button"> Delete..  <span class="bx bxs-trash"></span></button> </div></a>--> <a href="Add-Official.php"><div class="edit"> <button type="button"> Add Barangay Official  <span class="bx bxs-plus"></span></button> </div></a> 
                    </div>
                    <?php
                    
                        }
                        
                        else {
                            
                    ?>

                    <?php
                            
                        }
                    
                    ?>
                    
                    
                    
                </section>
        
                <!--code nung pinaka table-->
                <!--yung links sa table data or TD is yung dummy profile nung ng send ng request-->
                <section class="table_body">

                    <!--table head-->
                    <table>
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Name </th>
                                <th>  </th>
                                <th> Position </th>
                                <th> Email </th>
                                <th> Rendered Service</th>
                                
					<?php
					
					
					    if (isset($_SESSION['admin_sess'])) {
                    
                    ?>
                    <th> Action </th>
                    <?php
                    
                        }
                        
                        else {
                            
                    ?>

                    <?php
                            
                        }
                    
                    ?>
                    
                    
                    
                    
                            </tr>
                        </thead>
        
                        <!--dito yng table data/-->
                        <tbody id="profile_table">
                            
                            <?php
                            
                                $i = 1;
                            
                                $rows = $model->fetchPunongBrgy(1);
                            
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        
                                        $org_id = $row['id'];
                            ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td> <center><a href="org-structure/<?php echo $row['image_unique']; ?>.jpg" target="_blank"><img src="org-structure/<?php echo $row['image_unique']; ?>.jpg" style="width: 120px;height: 120px; object-fit: cover;"></a></center></td>
                                <td><?php echo $row['name']; ?> </td>
                                <td> <?php echo $row['position']; ?> </td>
                                <td> <?php echo $row['email']; ?> </td>
                                <td> <?php echo $row['rendered_service']; ?> </td>
                                
					<?php

					
					    if (isset($_SESSION['admin_sess'])) {
                    
                    ?>
                    <td> <form class="" method="POST">
                                        <input type="hidden" name="org_id" value="<?php echo $org_id; ?>">
                                        <input type="submit" class="custom-button" name="archive" onclick="return confirm('Are you sure you want to delete this Barangay Official?')" value="Delete">
                                    
                                    </form>
                                </td>
                    <?php
                    
                        }
                        
                        else {
                            
                    ?>

                    <?php
                            
                        }
                    
                    ?>
                    
                    
                                
                            </tr>

                              
                            <?php
                                        $i++;
                                    }
                                }
                                
                                if (isset($_POST['archive'])) {
									$status = 100;
									$model->deleteOrgStructure($_POST['org_id']);
									echo "<script>alert('Barangay Profile has been deleted!');window.open('Officials.php','_self');</script>";
								}
                            
                            ?>
                        </tbody>
                    </table>
                </section>
            </main>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

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
