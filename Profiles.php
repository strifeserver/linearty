<?php

require_once 'vendor/autoload.php';

use Twilio\Rest\Client;

$accountSid = 'AC7e2863931cfad9261ddbfdee59a66f13';
$authToken = 'af5cd311eb3551db88cda47f7cdd1750';

$client = new Client($accountSid, $authToken);

session_start();
include 'Global/Model.php';
$model = new Model();

$admin_rows = $model->fetchAdminDetails($_SESSION['admin_sess']);

if (!empty($admin_rows)) {
    foreach ($admin_rows as $admin_row) {
        $admin_username = $admin_row['username'];
        $admin_profile = ($admin_row['profile_picture'] != null) ? $admin_row['profile_picture'] : 'default';
        $admin_type = $admin_row['type'];
    }
}

function normalizeContactNumber($phoneNumber)
{
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    $length = strlen($phoneNumber);

    if ($length === 11 && substr($phoneNumber, 0, 1) === '0') {
        return preg_replace('/0/', '+63', $phoneNumber, 1);
    } elseif ($length === 12 && substr($phoneNumber, 0, 3) === '639') {
        return '+' . $phoneNumber;
    } elseif ($length === 13 && substr($phoneNumber, 0, 4) === '+639') {
        return $phoneNumber;
    } else {
        return 'Invalid number';
    }
}

if (isset($_POST['change_request'])) {
    $status_id = $_POST['status_id'];
    $status = $_POST['status'];
    $contact_no = $_POST['status_contact'];

    $model->changeProfileStatus($status, $status_id);

    if ($status == 'Declined') {
        $messageContent = "Your application for family profile has been declined.";

        if (normalizeContactNumber($contact_no) != 'Invalid number') {
            try {

                $message = $client->messages->create(normalizeContactNumber($contact_no), [
                    'from' => '+15178787926',
                    'body' => $messageContent,
                ]);

            } catch (Twilio\Exceptions\RestException $e) {
                error_log('Twilio Exception: ' . $e->getMessage());
            }
        }
    } elseif ($status == 'Approved') {
        $messageContent = "Your application for family profile has been approved.";

        if (normalizeContactNumber($contact_no) != 'Invalid number') {
            try {

                $message = $client->messages->create(normalizeContactNumber($contact_no), [
                    'from' => '+15178787926',
                    'body' => $messageContent,
                ]);

            } catch (Twilio\Exceptions\RestException $e) {
                error_log('Twilio Exception: ' . $e->getMessage());
            }
        }
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
            width: 50% !important;
            margin-left: 30%;
            margin-top: 10%;
	}
    .modal{
        min-width: 70%;
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

                Family Profiles
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

} else {

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
                    <h1>Profiles</h1>

                    <!--dito yung create and delete buttons-->
                    <div class="head-btn">
                        <a href="Family.php"><button type="button">Create..<span class="bx bxs-pencil"></span></button></a>
                        <a href="Profile-requests.php"><button type="button">Requests..<span class="bx bx-list-ol"></span></button></a>
                        <!--<div class="del"><button>Delete..<span class="bx bxs-trash"></span></button></div>-->
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
                                <th> Pangalan ng nagsagot </th>
                                <th> House num </th>
                                <th> Contact No.</th>
                                <th> Government ID</th>
                                <th> Sent </th>
                                <th> Status </th>
                            </tr>
                        </thead>

                        <!--dito yng table data/-->
                        <tbody id="profile_table">

                            <?php

$i = 1;

$rows = $model->fetchProfiles();

if (!empty($rows)) {
    foreach ($rows as $row) {
        ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td> <a href="Update-family.php?id=<?php echo $row['id']; ?>"><?php echo $row['pangalan']; ?></a> </td>
                                <td> <?php echo $row['house_no']; ?> </td>
                                <td> <?php echo $row['contact_no']; ?> </td>
                                <td> <?php echo (empty($row['requirement']) || $row['requirement'] == "EMPTY") ? 'NO GOVERMENT ID' : '<a href="" id="gov_id-' . $row['id'] . '">Click to see attachment</a>'; ?> </td>
                                <td> <?php echo date('F j, Y', strtotime($row['petsa'])); ?> </td>
                                <td> <p class="status <?php echo strtolower($row['status']); ?>" id="change-trigger-<?php echo $row['id']; ?>"><?php echo $row['status']; ?></p> </td>
                            </tr>

                            <?php

        if (isset($row['requirement'])) {

            ?>
                            <div id="gov_id_modal-<?php echo $row['id']; ?>" class="modal">
                                <div class="modal-content">
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
                                  <span class="close">&times;</span>
                                  <h2>Change Status</h2>
                                  <form method="POST">
                                      <input type="hidden" name="status_id" value="<?php echo $row['id']; ?>">
                                      <input type="hidden" name="status_contact" value="<?php echo $row['contact_no']; ?>">
                                    <label for="status-<?php echo $row['id']; ?>">Status</label>
                                    <select id="status-<?php echo $row['id']; ?>" name="status" required>
                                        <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Declined" <?php echo ($row['status'] == 'Declined') ? 'selected' : ''; ?>>Declined</option>
                                        <option value="Approved" <?php echo ($row['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
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
