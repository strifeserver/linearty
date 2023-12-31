let i = 1;

  document.getElementById('talaan-bata-add').addEventListener('click', function() {
    i++;
    const newRow = document.createElement('tr');
    newRow.id = 'row' + i;
    newRow.innerHTML = `
      <td>${i}</td>
      <td><div class="input"> <input type="text" placeholder="Pangalan" name="bata_pangalan[]" required> </div></td>
      <td><div class="input"> <input type="date" placeholder="Kanganakan" name="bata_kapanganakan[]" required> </div></td>
      <td><div class="input"> <input type="number" placeholder="Edad" name="bata_edad[]" required> </div></td>
      <td><div class="input"> <select name="bata_kasarian[]" required><option value="" disabled="" selected="">Select gender</option><option value="M">Male</option><option value="F">Female</option></select> </div></td>
      <td><div class="input"> <input type="text" placeholder="Bakuna" name="bata_bakuna[]" required> </div></td>
      <td><button type="button" data-id="${i}" class="bata_remove">-</button></td>
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
  
  let kabahayan_i = 1;

  document.getElementById('talaan-kabahayan-add').addEventListener('click', function() {
    kabahayan_i++;
    const newRow = document.createElement('tr');
    newRow.id = 'krow' + kabahayan_i;
    newRow.innerHTML = `
      <td>${kabahayan_i}</td>
      <td> <div class="input"> <input type="text" name="kabahayan_name[]" placeholder="Fullname" required> </div> </td>
						<td> <div class="input"> <input type="date" name="kabahayan_dob[]" placeholder="Date of Birth" required> </div> </td>
						<td> <div class="input"> <input type="number" name="kabahayan_age[]" placeholder="Age" required> </div> </td>
						<td> <div class="input"> <select name="kabahayan_gender[]" required><option value="" disabled="" selected="">Select gender</option><option value="M">Male</option><option value="F">Female</option></select></div> </td>
						<td> <div class="input"> <input type="text" name="kabahayan_civil[]" placeholder="Civil Status" required> </div> </td>
						<td> <div class="input"> <input type="text" name="kabahayan_relationship[]" placeholder="Relationship" required> </div> </td>
						<td> <div class="input"> <input type="text" name="kabahayan_occupation[]" placeholder="Occupation" required> </div> </td>
						<td> <div class="input"> <input type="date" name="kabahayan_year[]" placeholder="Year of Residency" required> </div> </td>
						<td> <div class="input"> 
						    <select name="kabahayan_status[]">
				                <option value="" disabled="" selected="">Select option</option>
				                <option value="PWD">PWD</option>
				                <option value="Senior">Senior</option>
				                <option value="Solo-Parent">Solo-Parent</option>
				                <option value="School Dropout">School Dropout</option>
				                <option value="Unemployed">Unemployed</option>
				            </select> </div> </td>
      <td><button type="button" data-id="${kabahayan_i}" class="kabahayan_remove">-</button></td>
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