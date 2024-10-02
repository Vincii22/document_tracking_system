<?php
require_once("../includes/initialize.php");

if(isset($_SESSION['usertype'])) {

    if( $_SESSION['usertype'] == 'admin' ) {
        redirect_to('mastermind/user_mgmt.php');
    }
    
    else if ( $_SESSION['usertype'] == 'dean' ){
        redirect_to('profile.php');
    }
    
    else if ( $_SESSION['usertype'] == 'assistant' ){
        redirect_to('profile.php');
    }
    else if ( $_SESSION['usertype'] == 'student assistant' ){
        redirect_to('profile.php');
    }
    else if ( $_SESSION['usertype'] == 'guest' ){
        redirect_to('track_doc.php');
    }
    
    else {
        redirect_to('login.php');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dts-Log-in</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css">
    <link rel="stylesheet" href="assets/css/Data-Table2.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h5>DWCL</h5>
            <h6>Document Tracking System</h6>
        </div>
        <form id="loginForm" method="POST">
    <div class="form-group">
        <small id="errorContainer">Incorrect email or password</small>
        <input class="form-control" 
           type="email" 
           placeholder="Email" 
           id="email" 
           name="email" 
           required 
           pattern=".+@dwc-legazpi\.edu$" 
           title="Email must end with @dwc-legazpi.edu">
        <input class="form-control" type="password" placeholder="Password" id="password" name="password" required>
        <button class="btn btn-primary btn-block" type="submit" id="login">Login</button>
    </div>
</form>
    </div>

    <div class="footer-basic fixed-bottom">
        <footer>
            <p class="copyright" style="margin-top: 0 !important">DWCL Document Tracking System © 2024</p>
        </footer>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap.min.js"></script>
    <script src="../includes/dts.js"></script>
    <script>
 
</script>
</body>

</html>