<?php

	date_default_timezone_set('Asia/Manila');
	Class Model {
		private $server = "localhost";
		private $username = "root";
		private $password = "";
		private $dbname = "linearty";
		private $conn;

		// private $server = "localhost";
		// private $username = "u134789687_webnever";
		// private $password = "1#Dz=q![?AiJ";
		// private $dbname = "u134789687_webnever";
		// private $conn;


		public function __construct() {
			try {
				$this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);	
			} catch (Exception $e) {
				echo "Connection failed" . $e->getMessage();
			}
		}

		public function signIn($uname, $pword) {
			$query = "SELECT id, password FROM admin WHERE username = ? LIMIT 1";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $uname);
				$stmt->execute();
				$stmt->bind_result($id, $hashed_pass);
				$stmt->store_result();
				if($stmt->num_rows > 0) {
					if($stmt->fetch()) {
						if (password_verify($pword, $hashed_pass)) {
							$_SESSION['admin_sess'] = $id;
							echo "<script>window.open('Home.php','_self');</script>";
							exit();
						}

						else {
							echo "<script>alert('Wrong Password!');</script>";
						}
					}
				}
				else {
					echo "<script>alert('Email not found in database!');</script>";
				}
				$stmt->close();
			}
			$this->conn->close();
		}

		public function addAdmin($uname, $email, $pword, $type) {
			$query = "INSERT INTO admin (username, email, password, type) VALUES (?, ?, ?, ?)";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('ssss', $uname, $email, $pword, $type);
				$stmt->execute();
				$stmt->close();
			}
		}

		public function insertFamilyProfile($house_no, $street, $apartment_owner, $sitio, $relihiyon, $contact_no, $tubig, $palikuran, $tanim, $hardin, $manok, $baboy, $gumagamit_ng, $buntis, $pamilya, $family_planning, $pangalan, $petsa, $requirement, $status) {
			$query = "INSERT INTO family_profile (house_no, street, apartment_owner, sitio, relihiyon, contact_no, tubig, palikuran, tanim, hardin, manok, baboy, gumagamit_ng, buntis, pamilya, family_planning, pangalan, petsa, requirement, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('ssssssssssssssssssss', $house_no, $street, $apartment_owner, $sitio, $relihiyon, $contact_no, $tubig, $palikuran, $tanim, $hardin, $manok, $baboy, $gumagamit_ng, $buntis, $pamilya, $family_planning, $pangalan, $petsa, $requirement, $status);
				$stmt->execute();
				$last_id = $stmt->insert_id;
				$stmt->close(); // Move this line here
				return $last_id;
			} else {
				return "Error: " . $this->conn->error; // Return an error message
			}
		}
		
		
		public function insertKabahayanRow($profile_id, $pangalan, $kapanganakan, $edad, $kasarian, $katayuan_sibil, $relasyon, $hanapbuhay, $paninirahan, $status) {
			$query = "INSERT INTO family_talaan_kabahayan (profile_id, pangalan, kapanganakan, edad, kasarian, katayuan_sibil, relasyon, hanapbuhay, paninirahan, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('ississssss', $profile_id, $pangalan, $kapanganakan, $edad, $kasarian, $katayuan_sibil, $relasyon, $hanapbuhay, $paninirahan, $status);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function insertKabataanRow($profile_id, $pangalan, $kapanganakan, $edad, $kasarian, $bakuna) {
			$query = "INSERT INTO family_talaan_kabataan (profile_id, pangalan, kapanganakan, edad, kasarian, bakuna) VALUES (?, ?, ?, ?, ?, ?)";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('ississ', $profile_id, $pangalan, $kapanganakan, $edad, $kasarian, $bakuna);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		// public function addRequest($house_no, $pangalan, $contact_no, $document_type, $requirement, $date_sent, $f1, $f2, $f3, $f4, $status) {
		// 	$query = "INSERT INTO document_request (house_no, pangalan, contact_no, document_type, requirement, date_sent, f1, f2, f3, f4, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		// 	if($stmt = $this->conn->prepare($query)) {
		// 		$stmt->bind_param('sssssssssss', $house_no, $pangalan, $contact_no, $document_type, $requirement, $date_sent, $f1, $f2, $f3, $f4, $status);
		// 		$stmt->execute();
		// 		$stmt->close();
		// 	}
		// }
		public function addRequest($house_no, $pangalan, $contact_no, $document_type, $requirement, $date_sent, $f1, $f2, $f3, $f4, $status) {
			// Get the current date and time
			$created_at = date('Y-m-d H:i:s');
		
			$query = "INSERT INTO document_request (house_no, pangalan, contact_no, document_type, requirement, date_sent, f1, f2, f3, f4, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('ssssssssssss', $house_no, $pangalan, $contact_no, $document_type, $requirement, $date_sent, $f1, $f2, $f3, $f4, $status, $created_at);
				$stmt->execute();
				$stmt->close();
			}
		}
		



		
		public function fetchRequests() {
			$data = null;

			$query = "SELECT * FROM document_request ORDER BY `document_request`.`created_at` DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function changeRequestStatus($status, $id) {
			$query = "UPDATE document_request SET status = ? WHERE id = ?";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('si', $status, $id);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function changeRequestApproved($id) {
			$query = "UPDATE document_request SET date_approved = ? WHERE id = ?";

			if($stmt = $this->conn->prepare($query)) {
			    $date = date('Y-m-d');
			    
				$stmt->bind_param('si', $date, $id);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function fetchRecentRequests() {
			$data = null;

			$query = "SELECT * FROM document_request ORDER BY id DESC LIMIT 6";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function fetchAdminDetails($id) {
			$data = null;

			$query = "SELECT * FROM admin WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
			    $stmt->bind_param('i', $id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function fetchProfiles() {
			$data = null;

			$query = "SELECT * FROM family_profile";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		public function fetchProfilesActive() {
			$data = null;

			$query = "SELECT * FROM family_profile WHERE status = 'Approved'";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function fetchStatistics() {
			$data = null;

            $query = "SELECT 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved')) + 
			(SELECT COUNT(*) FROM family_talaan_kabataan WHERE profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved')) AS total_population, 
			(SELECT COUNT(*) FROM family_profile WHERE status = 'Approved') AS households, 
			(SELECT COUNT(*) FROM (
				SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabahayan WHERE kasarian = 'M' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved') 
				UNION ALL 
				SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabataan WHERE kasarian = 'M' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved')
			) combined_tables) AS men, 
			(SELECT COUNT(*) FROM (
				SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabahayan WHERE kasarian = 'F' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved') 
				UNION ALL 
				SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabataan WHERE kasarian = 'F' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved')
			) combined_tables) AS females, 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'Senior' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved')) AS senior, 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'PWD' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved')) AS pwd, 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'Solo-Parent' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved')) AS solo_parents, 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'School Dropout' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved')) AS out_of_school, 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'Unemployed' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved')) AS unemployed,
			(SELECT COUNT(*) FROM family_talaan_kabataan WHERE profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved')) AS infants,
			(SELECT COUNT(*) FROM family_profile WHERE status = 'Approved') AS active_residents,
			(SELECT COUNT(*) FROM family_profile WHERE status = 'Inactive') AS inactive_residents;";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
	// 	public function fetchStatisticsByYear($year) {
	// 		$data = null;
			
	// 		$next_year = intval($year) + 1;

    //         $query = "SELECT 
    // (SELECT COUNT(*) FROM family_talaan_kabahayan WHERE profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) + 
    // (SELECT COUNT(*) FROM family_talaan_kabataan WHERE profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS total_population, 
    // (SELECT COUNT(*) FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01') AS households, 
    // (SELECT COUNT(*) FROM (
    //     SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabahayan WHERE kasarian = 'M' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01') 
    //     UNION ALL 
    //     SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabataan WHERE kasarian = 'M' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')
    // ) combined_tables) AS men, 
    // (SELECT COUNT(*) FROM (
    //     SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabahayan WHERE kasarian = 'F' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01') 
    //     UNION ALL 
    //     SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabataan WHERE kasarian = 'F' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')
    // ) combined_tables) AS females, 
    // (SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'Senior' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS senior, 
    // (SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'PWD' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS pwd, 
    // (SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'Solo-Parent' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS solo_parents, 
    // (SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'School Dropout' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS out_of_school, 
    // (SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'Unemployed' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS unemployed,
    // (SELECT COUNT(*) FROM family_talaan_kabataan WHERE profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS infants,
    // (SELECT COUNT(*) FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01') AS active_residents;";

	// 		if ($stmt = $this->conn->prepare($query)) {
	// 		    $stmt->bind_param('s', $year);
	// 			$stmt->execute();
	// 			$result = $stmt->get_result();
	// 			$num_of_rows = $stmt->num_rows;
	// 			while ($row = $result->fetch_assoc()) {
	// 				$data[] = $row;
	// 			}
	// 			$stmt->close();
	// 		}

			
	// 		return $data;
	// 	}
	public function fetchStatisticsByYear($year) {
		$data = null;
		
		$next_year = intval($year) + 1;

		$query = "SELECT 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) + 
			(SELECT COUNT(*) FROM family_talaan_kabataan WHERE profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS total_population, 
			(SELECT COUNT(*) FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01') AS households, 
			(SELECT COUNT(*) FROM (
				SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabahayan WHERE kasarian = 'M' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01') 
				UNION ALL 
				SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabataan WHERE kasarian = 'M' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')
			) combined_tables) AS men, 
			(SELECT COUNT(*) FROM (
				SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabahayan WHERE kasarian = 'F' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01') 
				UNION ALL 
				SELECT kasarian COLLATE utf8mb4_unicode_ci as kasarian FROM family_talaan_kabataan WHERE kasarian = 'F' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')
			) combined_tables) AS females, 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'Senior' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS senior, 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'PWD' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS pwd, 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'Solo-Parent' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS solo_parents, 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'School Dropout' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS out_of_school, 
			(SELECT COUNT(*) FROM family_talaan_kabahayan WHERE status = 'Unemployed' AND profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS unemployed,
			(SELECT COUNT(*) FROM family_talaan_kabataan WHERE profile_id IN (SELECT id FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01')) AS infants,
			(SELECT COUNT(*) FROM family_profile WHERE status = 'Approved' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01') AS active_residents,
			(SELECT COUNT(*) FROM family_profile WHERE status = 'inactive' AND DATE(petsa) >= '".$year."-01-01' AND DATE(petsa) < '".$next_year."-01-01') AS inactive_residents
			;";

		if ($stmt = $this->conn->prepare($query)) {
			// $stmt->bind_param('s', $year);
			$stmt->execute();
			$result = $stmt->get_result();
			$num_of_rows = $stmt->num_rows;
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
			$stmt->close();
		}

		
		return $data;
	}
		
		public function fetchAdminEmailID($email) {
			$query = "SELECT id FROM admin WHERE email = ? LIMIT 1";
			
			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$stmt->bind_result($id);
				$stmt->store_result();
				if($stmt->num_rows > 0) {
					if($stmt->fetch()) {
						return $id;
					}
				}
				else {
					return false;
				}
				$stmt->close();
			}
			$this->conn->close();
		}
		
		public function verifiedAdminChangePassword($id, $password) {
			$query = "UPDATE admin SET password = ? WHERE id = ?";
			
			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('si', $password, $id);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function fetchCommunity() {
			$data = null;

			$query = "SELECT * FROM admin";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function addEvent($event_image, $event, $event_place, $event_date) {
		    $query = "INSERT INTO admin_logs (event_image, event, event_place, datetime) VALUES (?, ?, ?, ?)";
			
			if($stmt = $this->conn->prepare($query)) {

				$stmt->bind_param('ssss', $event_image, $event, $event_place, $event_date);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function fetchProfile($profile_id) {
			$data = null;

			$query = "SELECT * FROM family_profile WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
			    $stmt->bind_param("i", $profile_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function fetchKabahayan($profile_id) {
			$data = null;

			$query = "SELECT * FROM family_talaan_kabahayan WHERE profile_id = ?";

			if ($stmt = $this->conn->prepare($query)) {
			    $stmt->bind_param("i", $profile_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function fetchKabataan($profile_id) {
			$data = null;

			$query = "SELECT * FROM family_talaan_kabataan WHERE profile_id = ?";

			if ($stmt = $this->conn->prepare($query)) {
			    $stmt->bind_param("i", $profile_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function updateFamilyProfile($house_no, $street, $apartment_owner, $sitio, $relihiyon, $contact_no, $tubig, $palikuran, $tanim, $hardin, $manok, $baboy, $gumagamit_ng, $buntis, $pamilya, $family_planning, $pangalan, $id) {
			$query = "UPDATE family_profile SET house_no = ?, street = ?, apartment_owner = ?, sitio = ?, relihiyon = ?, contact_no = ?, tubig = ?, palikuran = ?, tanim = ?, hardin = ?, manok = ?, baboy = ?, gumagamit_ng = ?, buntis = ?, pamilya = ?, family_planning = ?, pangalan = ? WHERE id = ?";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('sssssssssssssssssi', $house_no, $street, $apartment_owner, $sitio, $relihiyon, $contact_no, $tubig, $palikuran, $tanim, $hardin, $manok, $baboy, $gumagamit_ng, $buntis, $pamilya, $family_planning, $pangalan, $id);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function removeKabahayan($profile_id) {
			$query = "DELETE FROM family_talaan_kabahayan WHERE profile_id = ?";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('i', $profile_id);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function removeKabataan($profile_id) {
			$query = "DELETE FROM family_talaan_kabataan WHERE profile_id = ?";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('i', $profile_id);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function fetchEvents() {
			$data = null;

			$query = "SELECT * FROM admin_logs ORDER BY log_id DESC";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function addEditRequest($profile_id, $gov_id, $email) {
		    $query = "INSERT INTO edit_request (profile_id, gov_id, email, date_sent) VALUES (?, ?, ?, ?)";
			
			if($stmt = $this->conn->prepare($query)) {
			    $date_sent = date("Y-m-d H:i:s");

				$stmt->bind_param('isss', $profile_id, $gov_id, $email, $date_sent);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function removeEditRequest($id) {
			$query = "DELETE FROM edit_request WHERE id = ?";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('i', $id);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function fetchEditRequests() {
			$data = null;

			$query = "SELECT a.*, b.pangalan, b.house_no, b.contact_no FROM edit_request AS a INNER JOIN family_profile AS b ON a.profile_id = b.id";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function fetchRequest($request_id) {
			$data = null;

			$query = "SELECT * FROM document_request WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
			    $stmt->bind_param("i", $request_id);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function changeEditRequestStatus($id, $password) {
			$query = "UPDATE admin SET password = ? WHERE id = ?";
			
			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('si', $password, $id);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function changeProfileStatus($status, $id) {
			$query = "UPDATE family_profile SET status = ? WHERE id = ?";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('si', $status, $id);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		public function searchProfiles($term) {
		    $search_term = '%' . $term . '%';
			$data = null;

			$query = "	SELECT family_talaan_kabahayan.id, family_talaan_kabahayan.pangalan , family_profile.house_no, family_profile.contact_no, family_profile.requirement, family_profile.petsa, family_talaan_kabahayan.status as sent ,family_profile.status
			FROM family_talaan_kabahayan
			LEFT JOIN family_profile ON family_talaan_kabahayan.profile_id = family_profile.id WHERE family_talaan_kabahayan.pangalan LIKE ?";

		


			if ($stmt = $this->conn->prepare($query)) {
			    $stmt->bind_param('s', $search_term);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}

			return $data;
		}
		
		public function searchRequests($term) {
		    $search_term = '%' . $term . '%';
			$data = null;

			$query = "SELECT * FROM document_request WHERE pangalan LIKE ?";

			if ($stmt = $this->conn->prepare($query)) {
			    $stmt->bind_param('s', $search_term);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function checkAlreadyRegistered($name) {
			$data = null;

			$query = "SELECT * FROM family_profile WHERE pangalan = ?";

			if ($stmt = $this->conn->prepare($query)) {
			    $stmt->bind_param('s', $name);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		
		
		
		
		
		
		public function countPopulationMF(){
			$data = null;
			$query = "SELECT 
			SUM(IF(kasarian = 'M',1,0)) as men, 
			SUM(IF(kasarian = 'F',1,0)) as females
			FROM family_talaan_kabahayan";
			if ($sql = $this->conn->query($query)) {
				while ($row = mysqli_fetch_assoc($sql)) {
					$data[] = $row;
				}
			}
			return $data;
		}
		
		public function countStatusFam(){
			$data = null;
			$query = "SELECT 
			SUM(IF(status = 'Senior',1,0)) as senior, 
			SUM(IF(status = 'PWD',1,0)) as pwd,
			SUM(IF(status = 'Solo-Parent',1,0)) as solo_parent, 
			SUM(IF(status = 'School Dropout',1,0)) as school_dropout,
			SUM(IF(status = 'Unemployed',1,0)) as unemployed
			FROM family_talaan_kabahayan";
			if ($sql = $this->conn->query($query)) {
				while ($row = mysqli_fetch_assoc($sql)) {
					$data[] = $row;
				}
			}
			return $data;
		}
		
		public function countInfant(){
			$data = null;
			$query = "SELECT COUNT(*) as infants FROM family_talaan_kabataan WHERE kapanganakan >= DATE_SUB(NOW(), INTERVAL 9 MONTH) AND kapanganakan <= DATE_SUB(NOW(), INTERVAL 1 MONTH);";
			if ($sql = $this->conn->query($query)) {
				while ($row = mysqli_fetch_assoc($sql)) {
					$data[] = $row;
				}
			}
			return $data;
		}
		

		
		
		public function fetchProfiles2() {
			$data = null;
			if(!empty($_POST['year'])){
				$year = $_POST['year'] ?? null;
			}else if(!empty($_GET['year'] )){
				$year = $_GET['year'] ?? null;
			}else{
				$year = '2023';
			}
			$yearFilter = '';
			if ($year !== null) {
				$next_year = intval($year) + 1;
				$yearFilter = " AND DATE(petsa) >= '$year-01-01' AND DATE(petsa) < '$next_year-01-01'";
			}
			$query = "SELECT * FROM family_profile WHERE status = 'Approved'$yearFilter";

			if ($result = $this->conn->query($query)) {
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$result->close();
			}
			return $data;
		}
		
		
		// public function fetchProfiles4_5($gender) {
		// 	$data = null;

		// 	$query = "SELECT b.pangalan as ftk_name, a.* FROM family_profile as a INNER JOIN family_talaan_kabahayan as b ON a.id = b.profile_id WHERE b.kasarian = '$gender'";

		// 	if ($stmt = $this->conn->prepare($query)) {
		// 		$stmt->execute();
		// 		$result = $stmt->get_result();
		// 		$num_of_rows = $stmt->num_rows;
		// 		while ($row = $result->fetch_assoc()) {
		// 			$data[] = $row;
		// 		}
		// 		$stmt->close();
		// 	}
		// 	return $data;
		// }
		public function fetchProfiles4_5($gender) {
			$data = null;
		
			$year = $_GET['year'] ?? $_POST['year'] ?? '2023'; // Set 2023 as the default year if not provided
		
			$query = "SELECT b.pangalan as ftk_name, a.* 
					  FROM family_profile as a 
					  INNER JOIN family_talaan_kabahayan as b ON a.id = b.profile_id 
					  WHERE b.kasarian = ? AND YEAR(a.petsa) = ? AND a.status = 'Approved'";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('ss', $gender, $year);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
		
			return $data;
		}
		
		
		
		// public function fetchProfiles6_7_8_9_10($status) {
		// 	$data = null;

		// 	$query = "SELECT b.pangalan as ftk_name,a.* FROM family_profile as a INNER JOIN family_talaan_kabahayan as b ON a.id = b.profile_id WHERE b.status = '$status'";

		// 	if ($stmt = $this->conn->prepare($query)) {
		// 		$stmt->execute();
		// 		$result = $stmt->get_result();
		// 		$num_of_rows = $stmt->num_rows;
		// 		while ($row = $result->fetch_assoc()) {
		// 			$data[] = $row;
		// 		}
		// 		$stmt->close();
		// 	}
		// 	return $data;
		// }
		public function fetchProfiles6_7_8_9_10($status) {
			$data = null;
		
			$year = $_GET['year'] ?? $_POST['year'] ?? '2023'; // Set 2023 as the default year if not provided
		
			$query = "SELECT b.pangalan as ftk_name, a.* 
					  FROM family_profile as a 
					  INNER JOIN family_talaan_kabahayan as b ON a.id = b.profile_id 
					  WHERE b.status = ? AND YEAR(a.petsa) = ? AND a.status = 'Approved'";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('ss', $status, $year);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
		
			return $data;
		}
		


		
		public function fetchProfiles11() {
			$data = null;
		
			$year = $_GET['year'] ?? $_POST['year'] ?? '2023'; // Set 2023 as the default year if not provided
			$familyStatus = 'Approved';
		
			$query = "SELECT family_talaan_kabataan.pangalan, family_talaan_kabataan.kapanganakan, family_talaan_kabataan.kasarian, family_talaan_kabataan.bakuna, family_profile.house_no, family_profile.contact_no, family_profile.petsa, family_profile.status
					  FROM family_talaan_kabataan 
					  LEFT JOIN family_profile on family_profile.id =  family_talaan_kabataan.profile_id
					  WHERE kapanganakan >= DATE_SUB(NOW(), INTERVAL 9 MONTH) 
						AND kapanganakan <= DATE_SUB(NOW(), INTERVAL 1 MONTH) 
						AND YEAR(kapanganakan) = ? 
						AND family_profile.status  = ?";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('ss', $year, $familyStatus);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		
		
		public function addStructure($name, $email, $password, $position, $base, $unique, $rendered_service, $status) {
			$query = "INSERT INTO org_structure (name, email, password, position, image, image_unique, rendered_service, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('sssssssi', $name, $email, $password, $position, $base, $unique, $rendered_service, $status);
				$stmt->execute();
				if($stmt->errno == 1062) {
					echo "<script>alert('Email is already registred!');</script>";
				} 
				else {
				}
				$stmt->close();

				
			}
		}
		
		public function fetchPunongBrgy($status) {
			$data = null;
			$query = "SELECT * FROM org_structure WHERE status = ? ORDER BY position ASC";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('i', $status);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function deleteOrgStructure($id) {
			$query = "DELETE FROM org_structure WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('i', $id);
				$stmt->execute();
				$stmt->close();
			}
		}
		

		public function checkDuplicate($submitter_name, $house_number) {
	
			$data = null;
			$query = "SELECT * FROM `family_profile` WHERE house_no = ?";
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('i', $house_number);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $result->num_rows;
			
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			if($num_of_rows > 0){
				return true;
			}else{
				return false;
			}
	
			// return $data;
		}
		

		public function totalPopQry() {
			$data = null;
		
			if(!empty($_POST['year'])){
				$year = $_POST['year'] ?? null;
			}else if(!empty($_GET['year'] )){
				$year = $_GET['year'] ?? null;
			}else{
				$year = '2023';
			}
			$yearFilter = '';
		
			if ($year !== null) {
				$next_year = intval($year) + 1;
				$yearFilter = " AND DATE(family_profile.petsa) >= '$year-01-01' AND DATE(family_profile.petsa) < '$next_year-01-01'";
			}
			
			$query = "SELECT family_talaan_kabahayan.id, family_talaan_kabahayan.pangalan , family_profile.house_no, family_profile.contact_no, family_profile.house_no, family_profile.requirement, family_profile.petsa, family_profile.status
				FROM family_talaan_kabahayan
				LEFT JOIN family_profile ON family_talaan_kabahayan.profile_id = family_profile.id WHERE family_profile.status = 'Approved'$yearFilter;";
	
			if ($result = $this->conn->query($query)) {
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$result->close();
			}


			$infants = $this->fetchProfiles11();
			if(!empty($infants)){
				foreach ($infants as $keya => $valuea) {
					$data[] = $valuea;
				}
			}

			
			return $data;
		}
		


		public function inactiveResidents() {
			$data = null;

			$query = "SELECT family_talaan_kabahayan.id, family_talaan_kabahayan.pangalan , family_profile.house_no, family_profile.contact_no, family_profile.requirement, family_profile.petsa, family_talaan_kabahayan.status as sent ,family_profile.status
			FROM family_talaan_kabahayan
			LEFT JOIN family_profile ON family_talaan_kabahayan.profile_id = family_profile.id WHERE family_profile.status = 'inactive';";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}
		public function activeResidents() {
			$data = null;

			$query = "SELECT family_talaan_kabahayan.id, family_talaan_kabahayan.pangalan , family_profile.house_no, family_profile.contact_no, family_profile.requirement, family_profile.petsa, family_talaan_kabahayan.status as sent ,family_profile.status
			FROM family_talaan_kabahayan
			LEFT JOIN family_profile ON family_talaan_kabahayan.profile_id = family_profile.id WHERE family_profile.status = 'Approved';";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}



		public function inactiveFamilyChecker() {
			$data = null;
		
			// Fetch records that meet the condition
			$query = "SELECT id, petsa, status, DATEDIFF(STR_TO_DATE(petsa, '%Y-%m-%d'), NOW()) AS age_in_days FROM `family_profile` WHERE DATEDIFF(STR_TO_DATE(petsa, '%Y-%m-%d'), NOW()) >= 365;";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				
				// Loop through the results
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
					
					// Update the status to "inactive" for each record
					$this->updateStatusToInactive($row['id']);
				}
				
				$stmt->close();
			}
			
			return $data;
		}
		
		// Function to update the status to "inactive" for a given ID
		private function updateStatusToInactive($id) {
			$updateQuery = "UPDATE `family_profile` SET status = 'inactive' WHERE id = ?;";
		
			if ($stmt = $this->conn->prepare($updateQuery)) {
				$stmt->bind_param("i", $id);
				$stmt->execute();
				$stmt->close();
			}
		}


		public function govImageUpdate($profile_id, $requirement) {
		    // $query = "INSERT INTO edit_request (profile_id, gov_id, email, date_sent) VALUES (?, ?, ?, ?)";
			$query = "UPDATE `family_profile` SET `requirement` = ? WHERE `family_profile`.`id` = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$date_sent = date("Y-m-d H:i:s");
			
				// Use 'ss' instead of 'is' for string parameters
				$stmt->bind_param('ss', $requirement, $profile_id);
				$stmt->execute();
				$stmt->close();
			}
			
		}

		public function deleteFamilyData($id) {
			// Delete from family_talaan_kabahayan
			$deleteTalaanQuery = "DELETE FROM `family_talaan_kabahayan` WHERE profile_id = ?;";
			
			if ($stmt = $this->conn->prepare($deleteTalaanQuery)) {
				$stmt->bind_param("i", $id);
				$stmt->execute();
				$stmt->close();
			}
		
			// Delete from family_profile
			$deleteProfileQuery = "DELETE FROM `family_profile` WHERE id = ?;";
			
			if ($stmt = $this->conn->prepare($deleteProfileQuery)) {
				$stmt->bind_param("i", $id);
				$stmt->execute();
				$stmt->close();
			}
		}

		public function fetchGeneratedYearDisplaySetting() {
			$data = null;
		
			$query = "SELECT * FROM settings WHERE setting_name = 'generated_year_display'";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->execute();
				$result = $stmt->get_result();
				while ($row = $result->fetch_assoc()) {
					$data = $row['setting_value'];
				}
				$stmt->close();
			}
			return $data;
		}
		
		public function updateGeneratedYearDisplaySetting($year) {
			$query = "UPDATE settings SET setting_value = ? WHERE setting_name = 'generated_year_display'";
		
			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("s", $year);
				$stmt->execute();
				$stmt->close();
				return true; // or you can return $stmt->affected_rows to check the number of affected rows
			} else {
				return false;
			}
		}
		

		public function deleteDocReq($id) {
			$query = "DELETE FROM document_request WHERE id = ?";

			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('i', $id);
				$stmt->execute();
				$stmt->close();
			}
		}
		
		
	}

?>