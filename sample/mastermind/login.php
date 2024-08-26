<?php
require_once("../../includes/initialize.php");

/*
if($session->is_logged_in()) {
    redirect_to('index.php');
}*/

echo 'YOU\'RE NOT LOGGED IN'.'<br />';
$username = 'joelqui';
$password = 'password';
$_SESSION['ftuse']=66;

$found_user = User::authenticate($username, $password);

if ($found_user) {
    $session->login($found_user->user_id);
    echo 'User ID of user logged in is '.$_SESSION['user_id'].' '.$_SESSION['ftuse'];
} else {
    echo 'Incorrect credentials';
}

if($_SESSION['ftuse']){
    echo 'okay';
} else {
    echo 'not okay';
}

?>