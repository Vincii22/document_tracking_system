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
    <title>dts-Success!!! Add Document</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Data-Table2.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/nav.css?v=<?php echo time(); ?>">

    <style>
        .check-container {
            width: 100px;
            height: 100px;
            position: relative;
            border: 5px solid #0b71e7;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .checkmark {
            width: 40px;
            height: 50px;
            transform: rotate(45deg);
            opacity: 0;
        }

        .checkmark::before, .checkmark::after {
            content: '';
            position: absolute;
            background-color: #0b71e7;
            border-radius: 3px;
            transition: all 0.4s ease;
        }

        .checkmark::before {
            width: 8px;
            height: 40px;
            left: 17px;
            top: -2px;
            transform-origin: bottom left;
            transform: scaleY(0);
            transition-delay: .5s;
        }

        .checkmark::after {
            width: 20px;
            height: 8px;
            left: 0;
            top: 30px;
            transform-origin: top left;
            transform: scaleX(0);
        }

        .checkmark.active {
            opacity: 1;
        }

        .checkmark.active::before {
            transform: scaleY(1);
        }

        .checkmark.active::after {
            transform: scaleX(1);
        }
    </style>
    <script>
window.onload = function() {
    // Trigger the checkmark animation when the page loads
    const checkmark = document.querySelector('.checkmark');
    checkmark.classList.add('active');

    // No reset: the checkmark will stay visible after the animation
};
    </script>
</head>

<body style="height:650px;">
    <div>
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
            <a href="dashboard.php" ><i class="fa fa-tasks"></i> Dashboard</a>
            <a href="profile.php" class="active"><i class="fa fa-tasks"></i> Profile </a>
            <a href="add_document.php"><i class="fa fa-file-o"></i> Add Document</a>
            <a href="docs_on_hand.php"><i class="fa fa-tasks"></i> Process Document</a>
            <a href="track_doc.php"><i class="fa fa-search"></i> Track Document</a>
            <a href="mgmt/doc_mgmt.php"><i class="fa fa-list"></i> Document List</a>
            <?php if ($_SESSION['usertype'] == 'admin'): ?>
            <a href="mastermind/user_mgmt.php"><i class="fa fa-users"></i> User Management</a>
            <a href="mastermind/dept_mgmt.php"><i class="fa fa-building"></i> Department Management</a>
        <?php endif; ?>
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
    </div>
    <div style="font-size:10px; border-radius: 12px; margin: 20px 25px 25px 250px !important; ; min-height: 70vh;">
        <div class="bread-crums" style="background-color: white; padding: 20px; margin-bottom: 20px;">
            <a href="add_document.php" class="" style="font-size: 16px; color: black;">Add another document /</a>
            
            <a href="#" class="" style="font-size: 16px; color: blue;">Added Successfully </a>
        </div>
        <div class="container " style="max-width: 100% !important; background-color: white; padding: 20px; ">
            <div class="" style="display: flex; justify-content: center; align-items: center;">
            <div class="check-container">
                <div class="checkmark"></div>
            </div>
            </div>
            <div class="row" style="padding:0px;margin:7px;height:40px;"></div>
            <div class="no-gutters" style="text-align: center;">
                <div class="col-auto" style="margin:19px;">
                    <form style="text-align: center;">
                        <h4 style="color:rgb(134,142,150);">You've successfully added a document.</h4>
                        <h4 id="docTrackHolder" data-tracking="<?php echo $_GET['tracking']; ?>" style="color:rgb(134,142,150);">Your document tracking number is&nbsp;<?php echo $_GET['tracking']; ?></h4>
                    </form>
                </div>
            </div>
            <div class="" style="padding:0px;margin:7px;">
                <div class="col" style=" display: flex; justify-content: center; gap: 10px;"><button class="btn btn-primary btn-sm" type="button" id="printReceipt" style="padding:5px 15px 5px 15px;font-size:15px;margin:10px;">Print</button><a href="add_document.php" class="btn btn-success btn-sm" style="padding:5px 15px 5px 15px;font-size:15px;margin:10px;">Add another document</a></div>
            </div>
        </div>
        <div class="footer-basic fixed-bottom" style="border-top:2px solid black;height:42px;margin-left:250px; margin-right: 25px;padding:0px 0px; background-color: transparent;">
        <footer>
            <p class="copyright" style="color: black;">DWCL Document Tracking System © 2024</p>
        </footer>
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
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap.min.js"></script>

    <script src="../j_js/document-add.js"></script>
    <script src="../j_js/menu-visibility.js"></script>
</body>

</html>