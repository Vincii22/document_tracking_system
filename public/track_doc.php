<?php require_once("../includes/initialize.php"); 

if(!isset($_SESSION['usertype'])) {
    redirect_to('login.php');
} else if ($_SESSION['usertype'] == 'student assistant') {
    redirect_to('./unauthorized.php'); // Redirect non-admin users to an unauthorized page
}

// Fetch the current user information
$user_id = $_SESSION['user_id'];
$query = "SELECT users.username, users.first_name, users.last_name, users.usertype, 
                 departments.dept_abbreviation, users.user_image
          FROM users 
          JOIN departments ON users.dept_id = departments.dept_id
          WHERE users.user_id = {$user_id}";

$result = $database->query($query);
$user_data = $database->fetch_array($result);

if (!$user_data) {
    echo "User data not found.";
    exit;
}

// Set session variables with fetched data
$_SESSION['first_name'] = $user_data['first_name'];
$_SESSION['last_name'] = $user_data['last_name'];
$_SESSION['username'] = $user_data['username'];
$_SESSION['usertype'] = $user_data['usertype'];
$_SESSION['dept_abbreviation'] = $user_data['dept_abbreviation'];


// Assuming you have a way to retrieve user data
$user_id = $_SESSION['user_id'];
$user_query = "SELECT user_image FROM users WHERE user_id = '{$user_id}' LIMIT 1"; // Update table name if necessary
$user_result = $database->query($user_query);
$user_data = $database->fetch_array($user_result);

// Check if the user image is set and accessible
$user_image = !empty($user_data['user_image']) ? $user_data['user_image'] : 'assets/images/default-profile.jpg';

$user_id = $_SESSION['user_id'];
$notification_query = "SELECT * FROM notifications WHERE user_id = '{$user_id}' AND status = 'UNREAD' ORDER BY created_at DESC";
$notification_result = $database->query($notification_query);
$notifications = [];
while ($row = $database->fetch_array($notification_result)) {
    $notifications[] = $row;
}

// Count unread notifications
$unread_count = count($notifications);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dts-Track Document</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Data-Table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Data-Table2.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/nav.css?v=<?php echo time(); ?>">
</head>

<body>
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
            <a href="dashboard.php"><i class="fa fa-tasks"></i> Dashboard</a>
            <a href="profile.php" ><i class="fa fa-tasks"></i> Profile </a>
            <a href="add_document.php"><i class="fa fa-file-o"></i> Add Document</a>
            <a href="docs_on_hand.php"><i class="fa fa-tasks"></i> Process Document</a>
            <a href="track_doc.php" class="active"><i class="fa fa-search"></i> Track Document</a>
            <a href="mgmt/doc_mgmt.php"><i class="fa fa-list"></i> Document List</a>
        <?php endif; ?>
            <?php if ($_SESSION['usertype'] == 'admin'): ?>
            <a href="mastermind/user_mgmt.php"><i class="fa fa-users"></i> User Management</a>
            <a href="mastermind/dept_mgmt.php"><i class="fa fa-building"></i> Department Management</a>
        <?php endif; ?>
        </div>
        <div class="log-out">
            <a class="nav-link text-white" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </div>

    </div>
 <!-- Navbar -->
 <nav class="navbar navbar-expand-md">
        <div class="container">

            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link text-white" href="notifications.php"><i class="fa fa-bell"></i>
                    <?php if ($unread_count > 0): ?>
                        <span class="badge badge-danger"><?php echo $unread_count; ?></span>
                    <?php endif; ?>
                </a>
            </li>
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
    <div style="font-size:10px; min-height: 90vh; padding-bottom: 20px; border-radius: 12px; margin: 20px 25px 25px 250px !important;">
        <div class="bread-crums" style="background-color: white; padding: 20px; margin-bottom: 20px;">
            <a href="dashboard.php" style="font-size: 16px; color: black;"> Dashboard /</a>
            <a href="#" class="" style="font-size: 16px; color: blue;">Track Document </a>
        </div>
    <div class="" style="min-height:65vh; height: fit-content; background-color: white; padding: 25px 20px">
        <form>
            <div class="d-flex" style=" justify-content:space-between; padding:0;margin:7px;">
                <div class="col-auto">
                    <input type="text" placeholder="Input Tracking Number" name="tracking" 
                           value="<?php if(isset($_GET['tracking'])) echo htmlspecialchars($_GET['tracking']); ?>" 
                           id="inputTracking" 
                           class="form-control form-control-sm" 
                           style="width: 565px; font-size:15px;">
                </div>
                <div class="col-auto">
                    <button class="btn btn-success btn-sm" type="submit" id="search" 
                            data-tracking="<?php if(isset($_GET['tracking'])) echo htmlspecialchars($_GET['tracking']); ?>" 
                            style="font-size:15px;">Search</button>
                </div>
            </div>
        </form>
        <div class="row no-gutters" style="padding: 25px 20px">
            <div class="col">
                <div class="table-responsive" style="font-size:14px;background-color:#ffffff;color:black;">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th style="width:185px;">Timestamp</th>
                                <th>Document Name</th>
                                <th>Document Movement</th>
                                <th style="width:381px;">Document Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="resultsTable">
                            <!-- Results will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="" style="font-size: 14px; text-align: center; margin-top: 20px !important; margin-bottom: 0 !important; border-top:2px solid black; margin-right: 25px;padding:0px 0px; background-color: transparent;">
            <footer>
                <p class="copyright" style="padding-top: 10px;color: black;">DWCL Document Tracking System © 2024</p>
            </footer>
        </div>
</div>


    <div class="modal fade" role="dialog" tabindex="-1" id="editPassword" style="padding:0px 0px;margin:200px 0px;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:rgb(255,0,0);width:298px;margin:0px 0px;height:30px;padding:2px 2px;">
                    <h5 class="modal-title" style="color:rgb(0,255,255);margin:-2px 4px;">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" style="width:273px;">
                    <div class="row">
                        <div class="col"><small style="color:rgb(255,0,0); display:none">Password was updated successfully.</small></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;">
                            <label class="col-form-label" style="font-size:12px;">Enter Password:</label>
                            <input type="password" id="mPassword1" style="font-size:12px;margin:0px 21px;">
                        </div>
                        <div class="col-auto" style="margin:0px 0px;">
                            <label class="col-form-label" style="font-size:12px;">Reenter Password:&nbsp;</label>
                            <input type="password" id="mPassword2" style="font-size:12px;margin:5px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="height:35px;">
                    <button class="btn btn-light btn-sm" type="button" id="mPasswordClose" data-dismiss="modal" style="height:23px;width:50px;margin:0px 0px;padding:0px 0px;">Close</button>
                    <button class="btn btn-primary btn-sm" type="button" id="mPasswordSave" style="height:23px;padding:0px 0px;margin:0px 10px;width:45px;font-size:12px;">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap.min.js"></script>
    <script src="../j_js/doctrack.js"></script>
    <script src="../j_js/menu-visibility.js"></script>
</body>

</html>
