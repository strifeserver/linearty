<?php
	
	session_start();
	include('Global/Model.php');
	$model = new Model();

	if (isset($_POST['submit_profile'])) {
		$house_no = $_POST['house_no'];
		$street = $_POST['street'];
		$apartment_owner = $_POST['apartment_owner'];
		$sitio = $_POST['sitio'];
		$relihiyon = $_POST['relihiyon'];
		$contact_no = $_POST['contact_no'];


		$is_valid = true;
		$checkDuplicates = $model->checkDuplicate($_POST['pangalan'], $house_no); # Check if already exists
	
		if($checkDuplicates == true){
			// echo 'HAS DUPLICATES';
			$is_valid = true;
			$_POST = [];
			$errMessage = 'Data Already Exist, please change your House No.';


	
	
		}else if($checkDuplicates == false){
			// echo 'NO DUPLICATES';

			$is_valid = false;
		}
		

		for ($i = 1; $i <= 4; $i++) { 
			$tgnum = "tg".$i."";
			$$tgnum = (isset($_POST['tg'.$i.''])) ? $_POST['tg'.$i.''] : "0";
		}

		for ($i = 1; $i <= 4; $i++) { 
			$pnum = "p".$i."";
			$$pnum = (isset($_POST['p'.$i.''])) ? $_POST['p'.$i.''] : "0";
		}

		$tanim = @$_POST['tanim'];
		$hardin = @$_POST['hardin'];
		$manok = @$_POST['manok'];
		$baboy = @$_POST['baboy'];

		for ($i = 1; $i <= 2; $i++) { 
			$gnnum = "gn".$i."";
			$$gnnum = (isset($_POST['gn'.$i.''])) ? $_POST['gn'.$i.''] : "0";
		}

		for ($i = 1; $i <= 3; $i++) { 
			$kbnum = "kb".$i."";
			$$kbnum = (isset($_POST['kb'.$i.''])) ? $_POST['kb'.$i.''] : "0";
		}

		for ($i = 1; $i <= 2; $i++) { 
			$ppnum = "pp".$i."";
			$$ppnum = (isset($_POST['pp'.$i.''])) ? $_POST['pp'.$i.''] : "0";
		}

		for ($i = 1; $i <= 7; $i++) { 
			$fpnum = "fp".$i."";
			$$fpnum = (isset($_POST['fp'.$i.''])) ? $_POST['fp'.$i.''] : "0";
		}

		$pangalan = @$_POST['pangalan'];
		$petsa = @$_POST['petsa'];

		$tubig = $tg1.", ".$tg2.", ".$tg3.", ".$tg4;
		$palikuran = $p1.", ".$p2.", ".$p3.", ".$p4;

		$gumagamit_ng = $gn1.", ".$gn2;
		$buntis = $kb1.", ".$kb2.", ".$kb3;
		$pamilya = $pp1.", ".$pp2;
		$family_planning = $fp1.", ".$fp2.", ".$fp3.", ".$fp4.", ".$fp5.", ".$fp6.", ".$fp7;
		
		if (!isset($_SESSION['admin_sess'])) {
			if(!empty($_FILES["gov_id"]["tmp_name"])){

				$path = 'Requirement/';
				$unique = time().uniqid(rand());
				$destination = $path . $unique . '.jpg';
				$base = basename($_FILES["gov_id"]["name"]);
				$image = $_FILES["gov_id"]["tmp_name"];
				move_uploaded_file($image, $destination);
			}
		}

		else {
		    $unique = 'EMPTY';
		}

		$status = 'Pending';

		$last_id = $model->insertFamilyProfile($house_no, $street, $apartment_owner, $sitio, $relihiyon, $contact_no, $tubig, $palikuran, $tanim, $hardin, $manok, $baboy, $gumagamit_ng, $buntis, $pamilya, $family_planning, $pangalan, $petsa, @$unique, $status);
		if(isset($_POST['kabahayan_name'])){

			foreach ($_POST['kabahayan_name'] as $key => $kbhyn) {
				$kabahayan_status = (isset($_POST['kabahayan_status'][$key])) ? $_POST['kabahayan_status'][$key] : "N/A";
				
				$model->insertKabahayanRow($last_id, $_POST['kabahayan_name'][$key], $_POST['kabahayan_dob'][$key], $_POST['kabahayan_age'][$key], $_POST['kabahayan_gender'][$key], $_POST['kabahayan_civil'][$key], $_POST['kabahayan_relationship'][$key], $_POST['kabahayan_occupation'][$key], $_POST['kabahayan_year'][$key], $kabahayan_status);
			}
		}
	    
	    if (isset($_POST['bata_pangalan'])) {
	        foreach ($_POST['bata_pangalan'] as $ky => $bt) {
	            if (trim($ky) != '') {
	                @$model->insertKabataanRow($last_id, $_POST['bata_pangalan'][$ky], $_POST['bata_kapanganakan'][$ky], $_POST['bata_edad'][$ky], $_POST['bata_kasarian'][$ky], $_POST['bata_bakuna'][$ky]);   
	            }
    	    }
	    }

		$_POST = [];
	    
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
	<title> Family Profile Form </title>
	<link rel="stylesheet" href="Css/Family.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

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
<?php try { ?>
<body>
	<form method="POST" enctype="multipart/form-data">
<!------ ANIMATED SIDE NAV BAR START ------------------------------------------------------------------------------>
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
                    
                    <?php
                    
                        if (@$admin_type == 'super') {
                            
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
<!------ ANIMATED SIDE NAV BAR ENDS  ------------------------------------------------------------------------------>

<!------ TOP NAV BAR START ---------------------------------------------------------------------------------------->
	<div class="main-content">
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
<!------ ADMIN PROFILE  -------------------------------------------------------------->
		</header>
<!------ TOP NAV BAR ENDS ----------------------------------------------------------------------------------------->

<!------ FAMILY PAPER START DITO START---------------------------------------------------------------------------------------->  
		<main>
			<h3>Family Profile Form</h3>

			<!--andtio si delete and create button-->
			<div class="head-btn">
				<!--<a href=""><div class="del"> <button type="button"> Delete..  <span class="bx bxs-trash"></span></button> </div></a>-->
				<a href="Verify-edit.php"><div class="edit"> <button type="button"> Request Delete/Edit..  <span class="bx bxs-pen"></span></button> </div></a>
			</div>

			<!--eto naman yung code nung form-->
			

				<!--eto yung title part-->
				<div class="head">
					<div class="details personal">
						<p style="color: red;  font-weight: bold;">
					<?php
					echo $errMessage ?? '';
					?>
					</p>
						<span class="title">Personal</span>
						
						<!--mga input fields nung first portion ng form-->
						<div class="fields">

							<div class="input-fields">
								<label for="">House No.</label>
								<input type="text" name="house_no" placeholder="Enter House Number" required>
							</div>

							<div class="input-fields">
								<label for="">Street</label>
								<input type="text" name="street" placeholder="Enter Street" required>
							</div>

							<div class="input-fields">
								<label for="">Apartment Owner</label>
								<input type="text" name="apartment_owner" placeholder="Enter Apartment Owner" required>
							</div>

							<div class="input-fields">
								<label for="">Sitio</label>
								<input type="text" name="sitio" placeholder="Enter Sitio" required>
							</div>

							<div class="input-fields">
								<label for="">Relihiyon</label>
								<input type="text" name="relihiyon" placeholder="Enter Relihiyon" required>
							</div>

							<div class="input-fields">
								<label for="">Contact No.</label>
								<input type="number" name="contact_no" placeholder="Enter Contact No." required>
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
					<tr>
						<!-- <td>1</td> -->
						<td> 
							<div class="form-field">
								<h3 style="font-weight: bold;">Pangalan</h3>
								<div class="input"> <input type="text" name="kabahayan_name[]" placeholder="Fullname"  required> </div> 
							</div>
							<div class="form-field">
								<h3 style="font-weight: bold;">Kapanganakan</h3>
								<div class="input"> <input type="date" name="kabahayan_dob[]" placeholder="Date of Birth" required> </div> 
							</div>

						</td>
						<td> 

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
	
						<td class=""><button type="button" id="talaan-kabahayan-add" class="btn">+</button></td>
					</tr>
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
						<th>Id</th>
						<th>Pangalan</th>
						<th>Kapanganakan</th>
						<th>Edad</th>
						<th>Kasarian</th>
						<th>Bakuna</th>
						<th>Action</th>
					</tr>
				</thead>

				<!--dito namn yung input fields nung table2-->
				<tbody id="talaan-bata">
					<tr>
						<td>1</td>
						<td><div class="input"> <input type="text" placeholder="Pangalan" name="bata_pangalan[]"> </div></td>
						<td><div class="input"> <input type="date" placeholder="Kanganakan" name="bata_kapanganakan[]"> </div></td>
						<td><div class="input"> <input type="number" placeholder="Edad" name="bata_edad[]"> </div></td>
						<td><div class="input"> <select name="bata_kasarian[]"><option value="" disabled="" selected="">Select gender</option><option value="M">Male</option><option value="F">Female</option></select> </div></td>
						<td><div class="input"> <input type="text" placeholder="Bakuna" name="bata_bakuna[]"> </div></td>
						<td><button type="button" id="talaan-bata-add" class="btn">+</button></td>
					</tr>
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
						<div class="radio"> <input type="checkbox" name="tg1" value="1"> </div>
					</div>
					
					<div class="rad-fields">
						<label for="">Poso-</label>
						<div class="radio"> <input type="checkbox" name="tg2" value="1"> </div>
					</div>
	
					<div class="rad-fields">
						<label for="">Balon-</label>
						<div class="radio"> <input type="checkbox" name="tg3" value="1"> </div>
					</div>
	
					<div class="rad-fields">
						<label for="">Iba pa-</label>
						<div class="radio"> <input type="checkbox" name="tg4" value="1"> </div>
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
						<div class="radio"> <input type="checkbox" name="p1" value="1"> </div>
					</div>
					
					<div class="rad-fields">
						<label for="">Open Pit-</label>
						<div class="radio"> <input type="checkbox" name="p2" value="1"> </div>
					</div>
	
					<div class="rad-fields">
						<label for="">Wala-</label>
						<div class="radio"> <input type="checkbox" name="p3" value="1"> </div>
					</div>
	
					<div class="rad-fields">
						<label for="">Iba pa-</label>
						<div class="radio"> <input type="checkbox" name="p4" value="1"> </div>
					</div>
				</div>
			</div>
	
			<div class="C">
				<div class="span">
					<span>C. Ikaw ba ay may tanim na punong kahoy na namumunga?</span>
				</div>
				
				<div class="radiobtn">
					<div class="rad-fields">
						<div class="txt"> <input type="text" name="tanim" placeholder="MERON / WALA"> </div>
					</div>
			</div>
		  </div>
	
			<div class="D">
				<div class="span">
					<span>D. Ikaw ba ay may Harding Gulay?</span>
				</div>
				
				<div class="radiobtn">
					<div class="rad-fields">
						<div class="txt"> <input type="text" name="hardin" placeholder="MERON/ WALA"> </div>
					</div>
				</div>
			</div>
	
			<div class="E">
				<div class="span">
					<span>E. Ikaw ba ay may Alagang Manok?</span>
				</div>
				
				<div class="radiobtn">
					<div class="rad-fields">
						<div class="txt"> <input type="text" name="manok" placeholder="MERON / WALA"> </div>
					</div>
				</div>
			</div>
	
			<div class="F">
				<div class="span">
					<span>F. Ikaw ba ay may Alagang Baboy?</span>
				</div>
				
				<div class="radiobtn">
					<div class="rad-fields">
						<div class="txt"> <input type="text" name="baboy" placeholder="MERON / WALA"> </div>
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
						<div class="radio"> <input type="checkbox" name="gn1" value="1"> </div>
					</div>
					
					<div class="rad-fields">
						<label for="">Fortified Food-</label>
						<div class="radio"> <input type="checkbox" name="gn2" value="1"> </div>
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
						<div class="radio"> <input type="checkbox" name="kb1" value="1"> </div>
					</div>
					
					<div class="rad-fields">
						<label for="">Hindi-</label>
						<div class="radio"> <input type="checkbox" name="kb2" value="1"> </div>
					</div>
	
					<div class="rad-fields">
						<label for="">Nagpapasuso-</label>
						<div class="radio"> <input type="checkbox" name="kb3" value="1"> </div>
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
						<div class="radio"> <input type="checkbox" name="pp1" value="1"> </div>
					</div>
					
					<div class="rad-fields">
						<label for="">Hindi-</label>
						<div class="radio"> <input type="checkbox" name="pp2" value="1"> </div>
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
						<div class="radio"> <input type="checkbox" name="fp1" value="1"> </div>
					</div>
					
					<div class="rad-fields">
						<label for="">BTL-</label>
						<div class="radio"> <input type="checkbox" name="fp2" value="1"> </div>
					</div>
	
					<div class="rad-fields">
						<label for="">DMPA-</label>
						<div class="radio"> <input type="checkbox" name="fp3" value="1"> </div>
					</div>
	
					<div class="rad-fields">
						<label for="">Vasectomy-</label>
						<div class="radio"> <input type="checkbox" name="fp4" value="1"> </div>
					</div>
	
					<div class="rad-fields">
						<label for="">IUD-</label>
						<div class="radio"> <input type="checkbox" name="fp5" value="1"> </div>
					</div>
	
					<div class="rad-fields">
						<label for="">Iba pa-</label>
						<div class="radio"> <input type="checkbox" name="fp6" value="1"> </div>
					</div>
	
					<div class="rad-fields">
						<label for="">Condom-</label>
						<div class="radio"> <input type="checkbox" name="fp7" value="1"> </div>
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
					<div class="fam-txt"> <input type="text" name="pangalan" placeholder="Pangalan ng nagsagot" required> </div>
				</div>
			</div>

			<div class="fam-input">
				<div class="fam-fields">
					<label for="">PETSA:</label>
					<div class="fam-txt"> <input type="date" name="petsa" required> </div>
				</div>
			</div>
			<?php
			
			    if (!isset($_SESSION['admin_sess'])) {
			
			?>
			<div class="fam-input">
				<div class="fam-fields">
					<label for="">GOVERNMENT ID:</label>
					<!-- <div class="fam-txt">
						 <input type="file" name="gov_id" style="padding-top: 8px;" required> 
						</div> -->

						<div class="file-input-container">
							<label for="gov_id" class="custom-file-input">
								Choose Upload File
							</label>
							<input id="gov_id" type="file" name="gov_id" style="padding-top: 8px;" required>
						</div>


				</div>
			</div>
			<?php
			
			    }
			
			?>

			<!--eto yung submit button-->
			<div class="fam-input">
				<div class="fam-fields">
					<div class="fam-btn"> <input type="submit" name="submit_profile" value="IPASA ANG PROFILE"> </div>
				</div>
			</div>
		 </div>
	</div>
	</form>
	
	<script src="Javascript/Family.js"></script>
<!------ FAMILY PAPER ENDS ---------------------------------------------------------------------------------------->  
</body>

<?php } catch (\Throwable $th) {
	//throw $th;
}

?>
</html>