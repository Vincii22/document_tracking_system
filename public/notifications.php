<?php
require_once("../includes/initialize.php");

// Ensure the user is logged in
if (!isset($_SESSION['usertype'])) {
    redirect_to('login.php');
}

// Fetch notifications for the logged-in user
$user_id = $_SESSION['user_id'];
$notification_query = "SELECT * FROM notifications WHERE user_id = '{$user_id}' ORDER BY created_at DESC";
$notification_result = $database->query($notification_query);
$notifications = [];

// Mark notifications as read when fetched
$update_query = "UPDATE notifications SET status = 'READ' WHERE user_id = '{$user_id}' AND status = 'UNREAD'";
$database->query($update_query);

while ($row = $database->fetch_array($notification_result)) {
    $notifications[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/nav.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap.min.js"></script>
    <style>
        table.dataTable tbody tr.selected {
            background-color: #f1f1f1; /* Optional: highlight selected row */
        }
        table {
    width: 100%; /* Ensure the table takes full width of the container */
    table-layout: fixed; /* Prevent flexing of the table */
}

.table-responsive {
    overflow-x: auto; /* Allow horizontal scrolling if needed */
}

.dataTables_wrapper {
    width: 100%; /* Make sure the wrapper takes the full width */
    overflow: auto; /* Allow scrolling for pagination */
}
.dataTables_wrapper .dataTables_paginate {
    display: flex; /* Use flexbox for alignment */
    justify-content: center; /* Center align pagination */
    margin-top: 20px; /* Add space above pagination */
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.5em 1em; /* Padding for buttons */
    margin: 0 0.2em; /* Space between buttons */
    border-radius: 4px; /* Rounded corners */
    border: 1px solid #007bff; /* Border color */
    background-color: #ffffff; /* Background color */
    color: #007bff; /* Text color */
    transition: background-color 0.3s; /* Smooth background color change */
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background-color: #007bff; /* Background on hover */
    color: white; /* Text color on hover */
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background-color: #007bff; /* Background for the current page */
    color: white; /* Text color for the current page */
}
    </style>
</head>
<body>
<div class="sidebar">
    <div class="sidenav-profile-container">
        <img src="<?php echo !empty($user_data['user_image']) ? $user_data['user_image'] : 'assets/images/default-profile.jpg'; ?>" alt="Profile Image" width="100" style="border-radius: 50%; border-width: 5px; border-style: solid; border-color: white #0b71e7 white #0b71e7;">
        <a class="nav-link" href="#" data-id="<?php echo $_SESSION['user_id']?>" data-utype="<?php echo $_SESSION['usertype']?>" data-dept="<?php echo $_SESSION['dept_id']?>" id="usernameHolder">
            <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>
        </a>
        <p data-id="<?php echo $_SESSION['user_id']?>" data-utype="<?php echo $_SESSION['usertype']?>" data-dept="<?php echo $_SESSION['dept_id']?>" id="usernameHolder">
            <?php echo $_SESSION['usertype']; ?>
        </p>
    </div>
    <div class="sidenav-links">
        <?php if ($_SESSION['usertype'] != 'admin'): ?>
            <a href="dashboard.php"><i class="fa fa-tasks"></i> Dashboard</a>
            <a href="profile.php"><i class="fa fa-tasks"></i> Profile </a>
            <a href="add_document.php"><i class="fa fa-file-o"></i> Add Document</a>
            <a href="docs_on_hand.php" class="active"><i class="fa fa-tasks"></i> Process Document</a>
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
<!-- content  -->
<div class="container">
    <h2>Notifications</h2>
    <table id="notificationsTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Message</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notifications as $notification): ?>
                <tr>
                    <td><?php echo $notification['message']; ?></td>
                    <td><?php echo date('Y-m-d h:i A', strtotime($notification['created_at'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
<script>
      $(document).ready(function() {
        $('#notificationsTable').DataTable({
            "pageLength": 10, // Show 10 entries by default
            "lengthMenu": [6, 10, 25, 50], // Options for entries per page
            "order": [[1, 'desc']], // Sort by 'Created At' column in descending order
            "language": {
                "emptyTable": "No notifications available."
            }
        });
    });
</script>
</body>
</html>
