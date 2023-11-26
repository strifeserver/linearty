<?php
    
    
    require_once 'vendor/autoload.php';
    
    use setasign\Fpdi\Fpdi;
	
	ob_start(); 
    use Twilio\Rest\Client;
    
    $accountSid = 'AC7e2863931cfad9261ddbfdee59a66f13';
    $authToken = 'af5cd311eb3551db88cda47f7cdd1750';
        
    $client = new Client($accountSid, $authToken);
	
	session_start();
	include('Global/Model.php');
	$model = new Model();
	
	function normalizeContactNumber($phoneNumber) {
		$phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

		$length = strlen($phoneNumber);

		if ($length === 11 && substr($phoneNumber, 0, 1) === '0') {
			return preg_replace('/0/', '+63', $phoneNumber, 1);
		}
		
		elseif ($length === 12 && substr($phoneNumber, 0, 3) === '639') {
			return '+'.$phoneNumber;
		}

		elseif ($length === 13 && substr($phoneNumber, 0, 4) === '+639') {
			return $phoneNumber;
		}

		else {
			return 'Invalid number';
		}
	}

	if (isset($_POST['print_certificate'])) {
	    require_once('vendor/setasign/fpdf/fpdf.php');
    	require_once('vendor/setasign/fpdi/src/autoload.php');
    	$pdf = new Fpdi();
    	$pdf->AddPage();


	    switch ($_POST['doc_type']) {
	        case 'Business Closure':
	            $pdf->setSourceFile('Templates/Business-Issue-Template.pdf');
            	$tplIdx = $pdf->importPage(1);
            	$pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            	$pdf->SetFont('Times', 'B', 12);
            	$pdf->SetTextColor(0, 0, 0);
            		
            	$pdf->SetXY(95, 80);
            	$pdf->Write(0, $_POST['full_name']);
            	
            	$pdf->SetXY(61, 88);
            	$pdf->Write(0, $_POST['f1']);
            	
            	$pdf->SetXY(46, 96);
            	$pdf->Write(0, $_POST['f2']);
            	
            	$pdf->SetXY(36, 120);
            	$pdf->Write(0, $_POST['date_approved']);
            	
            	$pdf->SetXY(124, 143);
            	$pdf->Write(0, $_POST['full_name']);

            	$pdf->SetXY(69, 175);
            	$pdf->Write(0, $_POST['date_approved']);

             
                $pdf->SetXY(40, 159);
            	$pdf->Write(0, $_POST['ctc_no']);

            	$pdf->SetXY(150, 210);
            	$pdf->Write(0, 'Issued on: '.$_POST['date_issued']);


	            break;
	        case 'First Time Job Seeker':
	            $pdf->setSourceFile('Templates/First-Time-Job-Seeker.pdf');
            	$tplIdx = $pdf->importPage(1);
            	$pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            	$pdf->SetFont('Times', 'B', 12);
            	$pdf->SetTextColor(0, 0, 0);
            		
            	$pdf->SetXY(91, 83);
            	$pdf->Write(0, $_POST['full_name']);
            	
            	$pdf->SetXY(56, 91);
            	$pdf->Write(0, $_POST['f2']);
            	
            	$pdf->SetXY(94, 150);
            	$pdf->Write(0, $_POST['date_approved']);
            		
                $pdf->SetXY(150, 240);
            	$pdf->Write(0, 'CTC No. '.$_POST['ctc_no']);

            	$pdf->SetXY(150, 250);
            	$pdf->Write(0, 'Issued on: '.$_POST['date_issued']);


            	$pdf->AddPage();
            	$tplIdx = $pdf->importPage(2);
            	$pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            	
            	$pdf->SetXY(42, 73);
            	$pdf->Write(0, $_POST['full_name']);
            	
            	$pdf->SetXY(116, 73);
            	$pdf->Write(0, $_POST['f1']);
            	
            	$pdf->SetXY(41, 79);
            	$pdf->Write(0, $_POST['f2']);
            	
            	$pdf->AddPage();
            	$tplIdx = $pdf->importPage(3);
            	$pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            	
            	$pdf->SetXY(84, 87);
            	$pdf->Write(0, $_POST['full_name']);


	            break;
	        case 'Solo Parent':
	            $pdf->setSourceFile('Templates/Solo-parent-Certificate.pdf');
            	$tplIdx = $pdf->importPage(1);
            	$pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            	$pdf->SetFont('Times', 'B', 12);
            	$pdf->SetTextColor(0, 0, 0);
            		
            	$pdf->SetXY(100, 81);
            	$pdf->Write(0, $_POST['full_name']);
            	
            	$pdf->SetXY(77, 89);
            	$pdf->Write(0, $_POST['f1']);
            	
            	$pdf->SetXY(121, 97);
            	$pdf->Write(0, $_POST['f2']);
            	
            	$pdf->SetXY(47, 168);
            	$pdf->Write(0, $_POST['date_approved']);
            	
            	$pdf->SetXY(95, 184);
            	$pdf->Write(0, $_POST['date_approved']);

                $pdf->SetXY(120, 160);
            	$pdf->Write(0, $_POST['ctc_no']);

            	$pdf->SetXY(150, 250);
            	$pdf->Write(0, 'Issued on: '.$_POST['date_issued']);
	            break;
	        case 'Senior Citizen':
	            $pdf->setSourceFile('Templates/Identification-for-Senior-Citizen.pdf');
            	$tplIdx = $pdf->importPage(1);
            	$pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            	$pdf->SetFont('Times', 'B', 12);
            	$pdf->SetTextColor(0, 0, 0);
            		
            	$pdf->SetXY(56, 116);
            	$pdf->Write(0, $_POST['full_name']);
            	
            	$pdf->SetXY(64, 127);
            	$pdf->Write(0, $_POST['f2']);
            	
            	$pdf->SetXY(76, 138);
            	$pdf->Write(0, $_POST['f4']);
            	
            	$pdf->SetXY(78, 149);
            	$pdf->Write(0, $_POST['f1']);

                $pdf->SetXY(150, 240);
            	$pdf->Write(0, 'CTC No. '.$_POST['ctc_no']);

            	$pdf->SetXY(150, 250);
            	$pdf->Write(0, 'Issued on: '.$_POST['date_issued']);
	            break;
	        case 'Residency':
	            $pdf->setSourceFile('Templates/Residency.pdf');
            	$tplIdx = $pdf->importPage(1);
            	$pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            	$pdf->SetFont('Times', 'B', 12);
            	$pdf->SetTextColor(0, 0, 0);
            		
            	$pdf->SetXY(95, 90);
            	$pdf->Write(0, $_POST['full_name']);
            		
            	$pdf->SetXY(34, 98);
            	$pdf->Write(0, $_POST['f1']);
            	
            	$pdf->SetXY(41, 106);
            	$pdf->Write(0, $_POST['f2']);
            	
            	$pdf->SetXY(37, 143);
            	$pdf->Write(0, $_POST['full_name']);
            	
            	$pdf->SetXY(75, 154);
            	$pdf->Write(0, $_POST['date_approved']);

                $pdf->SetXY(150, 240);
            	$pdf->Write(0, 'CTC No. '.$_POST['ctc_no']);

            	$pdf->SetXY(150, 250);
            	$pdf->Write(0, 'Issued on: '.$_POST['date_issued']);
	            break;
	        case 'Indigency':
	            $pdf->setSourceFile('Templates/Certificate-of-Indegency.pdf');
            	$tplIdx = $pdf->importPage(1);
            	$pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            	$pdf->SetFont('Times', 'B', 12);
            	$pdf->SetTextColor(0, 0, 0);
            		
            	$pdf->SetXY(100, 99);
            	$pdf->Write(0, $_POST['full_name']);
            	
            	$pdf->SetXY(41, 114);
            	$pdf->Write(0, $_POST['f2']);
            	
            	$pdf->SetXY(56, 143);
            	$pdf->Write(0, $_POST['f1']);
            	
            	$pdf->SetXY(80, 158);
            	$pdf->Write(0, $_POST['date_approved']);

                $pdf->SetXY(150, 240);
            	$pdf->Write(0, 'CTC No. '.$_POST['ctc_no']);

            	$pdf->SetXY(150, 250);
            	$pdf->Write(0, 'Issued on: '.$_POST['date_issued']);
	            break;
	        case 'Barangay Clearance':
	            $pdf->setSourceFile('Templates/Barangay-Clearance-Template.pdf');
            	$tplIdx = $pdf->importPage(1);
            	$pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            	$pdf->SetFont('Times', 'B', 12);
            	$pdf->SetTextColor(0, 0, 0);
            		
            	$pdf->SetXY(118, 99);
            	$pdf->Write(0, $_POST['f1']);
            	
            	$pdf->SetXY(62, 107);
            	$pdf->Write(0, $_POST['f3']);
            	
            	$pdf->SetXY(36, 115);
            	$pdf->Write(0, $_POST['f2']);
            	
            	$pdf->SetXY(101, 123);
            	$pdf->Write(0, $_POST['f4']);
            	
            	$pdf->SetXY(72, 138);
            	$pdf->Write(0, $_POST['date_approved']);

                $pdf->SetXY(150, 240);
            	$pdf->Write(0, 'CTC No. '.$_POST['ctc_no']);

            	$pdf->SetXY(150, 250);
            	$pdf->Write(0, 'Issued on: '.$_POST['date_issued']);
	            break;
	    }
	    
	    ob_end_clean();
 	    $pdf->Output('I', 'Certificate.pdf');
	}
	
	if (isset($_POST['send_request'])) {
	    $house_no = $_POST['house_no'];
	    $pangalan = $_POST['pangalan'];
	    $contact_no = $_POST['contact_no'];
	    $document_type = $_POST['document'];
	    
	    $f1 = (isset($_POST['f1'])) ? $_POST['f1'] : NULL;
	    $f2 = (isset($_POST['f2'])) ? $_POST['f2'] : NULL;
	    $f3 = (isset($_POST['f3'])) ? $_POST['f3'] : NULL;
	    $f4 = (isset($_POST['f4'])) ? $_POST['f4'] : NULL;
	    
	    $path = 'Requirement/';
		$unique = time().uniqid(rand());
		$destination = $path . $unique . '.jpg';
	    $base = basename($_FILES["requirement"]["name"]);
		$image = $_FILES["requirement"]["tmp_name"];
		move_uploaded_file($image, $destination);
		
	    $date_sent = date("Y-m-d H:i:s");
	    $status = 'Pending';
	    
	    $model->addRequest($house_no, $pangalan, $contact_no, $document_type, $unique, $date_sent, $f1, $f2, $f3, $f4, $status);
	}
	
	if (isset($_POST['change_request'])) {
	    $status_id = $_POST['status_id'];
	    $status = $_POST['status'];
	    
	    $model->changeRequestStatus($status, $status_id);
	    
	    $request_rows = $model->fetchRequest($status_id);
	    
	    if (!empty($request_rows)) {
	        foreach ($request_rows as $request_row) {
	            if ($status == 'Cancelled') {
	                $messageContent = "Your request for: ".$request_row['document_type']." has been cancelled.";
	    
            	    if (normalizeContactNumber($request_row['contact_no']) != 'Invalid number') {
            			try {

                        $message = $client->messages->create(normalizeContactNumber($request_row['contact_no']), [
                            'from' => '+15178787926',
                            'body' => $messageContent
                        ]);
                    
                    } catch (Twilio\Exceptions\RestException $e) {
                        error_log('Twilio Exception: ' . $e->getMessage());
                    }
            		}
	            }
	            
	            elseif ($status == 'Delivered') {
	                $model->changeRequestApproved($status_id);
	                
	                $messageContent = "Your request for: ".$request_row['document_type']." has been delivered.";
	    
            	    if (normalizeContactNumber($request_row['contact_no']) != 'Invalid number') {
            			try {

                        $message = $client->messages->create(normalizeContactNumber($request_row['contact_no']), [
                            'from' => '+15178787926',
                            'body' => $messageContent
                        ]);
                    
                    } catch (Twilio\Exceptions\RestException $e) {
                        error_log('Twilio Exception: ' . $e->getMessage());
                    }
            		}
	            }
	        }
	    }
	}


    if (!isset($_SESSION['admin_sess'])) {
        header("Location: https://linearty.online/create-request-document.php");
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
    <title> Document_Request </title>
    <link rel="stylesheet" href="Css/DocCss.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
</head>
<style>
    /* .modal-content{
        width: 50% !important;
    margin-left: 30%;
    margin-top: 10%;
        } */


        .imageResize{
            width: 50% !important;
            margin-left: 30%;
            margin-top: 10%;
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

        .select-input{
		outline: none;
		font-size: 13px;
		font-weight: 500;
		color: #333;
		border: 1px solid #aaa;
		border-radius: 5px;
		padding: 0 15px;
		height: 42px;
		margin: 8px 0;
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

                Documents Request
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
                                <th> Full name </th>
                                <?php
                                
                                    if (isset($_SESSION['admin_sess'])) {
                                
                                ?>
                                <th> House num </th>
                                <th> Contact No.</th>
                                <?php
                                
                                    }
                                
                                ?>
                                <th> Document Type</th>
                                <?php
                                
                                    if (isset($_SESSION['admin_sess'])) {
                                
                                ?>
                                <th> Requirement</th>
                                <?php
                                
                                    }
                                
                                ?>
                                <th> Sent </th>
                                <th> Status </th>
                                <th> Payment </th>
                                <?php
                                
                                    if (isset($_SESSION['admin_sess'])) {
                                
                                ?>
                                <th> Action</th>
                                <?php
                                
                                    }
                                
                                ?>
                            </tr>
                        </thead>
        
                        <!--dito yng table data/-->
                        <tbody id="request_table">
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
                            
                                $rows = $model->fetchRequests();
                            
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                            ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td> <?php echo $row['pangalan']; ?> </td>
                                <?php
                                
                                    if (isset($_SESSION['admin_sess'])) {
                                
                                ?>
                                <td> <?php echo $row['house_no']; ?> </td>
                                <td> <?php echo $row['contact_no']; ?> </td>
                                <?php
                                
                                    }
                                
                                ?>
                                <td> <?php echo $row['document_type']; ?> </td>
                                <?php
                                
                                    if (isset($_SESSION['admin_sess'])) {
                                
                                ?>
                                <td> <?php echo (empty($row['requirement'])) ? 'NO GOVERMENT ID' : '<a href="" id="gov_id-'.$row['id'].'">Click to see attachment</a>'; ?> </td>
                                <?php
                                
                                    }
                                
                                ?>
                                <td> <?php echo date('F j, Y', strtotime($row['date_sent'])); ?> </td>
                                <td> <p class="status <?php echo strtolower($row['status']); ?>" <?php if (isset($_SESSION['admin_sess'])) { ?>id="change-trigger-<?php echo $row['id']; ?>"<?php } ?>><?php if ($row['status'] == "Delivered"){
                                    echo "Pick-Up";
                                }
                                else {
                                echo $row['status'];
                                }?></p> </td>
                                <td> <strong> P100 </strong> </td>
                                <?php
                                
                                    if (isset($_SESSION['admin_sess'])) {
                                
                                ?>
                                <td>
                                    <!-- <form method="POST" target="_blank"> -->
                                        <input type="hidden" name="doc_type" value="<?php echo $row['document_type']; ?>">
                                        <input type="hidden" name="full_name" value="<?php echo $row['pangalan']; ?>">
                                        <input type="hidden" name="f1" value="<?php echo $row['f1']; ?>">
                                        <input type="hidden" name="f2" value="<?php echo $row['f2']; ?>">
                                        <input type="hidden" name="f3" value="<?php echo $row['f3']; ?>">
                                        <input type="hidden" name="f4" value="<?php echo $row['f4']; ?>">
                                        <input type="hidden" name="date_approved" value="<?php echo $row['date_approved']; ?>">
                                  

                                        <?php
                                            $printDoc = [
                                                $row['document_type'],
                                                $row['pangalan'],
                                                $row['f1'],
                                                $row['f2'],
                                                $row['f3'],
                                                $row['f4'],
                                                $row['date_approved'],
                                            ];
                                            $printDoc = htmlspecialchars(json_encode($printDoc), ENT_QUOTES, 'UTF-8');
                                            ?>
                                            <button onclick="printDocument('<?php echo $printDoc; ?>')" type="submit" name="print_certificate" <?php if ($row['status'] != "Delivered" || $row['document_type'] == "Bonafide Residence") { echo 'style="opacity: 0.6;" disabled'; } ?>>
                                                Print <span class="bx bx-printer"></span>
                                            </button>


                                    <!-- </form> -->
                                </td>
                                <?php
                                
                                    }
                                
                                ?>
                            </tr>
                            <?php
                            
                                if (isset($row['requirement'])) {
                            
                            ?>
                            <div id="gov_id_modal-<?php echo $row['id']; ?>" class="modal">
                                <div class="modal-content imageResize">
                                  <span class="close" id="gov_id_close-<?php echo $row['id']; ?>">&times;</span>
                                  <h2>Request</h2>
                                  <img src="Requirement/<?php echo $row['requirement']; ?>.jpg" style="max-width: 100%;">
                                </div>
                            </div>
                            <?php
                                }

                            ?>
                            <div id="changeStatus<?php echo $row['id']; ?>" class="modal">
                                <div class="modal-content">
                                  <span class="close" onclick="closeChangeModal()">&times;</span>
                                  <h2>Change Status</h2>
                                  <form method="POST" target="_blank">
                                      <input type="hidden" name="status_id" value="<?php echo $row['id']; ?>">
                                    <label for="status-<?php echo $row['id']; ?>">Status</label>
                                    <select id="status-<?php echo $row['id']; ?>" name="status" required>
                                        <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Cancelled" <?php echo ($row['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                        <option value="Delivered" <?php echo ($row['status'] == 'Delivered') ? 'selected' : ''; ?>>Pick-Up</option>
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
        <div class="modal-content" id="insert-content">
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
                    <option value="Barangay Clearance">Barangay Clearance (Business)</option>
                </optgroup>
              <!--<option value="male">NBI Clearance</option>-->
              <!--<option value="female">Business Permit</option>-->
              <!--<option value="female">Will para mabuhay</option>-->
              <!--<option value="other">Other</option>-->
            </select>
            <div id="additional-info" style="display: flex; flex-direction: column; gap: 10px; border-radius: 20px;">

            </div>
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
                    url: "search_requests.php",
                    type: "POST",
                    data: {
                        term: term
                    },
                    success: function(data) {
                        $('#request_table').html(data);
                    }
                });
            });
            
            $('#doc').change(function() {
                switch ($(this).val()) {
                    case 'Business Closure':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="businessname">Business Name</label><input type="text" id="businessname" name="f1" placeholder="Business name" required><label for="fulladdress">Full Address</label><input type="text" id="fulladdress" name="f2" placeholder="Full address" required>');
                        break;
                    case 'First Time Job Seeker':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="age">Age</label><input type="text" id="age" name="f1" placeholder="Age" required><label for="fulladdress">Full Address</label><input type="text" id="fulladdress" name="f2" placeholder="Full address" required>');
                        break;
                    case 'Solo Parent':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="age">Age</label><input type="text" id="age" name="f1" placeholder="Age" required><label for="fulladdress">Full name of child</label><input type="text" id="fulladdress" name="f2" placeholder="Full name of child" required>');
                        break;
                    case 'Senior Citizen':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="fulladdress">Full Address</label><input type="text" id="fulladdress" name="f2" placeholder="Full address" required><label for="dob">Date of Birth</label><input type="date" id="dob" name="f4" placeholder="Date of birth" required><label for="pob">Place of Birth</label><input type="text" id="pob" name="f1" placeholder="Place of birth" required>');
                        break;
                    case 'Residency':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="age">Age</label><input type="text" id="age" name="f1" placeholder="Age" required><label for="fulladdress">Full Address</label><input type="text" id="fulladdress" name="f2" placeholder="Full address" required>');
                        break;
                    case 'Indigency':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="fulladdress">Full Address</label><input type="text" id="fulladdress" name="f2" placeholder="Full address" required><label for="purpose">Purpose</label><input type="text" id="purpose" name="f1" placeholder="Purpose" required>');
                        break;
                    case 'Barangay Clearance':
                        $('#loginForm').css({'max-height': '100%', 'overflow': 'auto', 'margin-top': '-130px'});
                        $('#additional-info').html('<label for="businessname">Business Name</label><input type="text" id="businessname" name="f1" placeholder="Business name" required><label for="street">Business Location</label><input type="text" id="street" name="f2" placeholder="Street" required><label for="purpose">Purpose</label><input type="text" id="purpose" name="f3" placeholder="Purpose" required><label for="issued">Issued until</label><input type="date" id="issued" name="f4" required>');
                        break;
                } 
            });
        });
    </script>
</body>
</html>
<script>



function printDocument(data1) {
    var printDocObj = JSON.parse(data1);

    var doc_type = printDocObj[0];
    var full_name = printDocObj[1];
    var f1 = printDocObj[2];
    var f2 = printDocObj[3];
    var f3 = printDocObj[4];
    var f4 = printDocObj[5];
    var date_approved = printDocObj[6];









    Swal.fire({
        title: "<strong><u>Print Document</u></strong>",
        icon: "info",
        html: `

        <form method="POST" target="_blank">
            <input type="hidden" name="doc_type" value="`+doc_type+`">
            <input type="hidden" name="full_name" value="`+full_name+`">
            <input type="hidden" name="f1" value="`+f1+`">
            <input type="hidden" name="f2" value="`+f2+`">
            <input type="hidden" name="f3" value="`+f3+`">
            <input type="hidden" name="f4" value="`+f4+`">
            <input type="hidden" name="print_certificate" value="`+true+`">
            <input type="hidden" name="date_approved" value="`+date_approved+`">
            <input type="text" name="ctc_no" value="">
            <input type="date" name="date_issued" value="">
            <button>Submit</button>
        </form>




        `,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonText: "Close",
        // cancelButtonText: "Cancel"
    }).then((result) => {
        // if (result.isConfirmed) {
        //     var ctcNoValue = document.getElementById('ctc_no').value;
        //     var dateIssuedValue = document.getElementById('date_issued').value;

        //     $.ajax({
        //         url: 'document.php',
        //         type: 'POST',
        //         data: {
        //             doc_type: doc_type,
        //             full_name: full_name,
        //             f1: f1,
        //             f2: f2,
        //             f3: f3,
        //             f4: f4,
        //             date_approved: date_approved,
        //             ctc_no: ctcNoValue,
        //             date_issued: dateIssuedValue,
        //         },
        //         success: function(response) {
        //             // Open a new tab with the response URL
        //             window.open(response, '_blank');
        //         },
        //         error: function(error) {
        //             console.error(error);
        //             // Handle error
        //         }
        //     });
        // }
    });
}

</script>