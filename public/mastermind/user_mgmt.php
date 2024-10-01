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
    else if ($_SESSION['usertype'] != 'admin') {
        redirect_to('../unauthorized.php'); // Redirect non-admin users to an unauthorized page
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
    <link rel="stylesheet" href="../assets/css/nav.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<!-- Add Custom CSS for Modal Width -->
<style>
 /* Adjust the width of the modal */
 .modal-full {
        max-width: 50%; /* Changed to 70% */
    }

    /* Center the modal both vertically and horizontally */
    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        height: 100%; /* To ensure the modal is centered */
    }

</style>
<body style="height:650px;">
<!-- Sidebar -->
<div class="sidebar">
        <div class="sidenav-profile-container">
            <img src="<?php echo !empty($user_data['user_image']) ? $user_data['user_image'] : 'assets/images/default-profile.jpg'; ?>" alt="Profile Image" width="100" style="border-radius: 50%; border-width: 5px; border-style:  solid; border-color: white #0b71e7 white  #0b71e7;">
            <a class="nav-link" href="#" data-id="<?php echo $_SESSION['user_id']?>" data-utype="<?php echo $_SESSION['usertype']?>" data-dept="<?php echo $_SESSION['dept_id']?>" id="usernameHolder">
                </i> <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>
            </a>
            <p data-id="<?php echo $_SESSION['user_id']?>" data-utype="<?php echo $_SESSION['usertype']?>" data-dept="<?php echo $_SESSION['dept_id']?>" id="usernameHolder">
                </i> <?php echo $_SESSION['usertype']; ?>
            </p>
        </div>
        <div class="sidenav-links">
        <?php if ($_SESSION['usertype'] != 'admin'): ?>
            <a href="../dashboard.php"><i class="fa fa-tasks"></i> Dashboard</a>
            <a href="../profile.php"><i class="fa fa-tasks"></i> Profile </a>
            <a href="../add_document.php"><i class="fa fa-file-o"></i> Add Document</a>
            <a href="../docs_on_hand.php"><i class="fa fa-tasks"></i> Process Document</a>
            <a href="../track_doc.php"><i class="fa fa-search"></i> Track Document</a>
            <a href="../mgmt/doc_mgmt.php" class="active"><i class="fa fa-list"></i> Document List</a>
        <?php endif; ?>
            <?php if ($_SESSION['usertype'] == 'admin'): ?>
            <a href="user_mgmt.php" class="active"><i class="fa fa-users"></i> User Management</a>
            <a href="dept_mgmt.php"><i class="fa fa-building"></i> Department Management</a>
        <?php endif; ?>
        </div>
        <div class="log-out">
            <a class="nav-link text-white" href="../logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </div>

    </div>
<!-- Navbar -->
<nav class="navbar navbar-expand-md">
        <div class="container">

            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php"><i class="fa fa-bell"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle nav-link text-white" data-toggle="dropdown" aria-expanded="false" href="#" data-id="<?php echo $_SESSION['user_id']?>" data-utype="<?php echo $_SESSION['usertype']?>" data-dept="<?php echo $_SESSION['dept_id']?>" id="usernameHolder">
                        <i class="fa fa-user"></i>&nbsp; <?php echo $_SESSION['username']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a class="dropdown-item" role="presentation" href="#" id="changePassword" data-target="#editPassword" data-toggle="modal">Change Password</a>
                        <a class="dropdown-item" role="presentation" href="../logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
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

<div class="modal fade" role="dialog" tabindex="-1" id="editModal" style="padding:0px 0px;margin:0;">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add/Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="username">Username:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" id="username" class="form-control" placeholder="Enter username">
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="password1">Enter Password:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" id="password1" class="form-control" placeholder="Enter password">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="password2">Reenter Password:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" id="password2" class="form-control" placeholder="Reenter password">
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="lastname">Last Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            </div>
                            <input type="text" id="lastname" class="form-control" placeholder="Enter last name">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="firstname">First Name:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" id="firstname" class="form-control" placeholder="Enter first name">
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="user_image">User Image:</label>
                        <input type="file" id="user_image" name="user_image" accept="image/*" class="form-control-file">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="dept">Department:</label>
                        <select id="dept" class="form-control">
                            <optgroup label="Units/Departments"></optgroup>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="usertype">Usertype:</label>
                        <select id="usertype" class="form-control">
                            <optgroup label="Usertypes">
                                <option value="1">Admin</option>
                                <option value="2">Dean</option>
                                <option value="3">Assistant</option>
                                <option value="4">Student Assistant</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" id="saveUser">Save</button>
            </div>
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