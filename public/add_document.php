<?php require_once("../includes/initialize.php"); 

if(!isset($_SESSION['usertype'])) {
    redirect_to('login.php');
} else {
    if ($_SESSION['usertype'] == 'guest' ) {
        redirect_to('track_doc.php');
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dts-Add Document</title>
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
    <div>
        <nav class="navbar navbar-light navbar-expand-md navigation-clean-button" style="height:38px;background-color:rgb(255,0,0);padding:0px;">
            <div class="container"><a class="navbar-brand" href="#" style="color:rgba(255,255,255,0.9);">sl-dts</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div
                    class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav mr-auto">
                        <li class="dropdown dts_all"><a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color:rgb(255,255,255);">Documents</a>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item dts_uam" role="presentation" href="add_document.php">Add Document</a>
                                <a class="dropdown-item dts_uam" role="presentation" href="docs_on_hand.php">Process Document</a>
                                <a class="dropdown-item dts_all" role="presentation" href="track_doc.php">Track Document</a>
                                <a class="dropdown-item dts_am" role="presentation" href="mgmt/doc_mgmt.php">Document List</a></div>
                        </li>
                        <li class="dropdown dts_a">
                                <a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color:rgb(255,255,255);">Key Elements</a>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" role="presentation" href="mastermind/user_mgmt.php">User Mgmt</a>
                                <a class="dropdown-item" role="presentation" href="mastermind/dept_mgmt.php">Dept Mgmt</a></div>
                        </li>
                        <li class="nav-item dts_am" role="presentation"><a class="nav-link active" href="#" style="color:rgb(255,255,255);">Analytics</a></li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="dropdown"><a class="dropdown-toggle nav-link text-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#" data-id="<?php echo $_SESSION['user_id']?>" data-utype="<?php echo $_SESSION['usertype']?>" data-dept="<?php echo $_SESSION['dept_id']?>" id="usernameHolder" style="color:rgb(255,255,255);"><i class="fa fa-user"></i>&nbsp; 
                        <?php echo $_SESSION['username']; ?> 
                        </a>
                            <div class="dropdown-menu dropdown-menu-right"
                                role="menu"><a class="dropdown-item" role="presentation" href="#" id="changePassword" data-target="#editPassword" data-toggle="modal">Change Password</a><a class="dropdown-item" role="presentation" href="logout.php">Logout</a></div>
                        </li>
                    </ul>
            </div>
    </div>
    </nav>
    </div>
    <div style="font-size:10px;">
        <div class="container" style="padding:0px 125px;">
            <div class="row" style="padding:0px;margin:7px;height:36px;width:929px;">
                <div class="col" style="margin:20px 0px;">
                    <h4 style="color:rgb(134,142,150);">Add Document</h4>
                </div>
            </div>
            <div class="row no-gutters" style="width:939px;">
                <div class="col-auto" style="margin:19px;width:923px;">
                    <form style="width:925px;">
                        <div class="form-group" style="width:916px;">
                            <div class="form-row">
                                <div class="col"><label class="col-form-label" style="font-size:15px;">Document Name:</label><input class="form-control" type="text" id="docName" style="width:496px;height:30px;font-size:14px;"></div>
                            </div>
                            <div class="form-row">
                                <div class="col"><label class="col-form-label" style="font-size:15px;">Document Type:</label><select class="form-control" id="docType" style="height:30px;width:165px;font-size:14px;padding:4px;"><option value="1">Request</option><option value="2">For Processing</option><option value="3">Submission</option><option value="4">Communication</option></select></div>
                            </div>
                            <div class="form-row">
                                <div class="col"><label class="col-form-label" style="font-size:15px;">Document Owner Type:</label><select class="form-control" id="docOwnerType" style="height:30px;width:165px;font-size:14px;padding:4px;"><optgroup label="docownertype"><option value="1">District</option><option value="2">School</option><option value="3">Individual</option><option value="4">Other</option></optgroup></select></div>
                            </div>
                            
                            <div class="form-row" style="width:922px;padding:6px;font-size:15px;">
                                <div class="col-2 visible" id="districtOwner" style="width:149px;padding:0px;height:66px; "><label class="col-form-label">District:</label><select class="form-control" id="district" style="height:30px;width:145px;font-size:14px;padding:4px;"><optgroup label="Districts"></optgroup></select></div>
                                <div class="col-3" id="schoolOwner"><label class="col-form-label">School:</label><select class="form-control" id="school" style="height:30px;width:215px;font-size:14px;padding:4px;"></select></div>
                                <div class="col-3" id="individualOwner"><label class="col-form-label">Individual:</label><input class="form-control" type="text" id="individual" style="width:216px;height:30px;font-size:14px;"></div>
                                <div class="col-3" id="otherOwner"><label class="col-form-label">Other:</label><input class="form-control" type="text" id="other" style="width:216px;height:30px;font-size:14px;"></div>
                            </div>

                            <div class="form-row">
                                <div class="col"><label class="col-form-label" style="font-size:15px;">Contact Number</label><input class="form-control" type="number" required="" maxlength="10" minlength="10" inputmode="numeric" id="contactNum" style="width:216px;height:30px;font-size:14px;"></div>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
            <div class="row" style="padding:0px;margin:7px;width:934px;">
                <div class="col" style="width:961px;height:28px;"><button class="btn btn-success" type="button" id="addDoc" style="height:33px;width:143px;font-size:14px;padding:5px;" disabled>Add Document</button></div>
            </div>
        </div>
    </div>
    <div class="footer-basic fixed-bottom" style="height:42px;margin:0px;padding:0px 0px;background-color:rgb(255,0,0);">
        <footer>
            <p class="copyright" style="color:rgb(255,255,255);">jkiqui-dts-v1 © 2018</p>
        </footer>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="editPassword" style="padding:0px 0px;margin:200px 0px;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:rgb(255,0,0);width:298px;margin:0px 0px;height:30px;padding:2px 2px;">
                    <h5 class="modal-title" style="color:rgb(0,255,255);margin:-2px 4px;">Change Password</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body" style="width:273px;">
                    <div class="row">
                        <div class="col"><small style="color:rgb(255,0,0); display:none">Password was updated successfully.</small></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;"><label class="col-form-label" style="font-size:12px;">Enter Password:</label><input type="password" id="mPassword1" style="font-size:12px;margin:0px 21px;"></div>
                        <div class="col-auto" style="margin:0px 0px;"><label class="col-form-label" style="font-size:12px;">Reenter Password:&nbsp;</label><input type="password" id="mPassword2" style="font-size:12px;margin:5px;"></div>
                    </div>
                </div>
                <div class="modal-footer" style="height:35px;"><button class="btn btn-light btn-sm" type="button" id="mPasswordClose" data-dismiss="modal" style="height:23px;width:50px;margin:0px 0px;padding:0px 0px;">Close</button><button class="btn btn-primary btn-sm" type="button" id="mPasswordSave"
                        style="height:23px;padding:0px 0px;margin:0px 10px;width:45px;font-size:12px;">Save</button></div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap.min.js"></script>
  
    <script src="../j_js/document.js"></script>
    <script src="../j_js/menu-visibility.js"></script>
</body>

</html>