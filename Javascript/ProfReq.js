document.querySelectorAll('[id^="approve-"]').forEach(function(element) {
  element.addEventListener('click', function() {
    var id = this.id.substring(8);
    document.querySelector('#approveForm-' + id).style.display = 'block';
  });
});

document.querySelectorAll('[id^="closeApproveForm-"]').forEach(function(element) {
  element.addEventListener('click', function() {
    var id = this.id.substring(17);
    document.querySelector('#approveForm-' + id).style.display = 'none';
  });
});

document.querySelectorAll('[id^="decline-"]').forEach(function(element) {
  element.addEventListener('click', function() {
    var id = this.id.substring(8);
    document.querySelector('#declineForm-' + id).style.display = 'block';
  });
});

document.querySelectorAll('[id^="closeDeclineForm-"]').forEach(function(element) {
  element.addEventListener('click', function() {
    var id = this.id.substring(17);
    document.querySelector('#declineForm-' + id).style.display = 'none';
  });
});