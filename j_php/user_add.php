<?php
require_once("../includes/initialize.php");

$personnel = new User();


$personnel->username = $_POST['username'];
$personnel->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$personnel->first_name = $_POST['firstname'];
$personnel->last_name = $_POST['lastname'];
$personnel->usertype = $_POST['usertype'];
$personnel->dept_id = $_POST['dept'];

/* test script
$personnel->username = "z";
$personnel->password = "z";
$personnel->first_name = "z";
$personnel->last_name = "z";
$personnel->usertype = 1;
$personnel->dept_id = 1;
*/
if(isset($_FILES['user_image'])) {
    if ($_FILES['user_image']['error'] == 0) {
        $target_dir = "../uploads/users/";
        $file_name = basename($_FILES['user_image']['name']);
        $target_file = $target_dir . $file_name;

        // Move the uploaded file to the target directory
        if(move_uploaded_file($_FILES['user_image']['tmp_name'], $target_file)) {
            $personnel->user_image = $target_file; // Store the path in the database
            echo "Image successfully uploaded and path is: " . $personnel->user_image . "<br>";
        } else {
            echo "Error moving uploaded file.<br>";
        }
    } else {
        echo "Error uploading file. Code: " . $_FILES['user_image']['error'] . "<br>";
    }
} else {
    echo "No file uploaded.<br>";
}


echo $personnel->add();

?>