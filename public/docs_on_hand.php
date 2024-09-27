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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dts-Documents on Hand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css">
    <link rel="stylesheet" href="assets/css/Data-Table2.css">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/nav.css">
    <link rel="stylesheet" href="assets/css/docs_on_hand.css">
</head>

<body style="height:650px;">
<div class="sidebar">
<img src="assets/images/divineLogo.jpg" alt="Document Tracking System Logo" style="width: 80%; height: auto; margin-bottom: 20px;">

        <a href="add_document.php" title="Add Document" ><i class="fa fa-file-o"></i></a>
        <a href="docs_on_hand.php" title="Process Document"  class="active"><i class="fa fa-tasks"></i></a>
        <a href="track_doc.php" title="Track Document" ><i class="fa fa-search"></i></a>
        <a href="mgmt/doc_mgmt.php" title="Document List" ><i class="fa fa-list"></i></a>
        <a href="mastermind/user_mgmt.php" title="User Management" ><i class="fa fa-users"></i></a>
        <a href="mastermind/dept_mgmt.php" title="Department Management" ><i class="fa fa-building"></i></a>

    </div>
    <div>
    <nav class="navbar navbar-expand-md navigation-clean-button">
    <div class="container">
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle nav-link text-white" data-toggle="dropdown" aria-expanded="false" href="#" data-id="<?php echo $_SESSION['user_id']?>" data-utype="<?php echo $_SESSION['usertype']?>" data-dept="<?php echo $_SESSION['dept_id']?>" id="usernameHolder">
                        <i class="fa fa-user"></i>&nbsp; <?php echo $_SESSION['username']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a class="dropdown-item" role="presentation" href="#" id="changePassword" data-target="#editPassword" data-toggle="modal">Change Password</a>
                        <a class="dropdown-item" role="presentation" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>


    </div>
    <div style="font-size:10px;">
        <div class="container" style="width:1191px;">
            <div class="row" style="padding:0px;margin:0px;height:51px;width:929px;">
                <div class="col-9" style="margin:20px 0px;height:32px;">
                    <h4 style="color:rgb(134,142,150);padding:0px 120px;width:476px;">Process Documents</h4>
                </div>
                <div class="col-3" style="margin:20px 0px;height:32px;">
                
                <input class="visible" type="text" id="doc_search" placeholder="Search Documents" style="width:150px;height:35px;font-size:12px;" autocomplete="off"></div>
            </div>
            <div class="row" style="width:1100px;font-size:12px;height:504px;padding:0px 0px;margin:0px 0px;">
                <div class="col-auto my-auto" style="margin:0px;width:260px;height:449px;padding:0px 0px;"><select multiple="" id="incomingList" style="height:460px;width:250px;"><optgroup label="***INCOMING">
                
                </optgroup></select></div>
                <div
                    class="col-auto" style="margin:0px 0px;width:80px;height:300px;padding:0px 0px;">
                    <div class="row" id="incomingButtons" style="margin:140px 13px;">
                        <div class="col"><button class="btn btn-success btn-sm" type="button" id="acceptIncoming" style="height:23px;padding:0px 0px;font-size:12px;margin:0px -8px;width:65px;">Accept</button><button class="btn btn-warning btn-lg" type="button" id="addIncomingRemarks"
                                style="height:23px;padding:0px 0px;font-size:12px;background-color:rgb(225,33,33);margin:8px -8px;width:62px;" data-target="#remarksModal" data-toggle="modal">Remarks</button></div>
                    </div>
                    </div>
                    <div class="col-auto my-auto" style="margin:19px;width:260px;height:449px;"><select multiple="" id="onQueueList" style="height:460px;width:250px;"><optgroup label="***ON QUEUE">

                    </optgroup></select></div>
                    <div class="col-auto" style="margin:0px 0px;width:80px;height:449px;padding:0px 0px;">
                <div class="row" id="onQueueButtons" style="margin:140px 0px;">
                    <div class="col"><button class="btn btn-success btn-sm" type="button" id="forward" style="height:23px;padding:0px 0px;font-size:12px;margin:6px -8px;width:65px;" data-target="#forwardDoc" data-toggle="modal">Forward</button><button class="btn btn-warning btn-lg" type="button" id="addOnQueueRemarks"
                            style="height:23px;padding:0px 0px;font-size:12px;background-color:rgb(225,33,33);margin:3px -8px;width:62px;" data-target="#remarksModal" data-toggle="modal">Remarks</button><button class="btn btn-primary btn-lg" type="button"
                            id="completed" style="height:23px;padding:0px 0px;font-size:12px;background-color:rgb(225,33,33);margin:6px -8px;width:73px;">Completed</button><button class="btn btn-danger btn-lg" type="button" id="cancel" style="height:23px;padding:0px 0px;font-size:12px;background-color:rgb(225,33,33);margin:3px -8px;width:51px;">Cancel</button></div>
                </div>
        </div>
        <div class="col-auto my-auto" style="margin:19px;width:260px;height:449px;"><select multiple="" id="outgoingList" style="height:460px;width:250px;"><optgroup label="***OUTGOING">

        </optgroup></select></div>
        <div
            class="col-auto" style="margin:0px 0px;width:80px;height:449px;padding:0px 0px;">
            <div class="row" id="outgoingButtons" style="margin:140px 5px;">
                <div class="col"><button class="btn btn-danger btn-sm" type="button" id="cancelForward" style="height:23px;padding:0px 0px;font-size:12px;margin:0px -8px;width:94px;">Cancel Forward</button><button class="btn btn-warning btn-lg" type="button" id="addOutgoingRemarks"
                        style="height:23px;padding:0px 0px;font-size:12px;background-color:rgb(225,33,33);margin:8px -8px;width:62px;" data-target="#remarksModal" data-toggle="modal">Remarks</button></div>
            </div>
    </div>
    </div>
    </div>
    </div>
    <div class="footer-basic fixed-bottom" style="height:42px;margin:0px;padding:0px 0px;background-color:#4b83cc;">
        <footer>
            <p class="copyright" style="color:rgb(255,255,255);"></p>
        </footer>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="remarksModal" style="padding:0px 0px;margin:200px 0px;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:rgb(255,0,0);width:298px;margin:0px 0px;height:30px;padding:2px 2px;">
                    <h5 class="modal-title" style="color:rgb(0,255,255);margin:-2px 4px;">Add Remarks</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body" style="height:102px;"><textarea style="font-size:12px;padding:0px;width:256px;height:70px;" maxlength="95"></textarea></div>
                <div class="modal-footer" style="height:35px;"><button class="btn btn-light btn-sm" type="button" data-dismiss="modal" style="height:23px;width:50px;margin:0px 0px;padding:0px 0px;">Close</button><button class="btn btn-primary btn-sm" id="remarksSave" type="button" style="height:23px;padding:0px 0px;margin:0px 10px;width:45px;font-size:12px;">Save</button></div>
            </div>
        </div>
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
    <div class="modal fade" role="dialog" tabindex="-1" id="forwardDoc" style="padding:0px 0px;margin:200px 0px;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:rgb(255,0,0);width:298px;margin:0px 0px;height:30px;padding:2px 2px;">
                    <h5 class="modal-title" style="color:rgb(0,255,255);margin:-2px 4px;">Forward Document</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body" style="width:273px;">
                    <div class="row">
                        <div class="col-auto" style="padding:0px 0px;"><label class="col-form-label" style="font-size:12px;">Please select department:</label><select style="font-size:12px;margin:0px 5px;"><optgroup label=""><option value="12" selected=""></option><option value="13">SGOD-P&amp;R</option><option value="14">CID-ALS</option></optgroup></select></div>
                    </div>
                </div>
                <div class="modal-footer" style="height:35px;"><button class="btn btn-light btn-sm" type="button" id="mForwardClose" data-dismiss="modal" style="height:23px;width:50px;margin:0px 0px;padding:0px 0px;">Close</button><button class="btn btn-success btn-sm" type="button" id="mForward"
                        style="height:23px;padding:0px 0px;margin:0px 10px;width:57px;font-size:12px;">Forward</button></div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap.min.js"></script>

    <script src="../j_js/menu-visibility.js"></script>
    <script src="../j_js/docprocessing.js"></script>

    <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
</body>

</html>