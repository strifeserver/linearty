            <main class="table">
                <section class="table_header">
                    <h1><?php echo $type_name; ?> | <?php echo $year; ?></h1>

                </section>
        
                <!--code nung pinaka table-->
                <!--yung links sa table data or TD is yung dummy profile nung ng send ng request-->
                <section class="table_body">

                    <!--table head-->
                    <table>
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Pangalan </th>
                                <th> Kapanganakan </th>
                                <th> Edad</th>
                                <th> Kasarian</th>
                                <th> Bakuna </th>
                            </tr>
                        </thead>
        
                        <!--dito yng table data/-->
                        <tbody id="profile_table">
                            
                            <?php
                            
                                $i = 1;
                                $rows = $model->fetchProfiles11();
                       
                                if (!empty($rows)) {
                                    foreach ($rows as $row) {
                                        
                                        
                                        $birthdate = $row['kapanganakan'];
                                        $currentDate = date('Y-m-d'); // Get the current date in the same format
                                        
                                        $birthDate = new DateTime($birthdate);
                                        $currentDate = new DateTime($currentDate);
                                        
                                        $interval = $birthDate->diff($currentDate);
                                        
                                        $ageInMonths = $interval->format('%m'); // Extract the number of months

                            ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td> <?php echo $row['pangalan']; ?></td>
                                <td> <?php echo $row['kapanganakan']; ?> </td>
                                <td> <?php echo $ageInMonths ?> month/s</td>
                                <td> <?php echo $row['kasarian']; ?> </td>
                                <td> <?php echo $row['bakuna']; ?> </td>
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