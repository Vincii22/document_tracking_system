<?php 
require_once("../includes/initialize.php"); 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect_to('login.php');
}

$user_id = $_SESSION['user_id'];

// Fetch the logged-in user's details including their dept_id
$user_query = "SELECT u.dept_id, u.usertype FROM users u WHERE u.user_id = ?"; 
$stmt = $database->prepare($user_query);
$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

$stmt->bind_result($dept_id, $usertype); 
$stmt->fetch();
$stmt->close();

// Fetch the dept_abbreviation using the dept_id
$dept_abbr_query = "SELECT d.dept_abbreviation FROM departments d WHERE d.dept_id = ?";
$dept_stmt = $database->prepare($dept_abbr_query);
$dept_stmt->bind_param("i", $dept_id);

if (!$dept_stmt->execute()) {
    die('Execute failed: ' . htmlspecialchars($dept_stmt->error));
}

$dept_stmt->bind_result($dept_abbreviation); 
$dept_stmt->fetch();
$dept_stmt->close();

// Redirect guests
if (isset($usertype) && $usertype === 'guest') {
    redirect_to('track_doc.php');
}

// Fetch users based on department and user type
$users = User::find_all_by_dept_and_type($dept_id, $usertype);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dts-Add Document</title>
    
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css">
    <link rel="stylesheet" href="assets/css/Data-Table2.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/nav.css">
</head>

<body style="height:100vh; background-color: #f8f9fa;">
<div class="sidebar">
    <img src="assets/images/divineLogo.jpg" alt="Document Tracking System Logo" style="width: 100%; height: auto; margin-bottom: 20px;">
    <a href="dashboard.php"><i class="fa fa-tasks"></i> Dashboard</a>
    <a href="profile.php"><i class="fa fa-tasks"></i> Profile </a>
    <a href="add_document.php" class="active"><i class="fa fa-file-o"></i> Add Document</a>
    <a href="docs_on_hand.php"><i class="fa fa-tasks"></i> Process Document</a>
    <a href="track_doc.php"><i class="fa fa-search"></i> Track Document</a>
    <a href="mgmt/doc_mgmt.php"><i class="fa fa-list"></i> Document List</a>
<<<<<<< HEAD
    <?php if ($_SESSION['usertype'] == 'admin'): ?>
        <a href="mastermind/user_mgmt.php"><i class="fa fa-users"></i> User Management</a>
        <a href="mastermind/dept_mgmt.php"><i class="fa fa-building"></i> Department Management</a>
    <?php endif; ?>
=======
    <a href="mastermind/user_mgmt.php"><i class="fa fa-users"></i> User Management</a>
    <a href="mastermind/dept_mgmt.php"><i class="fa fa-building"></i> Department Management</a>
>>>>>>> main
</div>

<nav class="navbar navbar-expand-md navigation-clean-button">
    <div class="container">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navcol-1" aria-controls="navcol-1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown dts_all">
                    <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">Documents</a>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" role="presentation" href="add_document.php">Add Document</a>
                        <a class="dropdown-item" role="presentation" href="docs_on_hand.php">Process Document</a>
                        <a class="dropdown-item" role="presentation" href="track_doc.php">Track Document</a>
                        <a class="dropdown-item" role="presentation" href="mgmt/doc_mgmt.php">Document List</a>
                    </div>
                </li>
                <li class="nav-item dropdown dts_a">
                    <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">Key Elements</a>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" role="presentation" href="mastermind/user_mgmt.php">User Mgmt</a>
                        <a class="dropdown-item" role="presentation" href="mastermind/dept_mgmt.php">Dept Mgmt</a>
                    </div>
                </li>
                <li class="nav-item dts_am">
                    <a class="nav-link active" href="#">Analytics</a>
                </li>
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

<div class="container my-5">
    <h4 class="text-center mb-4">Add Document</h4>
    <form id="documentForm" action="../j_php/document_add.php" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: auto;">
        <input type="hidden" name="docowner" value="soecs">
        <input type="hidden" name="personnel_id" value="<?php echo $user_id; ?>">

        <div class="form-group">
            <label for="docName">Document Name:</label>
            <input class="form-control" type="text" id="docName" name="docname" required>
        </div>

        <div class="form-group">
            <label for="docType">Document Type:</label>
            <select class="form-control" id="docType" name="doctype" required>
                <option value="1">Request</option>
                <option value="2">For Processing</option>
                <option value="3">Submission</option>
                <option value="4">Communication</option>
            </select>
        </div>

        <div class="form-group">
            <label for="contactNum">Contact Number:</label>
            <input class="form-control" type="number" name="mobilenum" minlength="10" maxlength="10" id="contactNum" required>
        </div>

        <div class="form-group">
            <label for="docfile">Upload Document:</label>
            <input class="form-control" type="file" name="docfile" required>
        </div>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Add Document</button>
        </div>
    </form>
</div>

<div class="modal fade" role="dialog" tabindex="-1" id="editPassword" style="padding:0px 0px;margin:200px 0px;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:rgb(255,0,0);">
                <h5 class="modal-title" style="color:rgb(0,255,255);">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col"><small style="color:rgb(255,0,0); display:none">Password was updated successfully.</small></div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <label class="col-form-label">Enter Password:</label>
                        <input type="password" id="mPassword1">
                    </div>
                    <div class="col-auto">
                        <label class="col-form-label">Reenter Password:</label>
                        <input type="password" id="mPassword2">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light btn-sm" type="button" id="mPasswordClose" data-dismiss="modal">Close</button>
                <button class="btn btn-primary btn-sm" type="button"
                id="mPasswordSave">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap.min.js"></script>
<script src="../j_js/menu-visibility.js"></script>
</body>
</html>
