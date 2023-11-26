function openLoginForm() {
    document.getElementById("loginForm").style.display = "block";
}

            function closeLoginForm() {
    document.getElementById("loginForm").style.display = "none";
}

$(function() {

$(document).on('click', '.close', function(e) {
    var elements = document.querySelectorAll('[id^="changeStatus"]');
elements.forEach(function(element) {
  element.style.display = "none";
});
            });

$(document).on('click', '[id^="change-trigger-"]', function(e) {
    console.log('test');
                var id = this.id.substring(15);
                $('#changeStatus' + id).css('display', 'block');
            });


  
document.getElementById('doc').addEventListener('change', function() {
    var upload = '';
    
    switch (this.value) {
        case 'Business Closure':
            upload += 'Affidavit of Business Closure';
            break;
        case 'First Time Job Seeker':
            upload += 'Resident';
            break;
        case 'Solo Parent':
            upload += 'Affidavit / Birth Certificate of Child ';
            break;
        case 'Senior Citizen':
            upload += 'Birth Certificate';
            break;
        case 'Residency':
            upload += 'Police Clearance';
            break;
        default:
            upload += 'Valid ID';
    }
    // document.getElementById('file-upload').innerHTML = '<label for="upload">'+upload+'</label><input type="file" name="requirement" id="upload" required>';
    document.getElementById('file-upload').innerHTML = '<label for="upload">'+upload+'</label><div class="file-input-container"><label for="upload" class="custom-file-input">Choose Upload File</label><input type="file" id="upload" name="requirement" style="padding-top: 8px;" required></div>';
});
});
