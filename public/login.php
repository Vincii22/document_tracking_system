<?php
require_once("../includes/initialize.php");

if(isset($_SESSION['usertype'])) {

    if ($_SESSION['usertype'] == 'admin' ) {
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
</head>

<body style="height:650px;">
    <div></div>
    <div style="font-size:10px;width:272px;padding:150px 0px;">
        <div class="container" style="padding:0px;width:25px;margin:0px;">
            <div class="row no-gutters" style="width:220px;">
                <form id="loginForm" style="margin:0px 0px;padding:0px 0px;"action="../../j_php/login.php" method="POST">
                    <div class="form-group">
                        <div class="form-row" style="padding:0px;margin:7px;">
                            <div class="col" style="width:216px;">
                                <h5 style="font-size:20px;color:rgb(255,0,0);">DWCL</h5>
                                <h6 style="font-size:20px;width:250px;color:rgb(255,0,0);">Document Tracking System</h6>
                            </div>
                        </div>
                        <div class="form-row" style="padding:0px;margin:7px;">
                            <div class="col" style="width:216px;"><small id="errorContainer" style="font-size:14px;width:265px;color:rgb(255,33,18); display:none">Incorrect username or password</small></div>
                        </div>
                        <div class="form-row" style="padding:0px;margin:7px;">
                            <div class="col"><input class="form-control" type="text" placeholder="Username" id="username" style="width:250px;height:40px;font-size:15px;"></div>
                        </div>
                        <div class="form-row" style="padding:0px;margin:7px;">
                            <div class="col"><input class="form-control" type="password" placeholder="Password" id="password" style="height:40px;"></div>
                        </div>
                        <div class="form-row" style="padding:0px;margin:7px;">
                            <div class="col"><button class="btn btn-danger btn-sm" type="submit" id="login" style="height:40px;font-size:15px;width:250px;padding:0px 0px;">Login</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="footer-basic fixed-bottom" style="height:42px;margin:0px;padding:0px 0px;background-color:rgb(255,0,0);">
        <footer>
            <p class="copyright" style="color:rgb(255,255,255);"></p>
        </footer>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap.min.js"></script>

    <script src="../includes/dts.js"></script>
</body>

</html>