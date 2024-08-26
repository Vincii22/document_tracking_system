<?php require_once("../../includes/initialize.php"); 
 
if(!isset($_SESSION['usertype'])) {
    redirect_to('../login.php');
} else {
    if ($_SESSION['usertype'] == 'guest' ) {
        redirect_to('../track_doc.php');
    }
    else if ($_SESSION['usertype'] == 'user' ) {
        redirect_to('../docs_on_hand.php');
    }
    else if ($_SESSION['usertype'] == 'mgmt' ) {
        redirect_to('../mgmt/doc_mgmt.php');
    }
    
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dts-User MGMT</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Data-Table.css">
    <link rel="stylesheet" href="../assets/css/Data-Table2.css">
    <link rel="stylesheet" href="../assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
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
                                <a class="dropdown-item dts_uam" role="presentation" href="../add_document.php">Add Document</a>
                                <a class="dropdown-item dts_uam" role="presentation" href="../docs_on_hand.php">Process Document</a>
                                <a class="dropdown-item dts_all" role="presentation" href="../track_doc.php">Track Document</a>
                                <a class="dropdown-item dts_am" role="presentation" href="../mgmt/doc_mgmt.php">Document List</a></div>
                        </li>
                        <li class="dropdown dts_a">
                                <a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color:rgb(255,255,255);">Key Elements</a>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" role="presentation" href="user_mgmt.php">User Mgmt</a>
                                <a class="dropdown-item" role="presentation" href="dept_mgmt.php">Dept Mgmt</a></div>
                        </li>
                        <li class="nav-item dts_am" role="presentation"><a class="nav-link active" href="#" style="color:rgb(255,255,255);">Analytics</a></li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="dropdown"><a class="dropdown-toggle nav-link text-white dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#" data-id="<?php echo $_SESSION['user_id']?>" data-utype="<?php echo $_SESSION['usertype']?>" data-dept="<?php echo $_SESSION['dept_id']?>" id="usernameHolder" style="color:rgb(255,255,255);"><i class="fa fa-user"></i>&nbsp; 
                        <?php echo $_SESSION['username']; ?> 
                        </a>
                            <div class="dropdown-menu dropdown-menu-right"
                                role="menu"><a class="dropdown-item" role="presentation" href="#" id="changePassword" data-target="#editPassword" data-toggle="modal">Change Password</a><a class="dropdown-item" role="presentation" href="../logout.php">Logout</a></div>
                        </li>
                    </ul>
            </div>
    </div>
    </nav>
    </div>
    <div style="font-size:10px;">
        <div class="container">
            <div class="row" style="padding:0px;margin:7px;">
                <div class="col">
                    <h4 style="color:rgb(134,142,150);">User Management</h4>
                </div>
            </div>
            <div class="row" style="padding:0px 30px;">
                <div class="col-auto" style="width:78px;"><button class="btn btn-success btn-sm" type="button" id="addUser" style="height:23px;padding:-4px;font-size:10px;width:67px;" data-target="#editModal" data-toggle="modal">Add User</button></div>
                <div class="col"><input type="text" placeholder="Search Users" id="searchUser" style="width:150px;height:25px;font-size:12px;"></div>
            </div>
            <div id="tableArea" class="row no-gutters">
                
                        
           
                              
                        
            </div>
        </div>
    </div>
    <div class="footer-basic fixed-bottom" style="height:42px;margin:0px;padding:0px 0px;background-color:rgb(255,0,0);">
        <footer>
            <p class="copyright" style="color:rgb(255,255,255);">jkiqui-dts-v1 © 2018</p>
        </footer>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="editModal" style="padding:0px 0px;margin:100px 0px;height:375px;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:rgb(255,0,0);width:298px;margin:0px 0px;height:30px;padding:2px 2px;">
                    <h5 class="modal-title" style="color:rgb(0,255,255);margin:-2px 4px;">Add/Edit User</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body" style="width:273px;">
                <div class="row">
                        <div class="col"><small style="color:rgb(255,0,0); "></small></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;padding:0px 5px;"><label class="col-form-label" style="font-size:12px;width:98px;">Username:</label><input type="text" id="username" style="font-size:12px;width:160px;margin:0px 3px;"></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;padding:0px 5px;"><label class="col-form-label" style="font-size:12px;width:98px;">Enter Password:</label><input type="password" id="password1" style="width:160px;margin:0px 3px;font-size:12px;"></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;padding:0px 5px;"><label class="col-form-label" style="font-size:12px;width:98px;">Reenter Password:</label><input type="password" id="password2" style="width:160px;margin:0px 3px;font-size:12px;"></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;padding:0px 5px;"><label class="col-form-label" style="font-size:12px;width:98px;">Last Name:</label><input type="text" id="lastname" style="font-size:12px;width:160px;margin:0px 3px;"></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;padding:0px 5px;"><label class="col-form-label" style="font-size:12px;width:98px;">First Name:</label><input type="text" id="firstname" style="font-size:12px;width:160px;margin:0px 3px;"></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;padding:0px 5px;font-size:12px;"><label class="col-form-label" style="font-size:12px;width:98px;">Department:</label><select id="dept" style="height:24px;margin:0px 3px;width:160px;"><optgroup label="Units/Departments"></optgroup></select></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;padding:0px 5px;font-size:12px;"><label class="col-form-label" style="font-size:12px;width:98px;">Usertype:</label><select id="usertype" style="height:24px;margin:0px 3px;width:160px;"><optgroup label="Usertypes"><option value="1">Mastermind</option><option value="2">Management</option><option value="3">User</option><option value="4">Guest</option></optgroup></select></div>
                    </div>
                </div>
                <div class="modal-footer" style="height:35px;"><button class="btn btn-light btn-sm" type="button" id="close" data-dismiss="modal" style="height:23px;width:50px;margin:0px 0px;padding:0px 0px;">Close</button><button class="btn btn-primary btn-sm" type="button" id="saveUser" style="height:23px;padding:0px 0px;margin:0px 10px;width:45px;font-size:12px;">Save</button></div>
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
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap.min.js"></script>

    <script src="../../j_js/menu-visibility.js"></script>
    <script src="../../j_js/user.js"></script>
</body>

</html>