<?php
include 'Global/Model.php';
$model = new Model();

// Assuming $_GET['id'] is set and not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Call the deleteFamilyData function
    $delete_fam = $model->deleteFamilyData($id);

    // Redirect to /Profiles.php
    header("Location: /Profiles.php");
    exit(); // Make sure to exit after the header to prevent further execution
} else {
    // Handle the case where $_GET['id'] is not set or empty
    echo "Invalid or missing ID";
}
?>
