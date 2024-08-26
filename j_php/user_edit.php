<?php
require_once("../includes/initialize.php");

$user = User::find_by_id($_GET['user_id']);


$user->username = $_GET['username'];
$user->first_name = strtoupper($_GET['firstname']);
$user->last_name = strtoupper($_GET['lastname']);
$user->dept_id = $_GET['dept_id'];
$user->usertype = $_GET['usertype'];

echo $user->edit();
?>