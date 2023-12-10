<?php

require_once "vendor/autoload.php";

use setasign\Fpdi\Fpdi;

ob_start();
use Twilio\Rest\Client;

$accountSid = "AC7e2863931cfad9261ddbfdee59a66f13";
$authToken = "fda229c6636feb539074f771eb3978ad";

$client = new Client($accountSid, $authToken);

session_start();
include "Global/Model.php";
$model = new Model();

function normalizeContactNumber($phoneNumber)
{
    $phoneNumber = preg_replace("/[^0-9]/", "", $phoneNumber);

    $length = strlen($phoneNumber);

    if ($length === 11 && substr($phoneNumber, 0, 1) === "0") {
        return preg_replace("/0/", "+63", $phoneNumber, 1);
    } elseif ($length === 12 && substr($phoneNumber, 0, 3) === "639") {
        return "+" . $phoneNumber;
    } elseif ($length === 13 && substr($phoneNumber, 0, 4) === "+639") {
        return $phoneNumber;
    } else {
        return "Invalid number";
    }
}

if (isset($_POST["print_certificate"])) {
    require_once "vendor/setasign/fpdf/fpdf.php";
    require_once "vendor/setasign/fpdi/src/autoload.php";
    $pdf = new Fpdi();
    $pdf->AddPage();

    switch ($_POST["doc_type"]) {
        case "Business Closure":
            $pdf->setSourceFile("Templates/Business-Issue-Template.pdf");
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            $pdf->SetFont("Times", "B", 12);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetXY(95, 80);
            $pdf->Write(0, $_POST["full_name"]);

            $pdf->SetXY(61, 88);
            $pdf->Write(0, $_POST["f1"]);

            $pdf->SetXY(46, 96);
            $pdf->Write(0, $_POST["f2"]);

            $pdf->SetXY(36, 120);
            $pdf->Write(0, $_POST["date_approved"]);

            $pdf->SetXY(124, 143);
            $pdf->Write(0, $_POST["full_name"]);

            $pdf->SetXY(69, 175);
            $pdf->Write(0, $_POST["date_approved"]);
            break;
        case "First Time Job Seeker":
            $pdf->setSourceFile("Templates/First-Time-Job-Seeker.pdf");
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            $pdf->SetFont("Times", "B", 12);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetXY(91, 83);
            $pdf->Write(0, $_POST["full_name"]);

            $pdf->SetXY(56, 91);
            $pdf->Write(0, $_POST["f2"]);

            $pdf->SetXY(94, 150);
            $pdf->Write(0, $_POST["date_approved"]);

            $pdf->AddPage();
            $tplIdx = $pdf->importPage(2);
            $pdf->useTemplate($tplIdx, 0, 0, 200, 290);

            $pdf->SetXY(42, 73);
            $pdf->Write(0, $_POST["full_name"]);

            $pdf->SetXY(116, 73);
            $pdf->Write(0, $_POST["f1"]);

            $pdf->SetXY(41, 79);
            $pdf->Write(0, $_POST["f2"]);

            $pdf->AddPage();
            $tplIdx = $pdf->importPage(3);
            $pdf->useTemplate($tplIdx, 0, 0, 200, 290);

            $pdf->SetXY(84, 87);
            $pdf->Write(0, $_POST["full_name"]);
            break;
        case "Solo Parent":
            $pdf->setSourceFile("Templates/Solo-parent-Certificate.pdf");
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            $pdf->SetFont("Times", "B", 12);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetXY(100, 81);
            $pdf->Write(0, $_POST["full_name"]);

            $pdf->SetXY(77, 89);
            $pdf->Write(0, $_POST["f1"]);

            $pdf->SetXY(121, 97);
            $pdf->Write(0, $_POST["f2"]);

            $pdf->SetXY(47, 168);
            $pdf->Write(0, $_POST["date_approved"]);

            $pdf->SetXY(95, 184);
            $pdf->Write(0, $_POST["date_approved"]);
            break;
        case "Senior Citizen":
            $pdf->setSourceFile(
                "Templates/Identification-for-Senior-Citizen.pdf"
            );
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            $pdf->SetFont("Times", "B", 12);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetXY(56, 116);
            $pdf->Write(0, $_POST["full_name"]);

            $pdf->SetXY(64, 127);
            $pdf->Write(0, $_POST["f2"]);

            $pdf->SetXY(76, 138);
            $pdf->Write(0, $_POST["f4"]);

            $pdf->SetXY(78, 149);
            $pdf->Write(0, $_POST["f1"]);
            break;
        case "Residency":
            $pdf->setSourceFile("Templates/Residency.pdf");
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            $pdf->SetFont("Times", "B", 12);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetXY(95, 90);
            $pdf->Write(0, $_POST["full_name"]);

            $pdf->SetXY(34, 98);
            $pdf->Write(0, $_POST["f1"]);

            $pdf->SetXY(41, 106);
            $pdf->Write(0, $_POST["f2"]);

            $pdf->SetXY(37, 143);
            $pdf->Write(0, $_POST["full_name"]);

            $pdf->SetXY(75, 154);
            $pdf->Write(0, $_POST["date_approved"]);
            break;
        case "Indigency":
            $pdf->setSourceFile("Templates/Certificate-of-Indegency.pdf");
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            $pdf->SetFont("Times", "B", 12);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetXY(100, 99);
            $pdf->Write(0, $_POST["full_name"]);

            $pdf->SetXY(41, 114);
            $pdf->Write(0, $_POST["f2"]);

            $pdf->SetXY(56, 143);
            $pdf->Write(0, $_POST["f1"]);

            $pdf->SetXY(80, 158);
            $pdf->Write(0, $_POST["date_approved"]);
            break;
        case "Barangay Clearance":
            $pdf->setSourceFile("Templates/Barangay-Clearance-Template.pdf");
            $tplIdx = $pdf->importPage(1);
            $pdf->useTemplate($tplIdx, 0, 0, 200, 290);
            $pdf->SetFont("Times", "B", 12);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetXY(118, 99);
            $pdf->Write(0, $_POST["f1"]);

            $pdf->SetXY(62, 107);
            $pdf->Write(0, $_POST["f3"]);

            $pdf->SetXY(36, 115);
            $pdf->Write(0, $_POST["f2"]);

            $pdf->SetXY(101, 123);
            $pdf->Write(0, $_POST["f4"]);

            $pdf->SetXY(72, 138);
            $pdf->Write(0, $_POST["date_approved"]);
            break;
    }

    ob_end_clean();
    $pdf->Output("I", "Certificate.pdf");
}


if (isset($_POST["send_request"])) {


    $house_no = $_POST["house_no"];

    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];
    $suffix = $_POST["suffix"];
    $street = $_POST["street"];

    $contact_no = $_POST["contact_no"];
    $document_type = $_POST["document"];

    $f1 = isset($_POST["f1"]) ? $_POST["f1"] : null;
    $f2 = isset($_POST["f2"]) ? $_POST["f2"] : null;
    $f3 = isset($_POST["f3"]) ? $_POST["f3"] : null;
    $f4 = isset($_POST["f4"]) ? $_POST["f4"] : null;

    $path = "Requirement/";
    $unique = time() . uniqid(rand());
    if(!empty($_FILES["requirement"]["tmp_name"])){
        $destination = $path . $unique . ".jpg";
        $base = basename($_FILES["requirement"]["name"]);
        $image = $_FILES["requirement"]["tmp_name"];
        move_uploaded_file($image, $destination);

    }

    $date_sent = date("Y-m-d H:i:s");
    $status = "Pending";

    $addRequest = $model->addRequest(
        $house_no,
        $first_name,
        $middle_name,
        $last_name,
        $suffix,
        $contact_no,
        $document_type,
        $unique,
        $date_sent,
        $f1,
        $f2,
        $street,
        $f3,
        $f4,
        $status
    );
    $requestSuccess = true;
}

if (isset($_POST["change_request"])) {
    $status_id = $_POST["status_id"];
    $status = $_POST["status"];

    $model->changeRequestStatus($status, $status_id);

    $request_rows = $model->fetchRequest($status_id);

    if (!empty($request_rows)) {
        foreach ($request_rows as $request_row) {
            if ($status == "Cancelled") {
                $messageContent =
                    "Your request for: " .
                    $request_row["document_type"] .
                    " has been cancelled.";

                if (
                    normalizeContactNumber($request_row["contact_no"]) !=
                    "Invalid number"
                ) {
                    try {
                        $message = $client->messages->create(
                            normalizeContactNumber($request_row["contact_no"]),
                            [
                                "from" => "+15178787926",
                                "body" => $messageContent,
                            ]
                        );
                    } catch (Twilio\Exceptions\RestException $e) {
                        error_log("Twilio Exception: " . $e->getMessage());
                    }
                }
            } elseif ($status == "Delivered") {
                $model->changeRequestApproved($status_id);

                $messageContent =
                    "Your request for: " .
                    $request_row["document_type"] .
                    " has been delivered.";

                if (
                    normalizeContactNumber($request_row["contact_no"]) !=
                    "Invalid number"
                ) {
                    try {
                        $message = $client->messages->create(
                            normalizeContactNumber($request_row["contact_no"]),
                            [
                                "from" => "+15178787926",
                                "body" => $messageContent,
                            ]
                        );
                    } catch (Twilio\Exceptions\RestException $e) {
                        error_log("Twilio Exception: " . $e->getMessage());
                    }
                }
            }
        }
    }
}

$admin_rows = @$model->fetchAdminDetails($_SESSION["admin_sess"]);

if (!empty($admin_rows)) {
    foreach ($admin_rows as $admin_row) {
        $admin_username = $admin_row["username"];
        $admin_profile =
            $admin_row["profile_picture"] != null
                ? $admin_row["profile_picture"]
                : "default";
        $admin_type = $admin_row["type"];
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
    <link rel="stylesheet" href="Css/gridsystem.css">
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
        label{
            color: black;
            font-size: 18px;
        }
        body{
            background-image: url("images/bgwbanoverlay.jpg");
            background-position: right -80px;
            background-repeat: no-repeat;
            background-size: cover;
        }
        select{
            height: 50px !important;
        }
        input{
            height: 50px !important;
        }
        .table{
            border: 5px solid #FF10F0 ;
            /* background-color: #00a4ef7d; */
            background-color: #ffffffd4;
        }
        .table_body{

            background-color: #00000000;
        }
    





        .imageResize{
            width: 50% !important;
            margin-left: 30%;
            margin-top: 10%;
	}







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
                    <?php if (@$admin_type == "super") { ?>
                    <li>
                        <a href="Logsign.php"><span class="bx bxs-user-detail"></span>
                        <span>Administrator</span></a>
                    </li>
                    <?php } ?>

                    <li>
                        <a href="Home.php"><span class="bx bxs-grid-alt"></span>
                        <span>Dashboard</span></a>
                    </li>

                    <li>
						<a href="<?php echo isset($_SESSION["admin_sess"])
          ? "Profiles.php"
          : "Family.php"; ?>"><span class="bx bxs-spreadsheet"></span>
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
                    if (@$admin_type == "super") { ?>
					<!--<li>-->
					<!--	<a href=""><span class="bx bxs-business"></span>-->
					<!--	<span>Community</span></a>-->
					<!--</li>-->
                    <?php }

                    if (isset($_SESSION["admin_sess"])) { ?>
                    <li>
                        <a href="logout.php"><span class="bx bx-log-out"></span>
                        <span>Logout</span></a>
                    </li>
                    <?php } else { ?>
                    <li>
                        <a href="Logsign.php"><span class="bx bxs-log-in"></span>
                        <span>Login</span></a>
                    </li>
                    <?php }
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

            
            <?php if (isset($_SESSION["admin_sess"])) { ?>
            <div class="user-wrapper">
				<img src="Profile/<?php echo $admin_profile; ?>.jpg" width="40px" height="40px" alt="user">
				<div>
					<h4><?php echo $admin_username; ?></h4>
					<small><?php echo ucfirst($admin_type); ?> Admin</small>
				</div>
			</div>
			<?php } else { ?>
            <div class="user-wrapper">
				<div>
					<h4>Guest</h4>
					<small>Guest User</small>
				</div>
			</div>
            <?php } ?>

        </header>
<!--end nung sa top navi-->

        <!--eto na yung sa table-->
        <div class="main-content">

            <main class="table">
                <section class="table_body" style="padding:20px;">
                <div class="mainForm">

                    <center><p style="font-size:45px; font-weight: bold;">Document Request</p></center>
                    <form method="POST" enctype="multipart/form-data">
    
    
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
    
    
                        <label for="housenum">House No.</label>
                        <input type="number" id="housenum" name="house_no" placeholder="House Number" required>
                        <label for="street">Street</label>

                        <select class="select-input" name="street" id="street" required>
                            <option value="">Select Street</option>
                            <option value="JP Rizal">JP Rizal</option>
                            <option value="Caybanban">Caybanban</option>
                            <option value="Libis">Libis</option>
                            <option value="San Jose">San Jose</option>
                            <option value="Mustasa">Mustasa</option>
                        </select>
    
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
                        <label for="middle_name">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name" required>
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
                        <label for="suffix">Suffix</label>
                        <input type="text" id="suffix" name="suffix" placeholder="Suffix" required>
    
                        <label for="contactnum">Contact No.</label>
                        <input type="tel" id="contactnum" name="contact_no" placeholder="Contact Number" pattern="[0-9]{11}" required>
                        <input type="text" hidden name="send_request"  value="sendreq" required>
    
    
    
                        </select>
                        <div id="additional-info" style="display: flex; flex-direction: column; gap: 10px; border-radius: 20px;">
    
                        </div>
                        <br>
                        <div id="file-upload">
                            
                        </div>
        
    
                        <div class="login-container">
                            <input type="checkbox" id="agreeCheckbox">
                            <label for="agreeCheckbox"> I agree to the <a href="terms_and_agreement.html">Terms and Agreement</a></label>

                            <button id="login-btn" type="submit" disabled>Submit</button>
                        </div>
                </div>
                </form>
                
                </section>
            </main>
            <!--dulo nung buong container nung table-->
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="Javascript/Profiles.js"></script>
    <script>
        // Enable/disable button based on checkbox state
        document.getElementById('agreeCheckbox').addEventListener('change', function () {
            document.getElementById('login-btn').disabled = !this.checked;
        });
    </script>
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
                        $('#additional-info').html('<label for="businessname">Business Name</label><input type="text" id="businessname" name="f1" placeholder="Business name" required><label for="fulladdress" hidden>Full Address</label><input type="text" id="fulladdress" name="f2" placeholder="Full address" hidden>');
                        break;
                    case 'First Time Job Seeker':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="age">Age</label><input type="text" id="age" name="f1" placeholder="Age" required><label for="fulladdress" hidden>Full Address</label><input type="text" id="fulladdress" name="f2" placeholder="Full address" hidden>');
                        break;
                    case 'Solo Parent':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="age">Age</label><input type="text" id="age" name="f1" placeholder="Age" required><label for="fulladdress" hidden>Full name of child</label><input type="text" id="fulladdress" name="f2" placeholder="Full name of child" hidden>');
                        break;
                    case 'Senior Citizen':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="fulladdress" hidden>Full Address</label><input type="text" id="fulladdress" name="f2" placeholder="Full address" hidden><label for="dob">Date of Birth</label><input type="date" id="dob" name="f4" placeholder="Date of birth" required><label for="pob">Place of Birth</label><input type="text" id="pob" name="f1" placeholder="Place of birth" required>');
                        break;
                    case 'Residency':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="age">Age</label><input type="text" id="age" name="f1" placeholder="Age" required><label for="fulladdress" hidden>Full Address</label><input type="text" id="fulladdress" name="f2" placeholder="Full address" hidden>');
                        break;
                    case 'Indigency':
                        $('#loginForm').css({'max-height': '', 'overflow': '', 'margin-top': ''});
                        $('#additional-info').html('<label for="fulladdress" hidden hidden>Full Address</label><input type="text" id="fulladdress" name="f2" placeholder="Full address" hidden><label for="purpose">Purpose</label><input type="text" id="purpose" name="f1" placeholder="Purpose" required>');
                        break;
                    case 'Barangay Clearance':
                        $('#loginForm').css({'max-height': '100%', 'overflow': 'auto', 'margin-top': '-130px'});
                        $('#additional-info').html('<label for="businessname">Business Name</label><input type="text" id="businessname" name="f1" placeholder="Business name" required><label for="street">Business Location</label><input type="text" id="street" name="f2" placeholder="Street" required><label for="purpose">Purpose</label><input type="text" id="purpose" name="f3" placeholder="Purpose" required><label for="issued">Issued until</label><input type="date" id="issued" name="f4" required>');
                        break;
                } 
            });
        });
    </script>

<?php
    // Check if the form was submitted successfully
    if (isset($requestSuccess) && $requestSuccess) {
    ?>
        <script>
            // Use SweetAlert to show a success message
            Swal.fire({
                title: "Request Created!",
                icon: "success"
            });
        </script>
    <?php
    }
    ?>
</body>
</html>
