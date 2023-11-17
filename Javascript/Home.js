// Get the modal element
var modal = document.getElementById("myModal");

// Get the open modal button and close button
var openModalBtn = document.getElementById("openModalBtn");
var closeBtn = document.getElementsByClassName("close")[0];

// Function to open the modal
function openModal(event) {
  event.preventDefault(); // Prevent the default behavior of anchor links
  modal.style.display = "block";
}

// Function to close the modal
function closeModal() {
  modal.style.display = "none";
}

// Attach the openModal function to the open modal button click event
openModalBtn.addEventListener("click", openModal);

// Attach the closeModal function to the close button click event
closeBtn.addEventListener("click", closeModal);

var password = document.getElementById("password"), confirm_password = document.getElementById("confirmPassword");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;