<?php require_once("../../includes/initialize.php");

if (!isset($_SESSION['usertype'])) {
    redirect_to('../login.php');
} else {
    if ($_SESSION['usertype'] == 'guest') {
        redirect_to('../track_doc.php');
    } else if ($_SESSION['usertype'] == 'user') {
        redirect_to('../docs_on_hand.php');
    }    else if ($_SESSION['usertype'] == 'student assistant') {
        redirect_to('../unauthorized.php'); // Redirect non-admin users to an unauthorized page
    }

}
// Assuming you have a way to retrieve user data
$user_id = $_SESSION['user_id'];
$user_query = "SELECT user_image FROM users WHERE user_id = '{$user_id}' LIMIT 1"; // Update table name if necessary
$user_result = $database->query($user_query);
$user_data = $database->fetch_array($user_result);

// Check if the user image is set and accessible
$user_image = !empty($user_data['user_image']) ? $user_data['user_image'] : '../assets/images/default-profile.jpg';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dts-Doc MGMT</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/Data-Table.css">
    <link rel="stylesheet" href="../assets/css/Data-Table2.css">
    <link rel="stylesheet" href="../assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="../assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/nav.css?v=<?php echo time(); ?>">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .profile-container {
            margin-left: 270px;
            margin-top: 50px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-right: 30px;
        }

        .profile-details h2 {
            font-size: 36px;
            color: #343a40;
        }

        .profile-details p {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 8px;
        }

        .profile-footer {
            margin-top: 30px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-footer p {
            font-size: 16px;
            color: #343a40;
        }

        div {
            margin: 0 !important;
        }

        .table-container-box {
            margin-left: 240px !important;
            margin-top: 20px !important;
        }

        .table-container {
            width: 100%;
            max-width: 83vw;
            background-color: #ffffff;
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
            padding: 20px; 
        }

        .table th, .table td {
            vertical-align: middle; 
        }

        .table thead {
            background-color: #007bff; 
            color: #ffffff;
        }

        .table th {
            font-weight: bold; 
        }

        .table-responsive {
            margin-top: 10px !important; 
        }

    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidenav-profile-container">
        <img src="<?php echo !empty($user_data['user_image']) ? $user_data['user_image'] : '../assets/images/default-profile.jpg'; ?>" alt="Profile Image" width="100" style="border-radius: 50%; border-width: 5px; border-style:  solid; border-color: white #0b71e7 white  #0b71e7;">
            <!-- <img src="assets/images/default-profile.jpg" alt="Profile Image" width="100"> -->
            <a class="nav-link" href="#" data-id="<?php echo $_SESSION['user_id'] ?>"
                data-utype="<?php echo $_SESSION['usertype'] ?>" data-dept="<?php echo $_SESSION['dept_id'] ?>"
                id="usernameHolder">
                </i> <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>
            </a>
            <p data-id="<?php echo $_SESSION['user_id'] ?>" data-utype="<?php echo $_SESSION['usertype'] ?>"
                data-dept="<?php echo $_SESSION['dept_id'] ?>" id="usernameHolder">
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
                <a href="../mastermind/user_mgmt.php"><i class="fa fa-users"></i> User Management</a>
                <a href="../mastermind/dept_mgmt.php"><i class="fa fa-building"></i> Department Management</a>
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
                    <a class="dropdown-toggle nav-link text-white" data-toggle="dropdown" aria-expanded="false" href="#"
                        data-id="<?php echo $_SESSION['user_id'] ?>" data-utype="<?php echo $_SESSION['usertype'] ?>"
                        data-dept="<?php echo $_SESSION['dept_id'] ?>" id="usernameHolder">
                        <i class="fa fa-user"></i>&nbsp; <?php echo $_SESSION['username']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a class="dropdown-item" role="presentation" href="#" id="changePassword"
                            data-target="#editPassword" data-toggle="modal">Change Password</a>
                        <a class="dropdown-item" role="presentation" href="../logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    </div>

    <div class="table-container-box">
        <div class="table-container">
            <h4 style="color: rgb(134,142,150); line-height: 70px">Document Management</h4>
            <div class="row" style="padding:0px;margin:7px;">
                <div class="col">
                    <select class="form-control-sm" id="viewSelect" style="font-size:12px;height:33px;">
                        <option value="0" selected disabled hidden>View Options</option>
                        <option value="0">View All</option>
                        <option value="1">View Waiting</option>
                        <option value="2">View In Transit</option>
                        <option value="3">View Cancelled</option>
                        <option value="4">View Completed</option>
                    </select>
                </div>

                <div class="col-2">
                    <input class="visible" type="text" id="doc_search" placeholder="Search Documents" style="width:150px;height:35px;font-size:12px;">
                </div>
                
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <div id="tableHolder" class="row no-gutters" style="">
                    </div>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="editPassword" style="padding:0px 0px;margin:200px 0px;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header"
                    style="background-color:rgb(255,0,0);width:298px;margin:0px 0px;height:30px;padding:2px 2px;">
                    <h5 class="modal-title" style="color:rgb(0,255,255);margin:-2px 4px;">Change Password</h5><button
                        type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" style="width:273px;">
                    <div class="row">
                        <div class="col"><small style="color:rgb(255,0,0); display:none">Password was updated
                                successfully.</small></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;"><label class="col-form-label"
                                style="font-size:12px;">Enter Password:</label><input type="password" id="mPassword1"
                                style="font-size:12px;margin:0px 21px;"></div>
                        <div class="col-auto" style="margin:0px 0px;"><label class="col-form-label"
                                style="font-size:12px;">Reenter Password:&nbsp;</label><input type="password"
                                id="mPassword2" style="font-size:12px;margin:5px;"></div>
                    </div>
                </div>
                <div class="modal-footer" style="height:35px;"><button class="btn btn-light btn-sm" type="button"
                        id="mPasswordClose" data-dismiss="modal"
                        style="height:23px;width:50px;margin:0px 0px;padding:0px 0px;">Close</button><button
                        class="btn btn-primary btn-sm" type="button" id="mPasswordSave"
                        style="height:23px;padding:0px 0px;margin:0px 10px;width:45px;font-size:12px;">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap.min.js"></script>

    <script src="../../j_js/docmgmt.js"></script>
    <script src="../../j_js/menu-visibility.js"></script>
</body>

</html>
