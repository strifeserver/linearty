<?php

session_start();
include 'Global/Model.php';
$model = new Model();

if (empty($_GET['id'])) {
    echo "<script>window.open('Family.php','_self');</script>";
}

if (isset($_POST['submit_profile'])) {
    $house_no = $_POST['house_no'];
    $street = $_POST['street'];
    $apartment_owner = $_POST['apartment_owner'];
    $sitio = $_POST['sitio'];
    $relihiyon = $_POST['relihiyon'];
    $contact_no = $_POST['contact_no'];

    for ($i = 1; $i <= 4; $i++) {
        $tgnum = "tg" . $i . "";
        $$tgnum = (isset($_POST['tg' . $i . ''])) ? $_POST['tg' . $i . ''] : "0";
    }

    for ($i = 1; $i <= 4; $i++) {
        $pnum = "p" . $i . "";
        $$pnum = (isset($_POST['p' . $i . ''])) ? $_POST['p' . $i . ''] : "0";
    }

    $tanim = $_POST['tanim'];
    $hardin = $_POST['hardin'];
    $manok = $_POST['manok'];
    $baboy = $_POST['baboy'];

    for ($i = 1; $i <= 2; $i++) {
        $gnnum = "gn" . $i . "";
        $$gnnum = (isset($_POST['gn' . $i . ''])) ? $_POST['gn' . $i . ''] : "0";
    }

    for ($i = 1; $i <= 3; $i++) {
        $kbnum = "kb" . $i . "";
        $$kbnum = (isset($_POST['kb' . $i . ''])) ? $_POST['kb' . $i . ''] : "0";
    }

    for ($i = 1; $i <= 2; $i++) {
        $ppnum = "pp" . $i . "";
        $$ppnum = (isset($_POST['pp' . $i . ''])) ? $_POST['pp' . $i . ''] : "0";
    }

    for ($i = 1; $i <= 7; $i++) {
        $fpnum = "fp" . $i . "";
        $$fpnum = (isset($_POST['fp' . $i . ''])) ? $_POST['fp' . $i . ''] : "0";
    }


    $pangalan = $_POST['pangalan'];
    $petsa = @$_POST['petsa'];

    $tubig = $tg1 . ", " . $tg2 . ", " . $tg3 . ", " . $tg4;
    $palikuran = $p1 . ", " . $p2 . ", " . $p3 . ", " . $p4;

    $gumagamit_ng = $gn1 . ", " . $gn2;
    $buntis = $kb1 . ", " . $kb2 . ", " . $kb3;
    $pamilya = $pp1 . ", " . $pp2;
    $family_planning = $fp1 . ", " . $fp2 . ", " . $fp3 . ", " . $fp4 . ", " . $fp5 . ", " . $fp6 . ", " . $fp7;


    $model->updateFamilyProfile($house_no, $street, $apartment_owner, $sitio, $relihiyon, $contact_no, $tubig, $palikuran, $tanim, $hardin, $manok, $baboy, $gumagamit_ng, $buntis, $pamilya, $family_planning, $pangalan, $_GET['id']);

    $model->removeKabahayan($_GET['id']);
    $model->removeKabataan($_GET['id']);

	foreach ($_POST['first_name'] as $key => $kbhyn) {
		$kabahayan_name = [
			'first_name' => @$_POST['first_name'][$key],
			'middle_name' => @$_POST['middle_name'][$key],
			'last_name' => @$_POST['last_name'][$key],
			'suffix' => @$_POST['suffix'][$key],
		];
		$kabahayan_status = (isset($_POST['kabahayan_status'][$key])) ? $_POST['kabahayan_status'][$key] : "N/A";
	
		$model->insertKabahayanRow($_GET['id'], $kabahayan_name, $_POST['kabahayan_dob'][$key], $_POST['kabahayan_age'][$key], $_POST['kabahayan_gender'][$key], $_POST['kabahayan_civil'][$key], $_POST['kabahayan_relationship'][$key], $_POST['kabahayan_occupation'][$key], $_POST['kabahayan_year'][$key], $kabahayan_status);
	}

	foreach ($_POST['bata_first_name'] as $ky => $bt) {
		if (trim($ky) != '') {
			$kabataan_name = [
				'first_name' => @$_POST['bata_first_name'][$key],
				'middle_name' => @$_POST['bata_middle_name'][$key],
				'last_name' => @$_POST['bata_last_name'][$key],
				'suffix' => @$_POST['bata_suffix_name'][$key],
			];
		
			@$model->insertKabataanRow($_GET['id'], $kabataan_name, $_POST['bata_kapanganakan'][$ky], $_POST['bata_edad'][$ky], $_POST['bata_kasarian'][$ky], $_POST['bata_bakuna'][$ky]);   
		}
	}
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
	<title> Family Profile Form </title>
	<link rel="stylesheet" href="Css/Family.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
	<form method="POST">
<!------ ANIMATED SIDE NAV BAR START ------------------------------------------------------------------------------>
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
<!------ ANIMATED SIDE NAV BAR ENDS  ------------------------------------------------------------------------------>

<!------ TOP NAV BAR START ---------------------------------------------------------------------------------------->
	<div class="main-content">
	    <?php

$profile_rows = $model->fetchProfile($_GET['id']);

if (!empty($profile_rows)) {
    foreach ($profile_rows as $profile_row) {
        $tubig = explode(", ", $profile_row['tubig']);
        $palikuran = explode(", ", $profile_row['palikuran']);
        $gumagamit_ng = explode(", ", $profile_row['gumagamit_ng']);
        $buntis = explode(", ", $profile_row['buntis']);
        $pamilya = explode(", ", $profile_row['pamilya']);
        $family_planning = explode(", ", $profile_row['family_planning']);

        ?>
		<header>

			<h2>

				<label for="nav-toggle">
					<span class="las la-bars"></span>
				</label>

				Family Profile Form
			</h2>

<!------ SEARCH BAR  ----------------------------------------------------------------->
			<div class="search-wrapper">
				<span class="las la-search"></span>
				<input type="search" placeholder="Search here" />
			</div>
<!------ SEARCH BAR  ----------------------------------------------------------------->

<!------ ADMIN PROFILE  -------------------------------------------------------------->
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
<!------ ADMIN PROFILE  -------------------------------------------------------------->
		</header>
		<style>


.form-field{
		height: 80px;
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


	input[type="checkbox"] {
		width: 25px;
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

	.btn{
	background-color: var(--vermain-color);
    width: fit-content;
    margin-left: 5px;
    border-radius: 10px;
    color: #fff;
    font-size: 13px;
    padding: .5rem ;
    border: 1px solid var(--vermain-color);
}

		</style>
<!------ TOP NAV BAR ENDS ----------------------------------------------------------------------------------------->

<!------ FAMILY PAPER START DITO START---------------------------------------------------------------------------------------->
		<main>
			<h3>Family Profile Form</h3>


			<!--andtio si delete and create button-->
			<div class="head-btn">
				<a href="deleteFam.php?id=<?php echo $_GET['id']; ?>">
				<div class="del" style="

				background-color: var(--vermain-color);
    width: fit-content;
    margin-left: 5px;
    border-radius: 10px;
    color: #fff;
    font-size: 13px;
    padding: .5rem 1rem;
    border: 1px solid var(--vermain-color);

				">  Delete..  <span class="bx bxs-trash"></span>
				
			</div>
			</a>
			</div>

			<!--eto naman yung code nung form-->


				<!--eto yung title part-->
				<div class="head">
					<div class="details personal">
						<span class="title">Personal</span>

						<!--mga input fields nung first portion ng form-->
						<div class="fields">

							<div class="input-fields">
								<label for="">House No.</label>
								<input type="text" name="house_no" placeholder="Enter House Number" value="<?php echo $profile_row['house_no']; ?>" required>
							</div>

							<div class="input-fields">
								<label for="">Street</label>
								<input type="text" name="street" placeholder="Enter Street" value="<?php echo $profile_row['street']; ?>" required>
							</div>

							<div class="input-fields">
								<label for="">Apartment Owner</label>
								<input type="text" name="apartment_owner" placeholder="Enter Apartment Owner" value="<?php echo $profile_row['apartment_owner']; ?>" required>
							</div>

							<div class="input-fields">
								<label for="">Sitio</label>
								<input type="text" name="sitio" placeholder="Enter Sitio" value="<?php echo $profile_row['sitio']; ?>" required>
							</div>

							<div class="input-fields">
								<label for="">Relihiyon</label>
								<input type="text" name="relihiyon" placeholder="Enter Relihiyon" value="<?php echo $profile_row['relihiyon']; ?>" required>
							</div>

							<div class="input-fields">
								<label for="">Contact No.</label>
								<input type="number" name="contact_no" placeholder="Enter Contact No." value="<?php echo $profile_row['contact_no']; ?>" required>
							</div>
						</div>
					</div>
				</div>

		</main>
		<!--end nung first portion ng form-->

		<!--code nung table-->
	  <div class="table">
		<section class="table-header">
			<h4>Talaan ng mga nakatira sa Kabahayan(Kasama ang mga kawaksi sa bahay, ofw, nakakulong)</h4>
		</section>

		<!--header nung table form-->
		<section class="table-body">
			<table>
				<thead>
					<tr>
							<!-- <th>ID</th>
							<th>Pangalan</th>
							<th>Kapanganakan</th>
							<th>Edad</th>
							<th>Kasarian</th>
							<th>Katayuan Sibil</th>
							<th>Relasyon</th>
							<th>Hanapbuhay</th>
							<th>Taon ng paninirahan</th>
							<th>PWD/Senior/Solo-Parent/School Dropout/Unemployed</th>
							<th>Action</th> -->
					</tr>
				</thead>

				<!--eto naman yung mga input fields table yung "inpu type"-->
				<tbody id="talaan-kabahayan">
				    <?php

        $kabahayan_rows = $model->fetchKabahayan($_GET['id']);

        if (!empty($kabahayan_rows)) {
            $i = 1;

            foreach ($kabahayan_rows as $kabahayan_row) {

                ?>



<tr>
						<!-- <td>1</td> -->
						<td> 
	

							<div class="form-field">
								<h3 style="font-weight: bold;">First Name</h3>
								<div class="input"> <input type="text" name="first_name[]" placeholder="First Name"  value="<?php echo $kabahayan_row['first_name']; ?>" required> </div> 
							</div>

							<div class="form-field">
								<h3 style="font-weight: bold;">Kapanganakan</h3>
								<div class="input"> <input type="date"  name="kabahayan_dob[]" placeholder="Date of Birth" required value="<?php echo $kabahayan_row['kapanganakan']; ?>"> </div> 
							</div>
							<div class="form-field">
							</div>

						</td>
						<td> 
							<div class="form-field">
								<h3 style="font-weight: bold;">Middle Name</h3>
								<div class="input"> <input type="text" name="middle_name[]" placeholder="middle Name" value="<?php echo $kabahayan_row['middle_name']; ?>" required> </div> 
							</div>
							<div class="form-field">
								<h3 style="font-weight: bold;">Edad</h3>
								<div class="input"> <input type="number"  name="kabahayan_age[]" placeholder="Age" required value="<?php echo $kabahayan_row['edad']; ?>"> </div>
							</div>

							<div class="form-field">
								<h3 style="font-weight: bold;">Kasarian</h3>
								<div class="input"> <select  class="select-input" name="kabahayan_gender[]" required><option value="" disabled="" selected="">Select gender</option><option value="M" <?php if ($kabahayan_row['kasarian'] == 'M') {echo 'selected';}?>>Male</option><option value="F" <?php if ($kabahayan_row['kasarian'] == 'F') {echo 'selected';}?>>Female</option></select></div></div> 
							</div>
						</td>
						<td> 
							<div class="form-field">
								<h3 style="font-weight: bold;">Last Name</h3>
								<div class="input"> <input type="text" name="last_name[]" placeholder="last Name"  required value="<?php echo $kabahayan_row['last_name']; ?>"> </div> 
							</div>
							<div class="form-field">
								<h3 style="font-weight: bold;">Katayuan Sibil</h3>
								<div class="input"> <input type="text"  name="kabahayan_civil[]" placeholder="Civil Status" required value="<?php echo $kabahayan_row['katayuan_sibil']; ?>"> </div> 
							</div>

							<div class="form-field">
								<h3 style="font-weight: bold;">Relasyon</h3>
								<div class="input"> <input type="text"  name="kabahayan_relationship[]" placeholder="Relationship" required value="<?php echo $kabahayan_row['relasyon']; ?>"> </div>
							</div>


						</td>
						<td>
							<div class="form-field">
								<h3 style="font-weight: bold;">Suffix</h3>
								<div class="input"> <input type="text" name="suffix[]" placeholder="Suffix" value="<?php echo $kabahayan_row['suffix']; ?>" required> </div> 
							</div>
						<div class="form-field">
							<h3 style="font-weight: bold;">Hanapbuhay</h3>
							<div class="input"> <input type="text"  name="kabahayan_occupation[]" placeholder="Occupation" required value="<?php echo $kabahayan_row['hanapbuhay']; ?>"> </div>
						</div>
						<div class="form-field">
							<h3 style="font-weight: bold;">Taon ng Paninirahan sa Brgy</h3>
							<div class="input"> <input type="date"  name="kabahayan_year[]" placeholder="Year of Residency" required value="<?php echo $kabahayan_row['paninirahan']; ?>"> </div>
						</div>

						</td>
						<td> 
						<div class="form-field">
							<h3 style="font-weight: bold;">Senior/Pwd/Solo/Parent/Out of/School/Unemployed</h3>
							<div class="input"> 
								<select class="select-input" name="kabahayan_status[]">
									<option value="" disabled="" selected="">Select option</option>
									<option value="PWD" <?php if ($kabahayan_row['status'] == 'PWD') {echo 'selected';}?>>PWD</option>
									<option value="Senior" <?php if ($kabahayan_row['status'] == 'Senior') {echo 'selected';}?>>Senior</option>
									<option value="Solo-Parent" <?php if ($kabahayan_row['status'] == 'Solo-Parent') {echo 'selected';}?>>Solo-Parent</option>
									<option value="School Dropout" <?php if ($kabahayan_row['status'] == 'School Dropout') {echo 'selected';}?>>School Dropout</option>
									<option value="Unemployed" <?php if ($kabahayan_row['status'] == 'Unemployed') {echo 'selected';}?>>Unemployed</option>
								</select>
						 	</div>
						</div>

						</td>
	
						<td class=""><button type="button" id="talaan-kabahayan-add" class="btn">+</button></td>
					</tr>










					<tr id="krow<?php echo $i; ?>" hidden>
						<td><?php echo $i; ?></td>
						<td> <div class="input"> <input type="text" name="kabahayan_name[]" placeholder="Fullname" value="<?php echo $kabahayan_row['pangalan']; ?>" required> </div> </td>
						<td> <div class="input"> <input type="date" name="kabahayan_dob[]" placeholder="Date of Birth" value="<?php echo $kabahayan_row['kapanganakan']; ?>" required> </div> </td>
						<td> <div class="input"> <input type="number" name="kabahayan_age[]" placeholder="Age" value="<?php echo $kabahayan_row['edad']; ?>" required> </div> </td>
						<td> <div class="input"> <select name="kabahayan_gender[]" required><option value="" disabled="" selected="">Select gender</option><option value="M" <?php if ($kabahayan_row['kasarian'] == 'M') {echo 'selected';}?>>Male</option><option value="F" <?php if ($kabahayan_row['kasarian'] == 'F') {echo 'selected';}?>>Female</option></select></div> </td>
						<td> <div class="input"> <input type="text" name="kabahayan_civil[]" placeholder="Civil Status" value="<?php echo $kabahayan_row['katayuan_sibil']; ?>" required> </div> </td>
						<td> <div class="input"> <input type="text" name="kabahayan_relationship[]" placeholder="Relationship" value="<?php echo $kabahayan_row['relasyon']; ?>" required> </div> </td>
						<td> <div class="input"> <input type="text" name="kabahayan_occupation[]" placeholder="Occupation" value="<?php echo $kabahayan_row['hanapbuhay']; ?>" required> </div> </td>
						<td> <div class="input"> <input type="date" name="kabahayan_year[]" placeholder="Year of Residency" value="<?php echo $kabahayan_row['paninirahan']; ?>" required> </div> </td>
						<td> <div class="input">
						    <select name="kabahayan_status[]" required>
				                <option value="" disabled="" selected="">Select option</option>
				                <option value="PWD" <?php if ($kabahayan_row['status'] == 'PWD') {echo 'selected';}?>>PWD</option>
				                <option value="Senior" <?php if ($kabahayan_row['status'] == 'Senior') {echo 'selected';}?>>Senior</option>
				                <option value="Solo-Parent" <?php if ($kabahayan_row['status'] == 'Solo-Parent') {echo 'selected';}?>>Solo-Parent</option>
				                <option value="School Dropout" <?php if ($kabahayan_row['status'] == 'School Dropout') {echo 'selected';}?>>School Dropout</option>
				                <option value="Unemployed" <?php if ($kabahayan_row['status'] == 'Unemployed') {echo 'selected';}?>>Unemployed</option>
				            </select> </div> </td>
				        <?php

                if ($i == 1) {

                    ?>
						<td><button type="button" id="talaan-kabahayan-add" class="btn">+</button></td>
						<?php

                } else {

                    ?>
						<td><button type="button" data-id="<?php echo $i; ?>" class="kabahayan_remove btn">-</button></td>
						<?php

                }

                ?>
					</tr>
					<?php
$i++;
            }
        }

        ?>
				</tbody>

			</table>
		</section>
	  </div>
	  <!--end nung unang table-->

	  <!--eto naman yung sa 2nd na table-->
	  <div class="table2">
		<div class="th2">
			<h4>Talaan ng mga batang 0-59 buwan (Batang bagong panganak hanggang 4 na taon at 9 na buwan)</h4>
		</div>

		<!--eto yung body nung table-->
		<div class="tbl2-body">
			<table width="100%">
				<thead>
					<tr>
						<!-- <th>Id</th>
						<th>Pangalan</th>
						<th>Kapanganakan</th>
						<th>Edad</th>
						<th>Kasarian</th>
						<th>Bakuna</th>
						<th>Action</th> -->
					</tr>
				</thead>

				<!--dito namn yung input fields nung table2-->
				<tbody id="talaan-bata">
				    <?php

        $kabataan_rows = $model->fetchKabataan($_GET['id']);

        if (!empty($kabataan_rows)) {
            $i = 1;

            foreach ($kabataan_rows as $kabataan_row) {
			
                ?>
					<tr id="row<?php echo $i; ?>">
						<td><?php echo $i; ?></td>

						<td>
							<div class="input"> 
								<h3 style="font-weight: bold;">First Name</h3>
								<input type="text" placeholder="First Name" name="bata_first_name[]" value="<?php echo $kabataan_row['first_name']; ?>"> 
							</div>	
							<div class="input"> 
							<h3 style="font-weight: bold; opacity:0;">First Name</h3>

								<input type="text" placeholder="Pangalan"style="opacity:0"> 
							</div>
						</td>

						<td>
							<div class="input"> 
								<h3 style="font-weight: bold;">Middle Name</h3>
								<input type="text" placeholder="Middle Name" name="bata_middle_name[]" value="<?php echo $kabataan_row['middle_name']; ?>"> 
							</div>	

							<div class="input"> 
								<h3 style="font-weight: bold;">Kapanganakan</h3>
								<input type="date" placeholder="Kanganakan" name="bata_kapanganakan[]" value="<?php echo $kabataan_row['kapanganakan']; ?>" onchange="calculateAgeBata(this)" required > 
							</div>
						
							
						</td>
						<td>
							<div class="input"> 
								<h3 style="font-weight: bold;">Last Name</h3>	
								<input type="text" placeholder="Last Name" name="bata_last_name[]" value="<?php echo $kabataan_row['last_name']; ?>"> 
							</div>
						
							<div class="input"> 
								<h3 style="font-weight: bold;">Edad</h3>
								<input type="number" placeholder="Edad" name="bata_edad[]" value="<?php echo $kabataan_row['edad']; ?>" required > 
							</div>
						</td>
						<td>
							<div class="input"> 
								<h3 style="font-weight: bold;">Suffix</h3>	
								<input type="text" placeholder="Suffix" name="bata_suffix_name[]" value="<?php echo $kabataan_row['suffix']; ?>"> 
							</div>
						
							<div class="input"> 
								<h3 style="font-weight: bold;">Kasarian</h3>	
								<select class="select-input"  name="bata_kasarian[]" required><option value="" disabled="" selected="">Select gender</option><option value="M" <?php if ($kabataan_row['kasarian'] == 'M') {echo 'selected';}?>>Male</option><option value="F" <?php if ($kabataan_row['kasarian'] == 'F') {echo 'selected';}?>>Female</option></select> </div></td>
						<td><div class="input"> <input type="text" placeholder="Bakuna" name="bata_bakuna[]" value="<?php echo $kabataan_row['bakuna']; ?>" required> </div></td>
						<?php

                if ($i == 1) {

                    ?>
						<td><button type="button" id="talaan-bata-add">+</button></td>
						<?php

                } else {

                    ?>
						<td><button type="button" data-id="<?php echo $i; ?>" class="bata_remove">-</button></td>
						<?php

                }

                ?>
					</tr>
					<?php
$i++;
            }
        }

        ?>
				</tbody>
			</table>
		</div>
	  </div>
	  <!--end nung table 2-->

	  <!--yung code nung sa pang apat na portion nung checkbox ching chong-->
	  <div class="checker">
		<div class="Quehead">
			<h3>Iba pang mga katanungan.</h3>
		</div>

		<!--body nung pinaka questionnare-->
		<div class="que-body">

			<!--yung division A separation lang yan nung mga questions and answers-->
			<!--pati input fields yung checkbox, tetxbox-->
			<div class="A">
				<div class="span">
					<span>A. Ano ang pinanggagaligan ng tubig na inyong ginagamit?</span>
				</div>

				<div class="radiobtn">
					<div class="rad-fields">
						<label for="">NAWASA-</label>
						<div class="radio"> <input type="checkbox" name="tg1" value="1" <?php echo ($tubig[0] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Poso-</label>
						<div class="radio"> <input type="checkbox" name="tg2" value="1" <?php echo ($tubig[1] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Balon-</label>
						<div class="radio"> <input type="checkbox" name="tg3" value="1" <?php echo ($tubig[2] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Iba pa-</label>
						<div class="radio"> <input type="checkbox" name="tg4" value="1" <?php echo ($tubig[3] == '1') ? 'checked' : ''; ?>> </div>
					</div>
				</div>
			</div>

			<div class="B">
				<div class="span">
					<span>B. Uri ng palikurang ginagamit?</span>
				</div>

				<div class="radiobtn">
					<div class="rad-fields">
						<label for="">Water Sealed-</label>
						<div class="radio"> <input type="checkbox" name="p1" value="1" <?php echo ($palikuran[0] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Open Pit-</label>
						<div class="radio"> <input type="checkbox" name="p2" value="1" <?php echo ($palikuran[1] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Wala-</label>
						<div class="radio"> <input type="checkbox" name="p3" value="1" <?php echo ($palikuran[2] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Iba pa-</label>
						<div class="radio"> <input type="checkbox" name="p4" value="1" <?php echo ($palikuran[3] == '1') ? 'checked' : ''; ?>> </div>
					</div>
				</div>
			</div>

			<div class="C">
				<div class="span">
					<span>C. Ikaw ba ay may tanim na punong kahoy na namumunga?</span>
				</div>

				<div class="radiobtn">
					<div class="rad-fields">
						<div class="txt"> <input type="text" name="tanim" placeholder="Oo / Hindi" value="<?php echo $profile_row['tanim']; ?>"> </div>
					</div>
			</div>
		  </div>

			<div class="D">
				<div class="span">
					<span>D. Ikaw ba ay may Harding Gulay?</span>
				</div>

				<div class="radiobtn">
					<div class="rad-fields">
						<div class="txt"> <input type="text" name="hardin" placeholder="Oo / Hindi" value="<?php echo $profile_row['hardin']; ?>"> </div>
					</div>
				</div>
			</div>

			<div class="E">
				<div class="span">
					<span>E. Ikaw ba ay may Alagang Manok?</span>
				</div>

				<div class="radiobtn">
					<div class="rad-fields">
						<div class="txt"> <input type="text" name="manok" placeholder="Oo / Hindi" value="<?php echo $profile_row['manok']; ?>"> </div>
					</div>
				</div>
			</div>

			<div class="F">
				<div class="span">
					<span>F. Ikaw ba ay may Alagang Baboy?</span>
				</div>

				<div class="radiobtn">
					<div class="rad-fields">
						<div class="txt"> <input type="text" name="baboy" placeholder="Oo / Hindi" value="<?php echo $profile_row['baboy']; ?>"> </div>
					</div>
				</div>
			</div>

			<div class="G">
				<div class="span">
					<span>G. Ikaw ba ay gumagamit ng</span>
				</div>

				<div class="radiobtn">
					<div class="rad-fields">
						<label for="">Iodized Salt-</label>
						<div class="radio"> <input type="checkbox" name="gn1" value="1" <?php echo ($gumagamit_ng[0] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Fortified Food-</label>
						<div class="radio"> <input type="checkbox" name="gn2" value="1" <?php echo ($gumagamit_ng[1] == '1') ? 'checked' : ''; ?>> </div>
					</div>
				</div>
			</div>

			<div class="H">
				<div class="span">
					<span>H. Ang Asawa mo ba ay Kasalukuyang buntis</span>
				</div>

				<div class="radiobtn">
					<div class="rad-fields">
						<label for="">Oo-</label>
						<div class="radio"> <input type="checkbox" name="kb1" value="1" <?php echo ($buntis[0] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Hindi-</label>
						<div class="radio"> <input type="checkbox" name="kb2" value="1" <?php echo ($buntis[1] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Nagpapasuso-</label>
						<div class="radio"> <input type="checkbox" name="kb3" value="1" <?php echo ($buntis[2] == '1') ? 'checked' : ''; ?>> </div>
					</div>
				</div>
			</div>

			<div class="I">
				<div class="span">
					<span>I. Kayo ba ay nagpaplano ng pamilya</span>
				</div>

				<div class="radiobtn">
					<div class="rad-fields">
						<label for="">Oo-</label>
						<div class="radio"> <input type="checkbox" name="pp1" value="1" <?php echo ($pamilya[0] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Hindi-</label>
						<div class="radio"> <input type="checkbox" name="pp2" value="1" <?php echo ($pamilya[1] == '1') ? 'checked' : ''; ?>> </div>
					</div>
				</div>
			</div>

			<div class="J">
				<div class="span">
					<span>Kung Oo, anong uri ng family planning ang ginagamit?</span>
				</div>

				<div class="radiobtn">
					<div class="rad-fields">
						<label for="">Pills-</label>
						<div class="radio"> <input type="checkbox" name="fp1" value="1" <?php echo ($family_planning[0] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">BTL-</label>
						<div class="radio"> <input type="checkbox" name="fp2" value="1" <?php echo ($family_planning[1] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">DMPA-</label>
						<div class="radio"> <input type="checkbox" name="fp3" value="1" <?php echo ($family_planning[2] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Vasectomy-</label>
						<div class="radio"> <input type="checkbox" name="fp4" value="1" <?php echo ($family_planning[3] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">IUD-</label>
						<div class="radio"> <input type="checkbox" name="fp5" value="1" <?php echo ($family_planning[4] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Iba pa-</label>
						<div class="radio"> <input type="checkbox" name="fp6" value="1" <?php echo ($family_planning[5] == '1') ? 'checked' : ''; ?>> </div>
					</div>

					<div class="rad-fields">
						<label for="">Condom-</label>
						<div class="radio"> <input type="checkbox" name="fp7" value="1" <?php echo ($family_planning[6] == '1') ? 'checked' : ''; ?>> </div>
					</div>
				</div>
			</div>
		</div>
	  </div>
	  <!--end nung questionnaire-->

	  <!--eto naman yung last part nung family form-->
		 <div class="fam-footer">
			<div class="fam-input">

				<!--eto yung input fields nya-->
				<div class="fam-fields">
					<label for="">PANGALAN NG NAGSAGOT NG PROFILE:</label>
					<div class="fam-txt"> <input type="text" name="pangalan" placeholder="Pangalan ng nagsagot" value="<?php echo $profile_row['pangalan']; ?>" required> </div>
					<label for="">Code</label>
					<div class="fam-txt"> <input type="text" name="code" placeholder="code" value="<?php echo $profile_row['code']; ?>" required > </div>
				</div>
			</div>
			<div class="fam-input">
				<div class="fam-fields">
					<label for="">PETSA:</label>
					<div class="fam-txt"> <input type="date" name="petsa" value="<?php echo $profile_row['petsa']; ?>"> </div>
				</div>
			</div>
			<!--eto yung submit button-->
			<div class="fam-input">
				<div class="fam-fields">
					<div class="fam-btn"> <input type="submit" name="submit_profile" value="IPASA ANG PROFILE"> </div>
				</div>
			</div>
		 </div>
		 <?php

    }
}

?>
	</div>
	</form>

	<script>
	    let i = <?php echo count($kabataan_rows); ?>;

  document.getElementById('talaan-bata-add').addEventListener('click', function() {
    i++;
    const newRow = document.createElement('tr');
    newRow.id = 'row' + i;
    newRow.innerHTML = `
      <td>${i}</td>
	  <td>
        <div class="input"> 
          <h3 style="font-weight: bold;">First Name</h3>
          <input type="text" placeholder="First Name" name="bata_first_name[]"> 
        </div>
        <div class="input"> 
          <input type="text" placeholder="Pangalan"style="opacity:0"> 
        </div>
      </td>
      <td>
        <div class="input"> 
          <h3 style="font-weight: bold;">Middle Name</h3>	
          <input type="text" placeholder="Middle Name" name="bata_middle_name[]"> 
        </div>

        <div class="input"> 
          <h3 style="font-weight: bold;">Kapanganakan</h3>	
          <input type="date" placeholder="Kanganakan" name="bata_kapanganakan[]" onchange="calculateAgeBata(this)"> 
        </div>
      </td>
      <td>
      <div class="input"> 
      <h3 style="font-weight: bold;">Last Name</h3>	
        <input type="text" placeholder="Last Name" name="bata_last_name[]"> </div>
      </div>
      <div class="input"> 
        <h3 style="font-weight: bold;">Edad</h3>	

        <input type="number" placeholder="Edad" name="bata_edad[]"> 
      </td>
      <td>
      <div class="input"> 
        <h3 style="font-weight: bold;">Suffix</h3>	
        <input type="text" placeholder="Suffix" name="bata_suffix_name[]"> 
      </div>
        <div class="input"> 
          <h3 style="font-weight: bold;">Kasarian</h3>	
          <select class="select-input" name="bata_kasarian[]">
            <option value="" disabled="" selected="">Select gender</option>
            <option value="M">Male</option><option value="F">Female</option>
          </select> 
        </div>
      </td>
      <td><div class="input"> <input type="text" placeholder="Bakuna" name="bata_bakuna[]" required> </div></td>
      <td><button type="button" data-id="${i}" class="bata_remove btn">-</button></td>
    `;
    document.getElementById('talaan-bata').appendChild(newRow);
  });

  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('bata_remove')) {
      const buttonId = event.target.getAttribute('data-id');
      const rowToRemove = document.getElementById('row' + buttonId);
      if (rowToRemove) {
        rowToRemove.remove();
        i--;
      }
    }
  });

  let kabahayan_i = <?php echo count($kabahayan_rows); ?>;

  document.getElementById('talaan-kabahayan-add').addEventListener('click', function() {
    kabahayan_i++;
    const newRow = document.createElement('tr');
    newRow.id = 'krow' + kabahayan_i;
    newRow.innerHTML = `
	<td> 
        <div class="form-field">
          <h3 style="font-weight: bold;">First Name</h3>
          <div class="input"> <input type="text" name="first_name[]" placeholder="First Name"  required> </div> 
        </div>
        <div class="form-field">
          <h3 style="font-weight: bold;">Kapanganakan</h3>
          <div class="input"> <input type="date" name="kabahayan_dob[]" placeholder="Date of Birth" required onchange="calculateAge(this)"> </div> 
        </div>
        <div class="form-field">
							
        </div>
      </td>
      <td> 
        <div class="form-field">
          <h3 style="font-weight: bold;">Middle Name</h3>
          <div class="input"> <input type="text" name="middle_name[]" placeholder="Middle Name"  required> </div> 
        </div>
        <div class="form-field">
        <h3 style="font-weight: bold;">Edad</h3>
        <div class="input"> <input type="number" name="kabahayan_age[]" placeholder="Age" required> </div>
        </div>

        <div class="form-field">
          <h3 style="font-weight: bold;">Kasarian</h3>
          <div class="input"> <select class="select-input" name="kabahayan_gender[]" required><option value="" disabled="" selected="">Select gender</option><option value="M">Male</option><option value="F">Female</option></select></div> 
        </div>
      </td>
      <td> 
        <div class="form-field">
          <h3 style="font-weight: bold;">Last Name</h3>
          <div class="input"> <input type="text" name="last_name[]" placeholder="Last Name"  required> </div> 
        </div>
        <div class="form-field">
          <h3 style="font-weight: bold;">Katayuan Sibil</h3>
          <div class="input"> <input type="text" name="kabahayan_civil[]" placeholder="Civil Status" required> </div> 
        </div>

        <div class="form-field">
          <h3 style="font-weight: bold;">Relasyon</h3>
          <div class="input"> <input type="text" name="kabahayan_relationship[]" placeholder="Relationship" required> </div>
        </div>


      </td>
      <td>
      <div class="form-field">
        <h3 style="font-weight: bold;">Suffix</h3>
        <div class="input"> <input type="text" name="suffix[]" placeholder="suffix"  required> </div> 
      </div>
      <div class="form-field">
        <h3 style="font-weight: bold;">Hanapbuhay</h3>
        <div class="input"> <input type="text" name="kabahayan_occupation[]" placeholder="Occupation" required> </div>
      </div>
      <div class="form-field">
        <h3 style="font-weight: bold;">Taon ng Paninirahan sa Brgy</h3>
        <div class="input"> <input type="date" name="kabahayan_year[]" placeholder="Year of Residency" required> </div>
      </div>

      </td>
      <td> 
      <div class="form-field">
        <h3 style="font-weight: bold;">Senior/Pwd/Solo/Parent/Out of/School/Unemployed</h3>
        <div class="input"> 
          <select class="select-input" name="kabahayan_status[]">
            <option value="" disabled="" selected="">Select option</option>
            <option value="">NONE</option>
            <option value="PWD">PWD</option>
            <option value="Senior">Senior</option>
            <option value="Solo-Parent">Solo-Parent</option>
            <option value="School Dropout">School Dropout</option>
            <option value="Unemployed">Unemployed</option>
          </select>
         </div>
      </div>

      </td>

      <td><button type="button" data-id="${kabahayan_i}" class="kabahayan_remove btn">-</button></td>


    `;
    document.getElementById('talaan-kabahayan').appendChild(newRow);
  });

  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('kabahayan_remove')) {
      const buttonId = event.target.getAttribute('data-id');
      const rowToRemove = document.getElementById('krow' + buttonId);
      if (rowToRemove) {
        rowToRemove.remove();
        kabahayan_i--;
      }
    }
  });
	</script>

<script>

function calculateAge(input) {
	// Get the date of birth value from the input field
	var dobValue = input.value;

	// Check if a date is selected
	if (dobValue) {
		// Parse the date string to a Date object
		var dobDate = new Date(dobValue);

		// Get the current date
		var currentDate = new Date();

		// Calculate the age
		var age = currentDate.getFullYear() - dobDate.getFullYear();

		// Check if the birthday has occurred this year
		if (currentDate.getMonth() < dobDate.getMonth() || (currentDate.getMonth() === dobDate.getMonth() && currentDate.getDate() < dobDate.getDate())) {
		age--;
		}

		// Set the age to 0 if it is negative
		age = Math.max(age, 0);

		// Find the corresponding age input field in the same row
		var row = input.closest('tr');
		var ageInput = row.querySelector('input[name="kabahayan_age[]"]');

		// Update the age input field with the calculated age
		ageInput.value = age;
	}
}

function calculateAgeBata(input) {
	// Get the date of birth value from the input field
	var dobValue = input.value;

	// Check if a date is selected
	if (dobValue) {
		// Parse the date string to a Date object
		var dobDate = new Date(dobValue);

		// Get the current date
		var currentDate = new Date();

		// Calculate the age
		var age = currentDate.getFullYear() - dobDate.getFullYear();

		// Check if the birthday has occurred this year
		if (currentDate.getMonth() < dobDate.getMonth() || (currentDate.getMonth() === dobDate.getMonth() && currentDate.getDate() < dobDate.getDate())) {
		age--;
		}

		// Set the age to 0 if it is negative
		age = Math.max(age, 0);

		// Find the corresponding age input field in the same row
		var row = input.closest('tr');
		var ageInput = row.querySelector('input[name="bata_edad[]"]');

		// Update the age input field with the calculated age
		ageInput.value = age;
	}
}

function checkDuplicate() {
	// Get values from the input fields
	var name = document.querySelector('input[name="pangalan"]').value;
	var houseNo = document.querySelector('input[name="house_no"]').value;

	// Create a new XMLHttpRequest object
	var xhr = new XMLHttpRequest();

	// Configure it: GET-request for the specified URL with parameters
	xhr.open('GET', 'api.php?mode=checkduplicate&name=' + encodeURIComponent(name) + '&house_no=' + encodeURIComponent(houseNo), true);

	// Define the onload and onerror callbacks
	xhr.onload = function () {
		if (xhr.status == 200) {
		// Parse the JSON response
		var response = JSON.parse(xhr.responseText);

		// Handle the successful response here
		console.log(response);

		// Update the <p> element with the error message
		var errorMessageElement = document.getElementById('err_message');
		errorMessageElement.textContent = response.errMessage;
		// errorMessageElement.style.color = response.is_valid ? 'green' : 'red'; // Adjust color based on validity
		} else {
		// Handle the error here
		console.error('Request failed with status ' + xhr.status);
		}
	};

	xhr.onerror = function () {
		// Handle the network error here
		console.error('Network error occurred');
	};

	// Send the request
	xhr.send();
}
</script>



<!------ FAMILY PAPER ENDS ---------------------------------------------------------------------------------------->
</body>
</html>