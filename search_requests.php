<?php

    session_start();

	include 'Global/Model.php';

	$model = new Model();
    
    $data = '';
	$term = trim($_POST['term']);
	$i = 1;
	$rows  = $model->searchRequests($term);
	
	if (!empty($rows)) {
	    foreach ($rows as $row) {
	        $gov_id = (empty($row['requirement']) || $row['requirement'] == "EMPTY") ? 'NO GOVERMENT ID' : '<a href="" id="gov_id-'.$row['id'].'">Click to see attachment</a>';
	        $pending = ($row['status'] == 'Pending') ? 'selected' : '';
	        $declined = ($row['status'] == 'Declined') ? 'selected' : '';
	        $approved = ($row['status'] == 'Approved') ? 'selected' : '';
	        
	        $data .= '
	        <tr>
                                <td> '.$i.' </td>
                                <td> '.$row['pangalan'].' </td>
                            ';
 
                                
                            if (isset($_SESSION['admin_sess'])) {
                                $data .= '<td> '.$row['house_no'].' </td>
                                <td> '.$row['contact_no'].' </td>';
                            }

                            $data .= '
                                <td> '.$row['document_type'].' </td>
                            ';
                            if (isset($_SESSION['admin_sess'])) {
                                $data .= '<td> '.$gov_id.' </td>';
                            }
                            $data .= '
                                <td> '.date('F j, Y', strtotime($row['date_sent'])).' </td>
                                <td> <p class="status '.strtolower($row['status']).'"';
                                
                               if (isset($_SESSION['admin_sess'])) {
                                $data .= 'id="change-trigger-'.$row['id'].'"';}
                                
                                
                                
                            $data .= '>'.$row['status'].'</p> </td>
                                <td> <strong> P100 </strong> </td>
                            </tr>
                            <div id="changeStatus'.$row['id'].'" class="modal">
                                <div class="modal-content">
                                  <span class="close">&times;</span>
                                  <h2>Change Status</h2>
                                  <form method="POST">
                                      <input type="hidden" name="status_id" value="'.$row['id'].'">
                                      <input type="hidden" name="status_contact" value="'.$row['contact_no'].'">
                                    <label for="status-'.$row['id'].'">Type of Document</label>
                                    <select id="status-'.$row['id'].'" name="status" required>
                                        <option value="Pending" '.$pending.'>Pending</option>
                                        <option value="Declined" '.$declined.'>Declined</option>
                                        <option value="Approved" '.$approved.'>Approved</option>
                                    </select>
                                    <br>
                                    <button id="login-btn" name="change_request" type="submit">Submit</button>
                                  </form>
                                </div>
                              </div>
                            ';
                            
                            if (isset($row['requirement'])) {
                                $data .= '<div id="gov_id_modal-'.$row['id'].'" class="modal">
                                <div class="modal-content">
                                  <span class="close" id="gov_id_close-'.$row['id'].'">&times;</span>
                                  <h2>Request</h2>
                                  <img src="Requirement/'.$row['requirement'].'.jpg" style="max-width: 100%;">
                                </div>
                            </div>
	                            ';
                            }
                            
            $i++;
	    }
	}
	
	echo $data;
	
?>