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
	
	if (isset($_POST['add_event'])) {
	    $path = 'Events/';
		$unique = time().uniqid(rand());
		$destination = $path . $unique . '.jpg';
	    $base = basename($_FILES["event_image"]["name"]);
		$image = $_FILES["event_image"]["tmp_name"];
		move_uploaded_file($image, $destination);
	    
	    $model->addEvent($unique, $_POST['event_name'], $_POST['event_place'], $_POST['event_date']);
	    
	    $rows = $model->fetchProfiles();
        
        $messageContent = $_POST['event_name']."\nWhere: ".$_POST['event_place']."\nWhen: ".date('F j, g:i A', strtotime($_POST['event_date']));
	    
	    if (!empty($rows)) {
	        foreach ($rows as $row) {
	            if (normalizeContactNumber($row['contact_no']) != 'Invalid number') {
                    try {

                        $message = $client->messages->create(normalizeContactNumber($row['contact_no']), [
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
	
	

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE-edge">
    <meta name = "viewport" content = "width=device-width, initial-scale=1, maximum-scale=1">
    <title> Events </title>
    <link rel="stylesheet" href="Css/DocCss.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<style>
    .modal-content{
        width: 50% !important;
    margin-left: 30%;
    margin-top: 10%;
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
                        <a href="Events.php"><span class="bx bxs-edit"></span>
                        <span>Events</span></a>
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

                Events
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
                    <h1>Events</h1>

                    <!--dito yung create and delete buttons-->
                    <div class="head-btn">
                        <?php
                        
                            if (isset($_SESSION['admin_sess'])) {
                    
                        ?>
                        <button type="button" onclick="openLoginForm()">Create..<span class="bx bxs-pencil"></span></button>
                        <?php
                        
                            }
                        
                        ?>
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
                                <th> Event Image </th>
                                <th> Event </th>
                                <th> Event Place </th>
                                <th> Event Date and Time </th>
                            </tr>
                        </thead>
        
                        <!--dito yng table data/-->
                        <tbody>
                            
                            <?php
                            
                                $i = 1;
                            
                                $rows = $model->fetchEvents();
                            
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                            ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td> <?php echo (empty($row['event_image'])) ? 'NO ATTACHMENT' : '<a href="" id="gov_id-'.$row['log_id'].'">Click to see attachment</a>'; ?> </td>
                                <td> <?php echo $row['event']; ?> </td>
                                <td> <?php echo $row['event_place']; ?> </td>
                                <td> <?php echo date('F j, g:i A', strtotime($row['datetime'])); ?> </td>
                            </tr>
                            
                            <?php
                            
                                if (isset($row['event_image'])) {
                            
                            ?>
                            <div id="gov_id_modal-<?php echo $row['log_id']; ?>" class="modal">
                                <div class="modal-content">
                                  <span class="close" id="gov_id_close-<?php echo $row['log_id']; ?>">&times;</span>
                                  <h2>Request</h2>
                                  <center>
                                      <img src="Events/<?php echo $row['event_image']; ?>.jpg" style="width: 65%; max-width: 100%;">
                                  </center>
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
    
    <div id="loginForm" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeLoginForm()">&times;</span>
          <h2>Add Event</h2>
          <form method="POST" enctype="multipart/form-data">
            <label for="upload">Event Image</label>
            <input type="file" name="event_image" id="upload" required>
              
            <label for="event">Event</label>
            <input type="text" id="event" name="event_name" placeholder="Event name" required>
            
            <label for="event_place">Event Place</label>
            <input type="text" id="event_place" name="event_place" placeholder="Event place" required>
            
            <label for="event_date">Event Date</label>
            <input type="datetime-local" id="event_date" name="event_date" required>
            
            <button id="login-btn" name="add_event" type="submit">Submit</button>
          </form>
        </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <script src="Javascript/Profiles.js"></script>
    <script src="Javascript/DocsReq.js"></script>
</body>
</html>
