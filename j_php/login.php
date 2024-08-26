<?php
require_once("../includes/initialize.php");

$username = $_POST['username'];
$password = $_POST['password'];

$found_user = User::authenticate($username, $password);

if ($found_user) {
    $session->login($found_user->user_id);
    //save log
    $log = new logs();
    $log->login();

    echo '1';
} 
    else {
    echo '0';
}

?>
