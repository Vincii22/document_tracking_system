<?php
require_once("../includes/initialize.php");

// Use email for authentication
$email = $_POST['email'];
$password = $_POST['password'];

// Authenticate using email instead of username
$found_user = User::authenticate_by_email($email, $password);

if ($found_user) {
    $session->login($found_user->user_id);
    
    // Save log
    $log = new logs();
    $log->login();

    echo '1';
} else {
    echo '0';
}
?>
