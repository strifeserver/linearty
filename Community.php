<?php
	
	session_start();
	include('Global/Model.php');
	$model = new Model();
	
	if (!isset($_SESSION['admin_sess'])) {
		echo "<script>window.open('Logsign.php', '_self');</script>";
	}
	
	if (isset($_POST['send_request'])) {
	    $house_no = $_POST['house_no'];
	    $pangalan = $_POST['pangalan'];
	    $contact_no = $_POST['contact_no'];
	    $document_type = $_POST['document'];
	    
	    $path = 'Requirement/';
		$unique = time().uniqid(rand());
		$destination = $path . $unique . '.jpg';
	    $base = basename($_FILES["requirement"]["name"]);
		$image = $_FILES["requirement"]["tmp_name"];
		move_uploaded_file($image, $destination);
		
	    $date_sent = date("Y-m-d H:i:s");
	    $status = 'Pending';
	    
	    $model->addRequest($house_no, $pangalan, $contact_no, $document_type, $unique, $date_sent, $status);
	}
	
	if (isset($_POST['change_request'])) {
	    $status_id = $_POST['status_id'];
	    $status = $_POST['status'];
	    
	    $model->changeRequestStatus($status, $status_id);
	}
	
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
    <title> Community </title>
    <link rel="stylesheet" href="Css/DocCss.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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
                    <li>
                        <a href="Logsign.php"><span class="bx bxs-user-detail"></span>
                        <span>Administrator</span></a>
                    </li>

                    <li>
                        <a href="Home.php"><span class="bx bxs-grid-alt"></span>
                        <span>Dashboard</span></a>
                    </li>

                    <li>
                        <a href="Profiles.php"><span class="bx bxs-spreadsheet"></span>
                        <span>Family Profile</span></a>
                    </li>

                    <li>
                        <a href="Statistics.php"><span class="bx bxs-spreadsheet"></span>
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

                    <li>
                        <a href=""><span class="bx bxs-business"></span>
                        <span>Community</span></a>
                    </li>

                    <li>
                        <a href="logout.php"><span class="bx bx-log-out"></span>
                        <span>Logout</span></a>
                    </li>

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

                Documents Request
            </h2>

            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search here" />
            </div>


            <div class="user-wrapper">
				<img src="Profile/<?php echo $admin_profile ?>.jpg" width="40px" height="40px" alt="user">
				<div>
					<h4><?php echo $admin_username; ?></h4>
					<small><?php echo ucfirst($admin_type); ?> Admin</small>
				</div>
			</div>

        </header>
<!--end nung sa top navi-->

        <!--eto na yung sa table-->
        <div class="main-content">

            <main class="table">

                <section class="table_header">
                    <h1>Current Request</h1>

                    <!--dito yung create and delete buttons-->
                    <div class="head-btn">
                        <button onclick="openLoginForm()">Create..<span class="bx bxs-pencil"></span></button>
                        <div class="del"><button>Delete..<span class="bx bxs-trash"></span></button></div>
                    </div>

                </section>
        
                <!--code nung pinaka table-->
                <!--yung links sa table data or TD is yung dummy profile nung ng send ng request-->
                <section class="table_body">

                    <!--table head-->
                    <table>
                        <thead>
                            <tr>
                                <th> id </th>
                                <th> House num </th>
                                <th> Contact No.</th>
                                <th> Document Type</th>
                                <th> Sent </th>
                                <th> Status </th>
                                <th> Payment </th>
                            </tr>
                        </thead>
        
                        <!--dito yng table data/-->
                        <tbody>
                            <!--<tr>-->
                                <!--eot naman yung mga sa dummy data/ na mapapalitan acording sa laman ni database-->
                            <!--    <td> 1 </td>-->
                            <!--    <td><img src="https://i.pinimg.com/736x/06/b3/d6/06b3d6e0a295c5e80c09afca7a48a5f2.jpg" alt="">20012</td>-->
                            <!--    <td> 091345672012 </td>-->
                            <!--    <td> NBI Clearance </td>-->
                            <!--    <td> June 17, 2023 </td>-->
                            <!--    <td> <p class="status delivered">Delivered</p> </td>-->
                            <!--    <td> <strong> P100 </strong> </td>-->
                            <!--</tr>-->
                            
                            <?php
                            
                                $i = 1;
                            
                                $rows = $model->fetchCommunity();
                            
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                            ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td> <?php echo $row['house_no']; ?> </td>
                                <td> <?php echo $row['contact_no']; ?> </td>
                                <td> <?php echo $row['document_type']; ?> </td>
                                <td> <?php echo date('F j, Y', strtotime($row['date_sent'])); ?> </td>
                                <td> <p class="status <?php echo strtolower($row['status']); ?>" id="change-trigger-<?php echo $row['id']; ?>"><?php echo $row['status']; ?></p> </td>
                                <td> <strong> P100 </strong> </td>
                            </tr>
                            <div id="changeStatus<?php echo $row['id']; ?>" class="modal">
                                <div class="modal-content">
                                  <span class="close" onclick="closeChangeModal()">&times;</span>
                                  <h2>Change Status</h2>
                                  <form method="POST">
                                      <input type="hidden" name="status_id" value="<?php echo $row['id']; ?>">
                                    <label for="status-<?php echo $row['id']; ?>">Type of Document</label>
                                    <select id="status-<?php echo $row['id']; ?>" name="status" required>
                                        <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Cancelled" <?php echo ($row['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                        <option value="Delivered" <?php echo ($row['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
                                      <!--<option value="male">NBI Clearance</option>-->
                                      <!--<option value="female">Business Permit</option>-->
                                      <!--<option value="female">Will para mabuhay</option>-->
                                      <!--<option value="other">Other</option>-->
                                    </select>
                                    <br>
                                    <button id="login-btn" name="change_request" type="submit">Submit</button>
                                  </form>
                                </div>
                              </div>
                            <?php
                                        $i++;
                                    }
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

    <script src="Javascript/DocsReq.js"></script>
</body>
</html>
