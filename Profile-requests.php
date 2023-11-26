<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require 'vendor/autoload.php';
	
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
	
	if (isset($_POST['approve_request'])) {
	    $mail = new PHPMailer(true);

    	$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    	$mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'azraelgriffin.riego@gmail.com';
        $mail->Password = 'ecavbuyseyfggbcm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        
        $mail->setFrom('noreply@linearty.com', 'Linearty');
        $mail->addAddress($_POST['email']);
        
        $mail->isHTML(true);
        
        $mail->Subject = 'Profile Edit Request';
        $mail->Body = 'Hello '.$_POST['pangalan'].',<br><br>Your request to update your profile has been approved.<br>Your profile can be updated using this link: <a href="https://linearty.online/Update-family.php?id='.$_POST['profile_id'].'">Click to redirect to page</a>';
        
        // Send the email
        if ($mail->send()) {
            $model->removeEditRequest($_POST['approve_id']);
        	echo "<script>window.open('Profile-requests.php', '_self');</script>";
        }
	}
	
	if (isset($_POST['decline_request'])) {
	    $mail = new PHPMailer(true);

    	$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    	$mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'azraelgriffin.riego@gmail.com';
        $mail->Password = 'ecavbuyseyfggbcm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        
        $mail->setFrom('noreply@linearty.com', 'Linearty');
        $mail->addAddress($_POST['email']);
        
        $mail->isHTML(true);
        
        $mail->Subject = 'Profile Edit Request';
        $mail->Body = 'Hello '.$_POST['pangalan'].',<br><br>Your request to update your profile has been denied.';
        
        // Send the email
        if ($mail->send()) {
            $model->removeEditRequest($_POST['decline_id']);
        	echo "<script>window.open('Profile-requests.php', '_self');</script>";
        }
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE-edge">
    <meta name = "viewport" content = "width=device-width, initial-scale=1, maximum-scale=1">
    <title> Family Profiles </title>
    <link rel="stylesheet" href="Css/DocCss.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<style>

    .modal-content{
        width: 35% !important;
    margin-left: 40%;
    margin-top: 12%;
        }
        label{
    color: black;
    font-size: 18px;
}
body{
    background-image: url("images/bgwbanoverlay.jpg");
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
}
select{
    height: 50px !important;
}
input{
    height: 50px !important;
}
.table, .table2, .checker, main, .fam-footer{
    border: 5px solid #FF10F0 ;
    /* background-color: #00a4ef7d; */
    background-color: #ffffffd4;
}
.table_body{

    background-color: #00000000;
}
</style>
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
    <!--end nung side bar nav-->


    <div class="main-content">
            <!--start nung sa top navi-->
        <header>

            <h2>

                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>

                Family Profiles
            </h2>

            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search here" />
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
                    <h1>Requests</h1>

                </section>
        
                <!--code nung pinaka table-->
                <!--yung links sa table data or TD is yung dummy profile nung ng send ng request-->
                <section class="table_body">

                    <!--table head-->
                    <table>
                        <thead>
                            <tr>
                                <th> id </th>
                                <th> Pangalan ng nagsagot </th>
                                <th> Email </th>
                                <th> House num </th>
                                <th> Contact No.</th>
                                <th> Government ID</th>
                                <th> Sent </th>
                                <th> Action </th>
                            </tr>
                        </thead>
        
                        <!--dito yng table data/-->
                        <tbody>
                            
                            <?php
                            
                                $i = 1;
                            
                                $rows = $model->fetchEditRequests();
                            
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                            ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td> <?php echo $row['pangalan']; ?> </td>
                                <td> <?php echo $row['email']; ?> </td>
                                <td> <?php echo $row['house_no']; ?> </td>
                                <td> <?php echo $row['contact_no']; ?> </td>
                                <td> <?php echo (empty($row['gov_id'])) ? 'NO GOVERMENT ID' : '<a href="" id="gov_id-'.$row['id'].'">Click to see attachment</a>'; ?> </td>
                                <td> <?php echo date('F j, Y g:i A', strtotime($row['date_sent'])); ?> </td>
                                <td> 
                                    <div style="display: flex; justify-content: space-between;">
                                    <button type="button" id="approve-<?php echo $row['id']; ?>"><span class="bx bx-check" ></span></button>
                                    <button type="button" id="decline-<?php echo $row['id']; ?>"><span class="bx bx-x" ></span></button>
                                    </div>
                                    <!--<div class="del"><button>Delete..<span class="bx bxs-trash"></span></button></div>-->
                                </td>
                            </tr>
                            <div id="approveForm-<?php echo $row['id']; ?>" class="modal">
                                <div class="modal-content">
                                    <span class="close" id="closeApproveForm-<?php echo $row['id']; ?>">&times;</span>
                                    <h2>Approve</h2>
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="approve_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="profile_id" value="<?php echo $row['profile_id']; ?>">
                                        
                                        <label>Pangalan ng nagsagot</label>
                                        <input type="text" placeholder="Pangalan ng nagsagot" name="pangalan" value="<?php echo $row['pangalan']; ?>" readonly><br>
                                        
                                        <label>Email</label>
                                        <input type="text" placeholder="Email" name="email" value="<?php echo $row['email']; ?>" readonly>
                                        <br>
                                        <label>Government ID</label><br>
                                        <img src="Requirement/<?php echo $row['gov_id']; ?>.jpg" style="max-width: 100%;">
                        
                                        <button name="approve_request" type="submit">Approve</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div id="declineForm-<?php echo $row['id']; ?>" class="modal">
                                <div class="modal-content">
                                    <span class="close" id="closeDeclineForm-<?php echo $row['id']; ?>">&times;</span>
                                    <h2>Decline</h2>
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="decline_id" value="<?php echo $row['id']; ?>">
                                        
                                        <label>Pangalan ng nagsagot</label>
                                        <input type="text" placeholder="Pangalan ng nagsagot" name="pangalan" value="<?php echo $row['pangalan']; ?>" readonly><br>
                                        
                                        <label>Email</label><br>
                                        <input type="text" placeholder="Email" name="email" value="<?php echo $row['email']; ?>" readonly>
                                        <br>
                                        <label>Government ID</label><br>
                                        <img src="Requirement/<?php echo $row['gov_id']; ?>.jpg" style="max-width: 100%;">
                        
                                        <button name="decline_request" type="submit">Decline</button>
                                    </form>
                                </div>
                            </div>
                            <?php
                            
                                if (isset($row['gov_id'])) {
                            
                            ?>
                            <div id="gov_id_modal-<?php echo $row['id']; ?>" class="modal">
                                <div class="modal-content">
                                  <span class="close" id="gov_id_close-<?php echo $row['id']; ?>">&times;</span>
                                  <h2>Request</h2>
                                  <img src="Requirement/<?php echo $row['gov_id']; ?>.jpg" style="max-width: 100%;">
                                </div>
                            </div>
                            <?php
                                }
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="Javascript/ProfReq.js"></script>  
    <script src="Javascript/Profiles.js"></script>
</body>
</html>
