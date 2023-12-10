<?php

include 'Global/Model.php';

$model = new Model();
$mode = $_GET['mode'];


switch ($mode) {
    case 'checkduplicate':
        $is_valid = false;
        $errMessage = '';
        $name = $_GET['name'];
        $house_no = $_GET['house_no'];
        $checkDuplicates = $model->checkDuplicate($name, $house_no); # Check if already exists
        if ($checkDuplicates == true) {
            // echo 'HAS DUPLICATES';
            $is_valid = true;
            $_POST = [];
            $errMessage = 'Data Already Exist, please change your House No.';
        } else if ($checkDuplicates == false) {
            // echo 'NO DUPLICATES';

            $is_valid = false;
        }

        $returns = [
            'is_valid' => $is_valid,
            'errMessage' => $errMessage,
        ];
        echo json_encode($returns);

        break;

}
