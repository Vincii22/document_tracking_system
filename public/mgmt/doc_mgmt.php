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
$user_image = !empty($user_data['user_image']) ? $user_data['user_image'] : '../assets/images/default-profile.jpg';

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
    <title>dts-Doc MGMT</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/Data-Table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/Data-Table2.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/Footer-Basic.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/Navigation-with-Button.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/nav.css?v=<?php echo time(); ?>">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
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
                <a class="nav-link text-white" href="notifications.php"><i class="fa fa-bell"></i>
                    <?php if ($unread_count > 0): ?>
                        <span class="badge badge-danger"><?php echo $unread_count; ?></span>
                    <?php endif; ?>
                </a>
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
    <div style="font-size:10px; min-height: 90vh; padding-bottom: 20px; border-radius: 12px; margin: 20px 25px 25px 250px !important;">
        <div class="bread-crums" style="background-color: white; padding: 20px; margin-bottom: 20px !important;">
            <a href="dashboard.php" style="font-size: 16px; color: black;"> Dashboard /</a>
            <a href="#" class="" style="font-size: 16px; color: blue;">Track Document </a>
        </div>
        <div class="table-container" style="min-height:65vh; height: fit-content; background-color: white; padding: 25px 20px">
            <div class="row" style="padding:0px;margin:7px;">
                <div class="col">
                    <select class="form-control-sm" id="viewSelect" style="font-size:15px;height:33px;">
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
                    <div id="tableHolder" class="row no-gutters">
                    </div>
                </table>
            </div>
        </div>
</div>
<!-- Modal for viewing document details -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true" style="margin-left: 36vw !important">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Document Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="docName"></span></p>
                <p><strong>Owner:</strong> <span id="docOwner"></span></p>
                <p><strong>Type:</strong> <span id="docType"></span></p>
                <p><strong>File:</strong> <span id="docFile"></span></p>
                <p><strong>Date Started:</strong> <span id="docDateStarted"></span></p>
            </div>
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

    <script>
          // Event listener for viewing the document details
$("body").on("click", ".btn-view", function() {
    var docId = $(this).data('id'); // Get the document ID from the button's data-id attribute
    console.log("Selected Document ID:", docId); // Debugging

    // AJAX request to fetch document details
    $.ajax({
        url: '../../j_php/get_document_details.php',
        type: 'POST',
        data: { doc_id: docId }, // Send the document ID to the server
        success: function(response) {
            console.log("Response from server:", response); // Log response from the server
            try {
                var data = JSON.parse(response); // Parse the JSON response
                if (data.error) {
                    alert(data.error); // Show error message if exists
                } else {
                    // Populate the modal with the document details
                    $('#docName').text(data.doc_name);
                    $('#docOwner').text(data.doc_owner);
                    $('#docType').text(data.doc_type);
                    $('#docFile').html('<a href="' + data.doc_file + '" target="_blank">View File</a>');
                    $('#docDateStarted').text(data.date_started);

                    // Show the modal
                    $('#viewModal').modal('show');
                }
            } catch (e) {
                alert('Error parsing server response.'); // Handle parsing errors
                console.error('Parsing error:', e);
            }
        },
        error: function(xhr, status, error) {
            alert('Error fetching document details: ' + error); // Handle AJAX errors
        }
    });
});
    </script>
</body>

</html>
