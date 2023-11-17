// var gov_id = document.querySelectorAll('[id^="gov_id-"]');

// gov_id.forEach(function(gov) {
//   gov.addEventListener('click', function(e) {
//     e.preventDefault();
//     var el_id = this.id.substring(7);
//     var modal = document.getElementById('gov_id_modal-' + el_id);
//     modal.style.display = 'block';
//   });
// });

// var gov_id_close = document.querySelectorAll('[id^="gov_id_close-"]');

// gov_id_close.forEach(function(gov_close) {
//   gov_close.addEventListener('click', function(e) {
//     e.preventDefault();
//     var el_id = this.id.substring(13);
//     var modal = document.getElementById('gov_id_modal-' + el_id);
//     modal.style.display = 'none';
//   });
// });
$(function() {
    $(document).on('click', '[id^="gov_id-"]', function(e) {
                e.preventDefault();
                var el_id = this.id.substring(7);
                $('#gov_id_modal-' + el_id).css('display', 'block');
            });

            // Close modals
            $(document).on('click', '[id^="gov_id_close-"]', function(e) {
                e.preventDefault();
                var el_id = this.id.substring(13);
                $('#gov_id_modal-' + el_id).css('display', 'none');
            });
});
