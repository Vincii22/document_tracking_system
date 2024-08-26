<?php
require_once("../includes/initialize.php");

$user = User::find_by_id($_GET['user_id']);

echo $user->delete();
?>