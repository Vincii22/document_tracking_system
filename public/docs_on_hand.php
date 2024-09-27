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
    <a href="dashboard.php"><i class="fa fa-tasks"></i> Dashboard</a>
    <a href="profile.php"><i class="fa fa-tasks"></i> Profile </a>
    <a href="add_document.php"><i class="fa fa-file-o"></i> Add Document</a>
    <a href="docs_on_hand.php" class="active"><i class="fa fa-tasks"></i> Process Document</a>
    <a href="track_doc.php"><i class="fa fa-search"></i> Track Document</a>
    <a href="mgmt/doc_mgmt.php"><i class="fa fa-list"></i> Document List</a>
    <a href="mastermind/user_mgmt.php"><i class="fa fa-users"></i> User Management</a>
    <a href="mastermind/dept_mgmt.php"><i class="fa fa-building"></i> Department Management</a>
</div>
<div>
<nav class="navbar navbar-expand-md navigation-clean-button">
    <div class="container">
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
</nav>
</div>

<div style="font-size:10px;">
    <div class="container" style="width:1191px;">
        <div class="row" style="padding:0px;margin:0px;height:51px;width:929px;">
            <div class="col-9" style="margin:20px 0px;height:32px;">
                <h4 style="color:rgb(134,142,150);padding:0px 120px;width:476px;">Process Documents</h4>
            </div>
            <div class="col-3" style="margin:20px 0px;height:32px;">
                <input class="visible" type="text" id="doc_search" placeholder="Search Documents" style="width:150px;height:35px;font-size:12px;" autocomplete="off">
            </div>
        </div>
        <div class="row" style="width:1100px;font-size:12px;height:504px;padding:0px 0px;margin:0px 0px;">
            <div class="col-auto my-auto" style="margin:0px;width:260px;height:449px;">
                <select multiple="" id="incomingList" style="height:460px;width:250px;">
                    <optgroup label="***INCOMING"></optgroup>
                </select>
            </div>
            <div class="col-auto" style="margin:0px 0px;width:80px;height:300px;padding:0px 0px;">
                <div class="row" id="incomingButtons" style="margin:140px 13px;">
                    <div class="col">
                        <button class="btn btn-success btn-sm" type="button" id="acceptIncoming" style="height:23px;padding:0px 0px;font-size:12px;margin:0px -8px;width:65px;">Accept</button>
                        <button class="btn btn-warning btn-lg" type="button" id="addIncomingRemarks" style="height:23px;padding:0px 0px;font-size:12px;background-color:rgb(225,33,33);margin:8px -8px;width:62px;" data-target="#remarksModal" data-toggle="modal">Remarks</button>
                    </div>
                </div>
            </div>
            <div class="col-auto my-auto" style="margin:19px;width:260px;height:449px;">
                <select multiple="" id="onQueueList" style="height:460px;width:250px;">
                    <optgroup label="***ON QUEUE"></optgroup>
                </select>
            </div>
            <div class="col-auto" style="margin:0px 0px;width:80px;height:449px;padding:0px 0px;">
                <div class="row" id="onQueueButtons" style="margin:140px 0px;">
                    <div class="col">
                        <button class="btn btn-success btn-sm" type="button" id="forward" style="height:23px;padding:0px 0px;font-size:12px;margin:6px -8px;width:65px;" data-target="#forwardDoc" data-toggle="modal">Forward</button>
                        <button class="btn btn-warning btn-lg" type="button" id="addOnQueueRemarks" style="height:23px;padding:0px 0px;font-size:12px;background-color:rgb(225,33,33);margin:3px -8px;width:62px;" data-target="#remarksModal" data-toggle="modal">Remarks</button>
                        <button class="btn btn-primary btn-lg" type="button" id="completed" style="height:23px;padding:0px 0px;font-size:12px;background-color:rgb(225,33,33);margin:6px -8px;width:73px;">Completed</button>
                        <button class="btn btn-danger btn-lg" type="button" id="cancel" style="height:23px;padding:0px 0px;font-size:12px;background-color:rgb(225,33,33);margin:3px -8px;width:51px;">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="col-auto my-auto" style="margin:19px;width:260px;height:449px;">
                <select multiple="" id="outgoingList" style="height:460px;width:250px;">
                    <optgroup label="***OUTGOING"></optgroup>
                </select>
            </div>
            <div class="col-auto" style="margin:0px 0px;width:80px;height:449px;padding:0px 0px;">
                <div class="row" id="outgoingButtons" style="margin:140px 5px;">
                    <div class="col">
                        <button class="btn btn-danger btn-sm" type="button" id="cancelForward" style="height:23px;padding:0px 0px;font-size:12px;margin:0px -8px;width:94px;">Cancel Forward</button>
                        <button class="btn btn-warning btn-lg" type="button" id="addOutgoingRemarks" style="height:23px;padding:0px 0px;font-size:12px;background-color:rgb(225,33,33);margin:8px -8px;width:62px;" data-target="#remarksModal" data-toggle="modal">Remarks</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" tabindex="-1" id="remarksModal" style="padding:0px 0px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="remarksModalLabel">Remarks</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea id="remarks" placeholder="Enter remarks..." style="width: 100%; height: 150px;"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="saveRemarks" type="button">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" tabindex="-1" id="forwardDoc" style="padding:0px 0px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forwardDocLabel">Forward Document</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select id="forwardTo" style="width: 100%;">
                    <option value="" disabled selected>Select User</option>
                    <!-- Options will be populated dynamically -->
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="saveForward" type="button">Forward</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/Chart.min.js"></script>
<script src="assets/js/bs-init.js"></script>
<script src="assets/js/Data-Table.js"></script>
<script src="assets/js/Data-Table2.js"></script>
<script src="assets/js/DocumentTracking.js"></script>
<script src="assets/js/DocumentTracking2.js"></script>
<script src="assets/js/docs_on_hand.js"></script>
<script src="assets/js/docs_on_hand2.js"></script>
</body>
</html>
