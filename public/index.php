<?php
require_once("../includes/initialize.php");



echo $_SESSION['user_id'];

if( $_SESSION['usertype'] == 'admin' ) {
    redirect_to('mastermind/user_mgmt.php');
}

else if ( $_SESSION['usertype'] == 'mgmt' ){
    redirect_to('mgmt/doc_mgmt.php');
}

else if ( $_SESSION['usertype'] == 'user' ){
    redirect_to('docs_on_hand.php');
}

else if ( $_SESSION['usertype'] == 'guest' ){
    redirect_to('track_doc.php');
}

else {
    redirect_to('login.php');
}

?>