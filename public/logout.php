<?php
require_once("../includes/initialize.php");

//save log
$log = new logs();
$log->logout();

$session->logout();

redirect_to('login.php');