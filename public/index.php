<?php
require_once("../includes/initialize.php");



echo $_SESSION['user_id'];

if( $_SESSION['usertype'] == 'admin' ) {
    redirect_to('mastermind/user_mgmt.php');
}

else if ( $_SESSION['usertype'] == 'dean' ){
    redirect_to('dashboard.php');
}

else if ( $_SESSION['usertype'] == 'assistant' ){
    redirect_to('dashboard.php');
}
else if ( $_SESSION['usertype'] == 'student assistant' ){
    redirect_to('dashboard.php');
}
else if ( $_SESSION['usertype'] == 'guest' ){
    redirect_to('track_doc.php');
}

else {
    redirect_to('login.php');
}

?>