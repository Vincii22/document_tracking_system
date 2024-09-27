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

echo $personnel->add();

?>