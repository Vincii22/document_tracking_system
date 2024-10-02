<?php 
require_once("../includes/initialize.php"); 

// Ensure user is logged in and has the correct permissions
if (!isset($_SESSION['usertype'])) {
    redirect_to('login.php');
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/nav.css?v=<?php echo time(); ?>">
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

        
    </style>
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
            <a href="profile.php" class="active"><i class="fa fa-tasks"></i> Profile </a>
            <a href="add_document.php"><i class="fa fa-file-o"></i> Add Document</a>
            <a href="docs_on_hand.php"><i class="fa fa-tasks"></i> Process Document</a>
            <a href="track_doc.php"><i class="fa fa-search"></i> Track Document</a>
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

    <!-- Profile Container -->
    <div class="profile-container container">
        <div class="profile-header">
        <img src="<?php echo !empty($user_data['user_image']) ? $user_data['user_image'] : 'assets/images/default-profile.jpg'; ?>" alt="Profile Image">
            <div class="profile-details">
                <h2><?php echo $user_data['first_name'] . ' ' . $user_data['last_name']; ?></h2>
                <p><strong>Username:</strong> <?php echo $user_data['username']; ?></p>
                <p><strong>Department:</strong> <?php echo $user_data['dept_abbreviation']; ?></p>
                <p><strong>Position:</strong> <?php echo ucfirst($user_data['usertype']); ?></p>
            </div>
        </div>

        <!-- Profile Footer (Extra info, buttons, etc.) -->
        <div class="profile-footer">
            <p>Here you can add extra profile-related information or actions, such as updating details, uploading a new profile image, or changing settings.</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
