<?php
require_once("../includes/initialize.php");

$user = User::find_by_id($_POST['user_id']);
$user->password = $_POST['password'];

echo $user->edit();
?>