<?php 
require_once("../includes/initialize.php"); 

// Ensure user is logged in and has the correct permissions
if (!isset($_SESSION['usertype'])) {
    redirect_to('login.php');
} else {
    if ($_SESSION['usertype'] == 'guest') {
        redirect_to('track_doc.php');
    }
}

// Check if the session has the department abbreviation
if (!isset($_SESSION['dept_abbreviation'])) {
    echo "Department abbreviation is missing in session.";
    exit;
}

$dept_abbreviation = $_SESSION['dept_abbreviation'];

// Query to get the document summary for the current department
$query = "SELECT 
             COUNT(doc_id) AS total_documents,
             SUM(CASE WHEN doc_status = 'IN TRANSIT' THEN 1 ELSE 0 END) AS incoming,
             SUM(CASE WHEN doc_status = 'ON QUEUE' THEN 1 ELSE 0 END) AS on_queue,
             SUM(CASE WHEN doc_status = 'OUTGOING' THEN 1 ELSE 0 END) AS outgoing,
             SUM(CASE WHEN doc_status = 'COMPLETED' THEN 1 ELSE 0 END) AS completed
          FROM documents
          WHERE doc_owner = '{$dept_abbreviation}'";

// Execute the query
$result = $database->query($query);
$document_summary = $database->fetch_array($result);

if (!$document_summary) {
    // If no result, initialize values with zeros to avoid undefined variable issues
    $document_summary = [
        'total_documents' => 0,
        'incoming' => 0,
        'on_queue' => 0,
        'outgoing' => 0
    ];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/nav.css">
    <style>
        .dashboard-summary {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .dashboard-summary .summary-card {
            width: 30%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            text-align: center;
        }
        .summary-card h2 {
            font-size: 36px;
            margin-bottom: 10px;
            color: #007bff;
        }
        .summary-card p {
            font-size: 18px;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="assets/images/divineLogo.jpg" alt="Document Tracking System Logo" style="width: 80%; height: auto; margin-bottom: 20px;">
        <a href="dashboard.php" class="active" ><i class="fa fa-tasks"></i> Dashboard</a>
        <a href="profile.php"><i class="fa fa-tasks"></i> Profile </a>
        <a href="add_document.php"><i class="fa fa-file-o"></i> Add Document</a>
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

    <!-- Main Content -->
    <div class="container">
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

        <!-- Document Summary Dashboard -->
        <div class="dashboard-summary">

            <div class="summary-card">
                <h2><?php echo $document_summary['total_documents']; ?></h2>
                <p>Total Documents</p>
            </div>
            <div class="summary-card">
                <h2><?php echo $document_summary['incoming']; ?></h2>
                <p>Incoming Documents</p>
            </div>
            <div class="summary-card">
                <h2><?php echo $document_summary['on_queue']; ?></h2>
                <p>Documents On Queue</p>
            </div>
            <div class="summary-card">
                <h2><?php echo $document_summary['outgoing']; ?></h2>
                <p>Outgoing Documents</p>
            </div>
            <div class="summary-card">
                <h2><?php echo $document_summary['completed']; ?></h2>
                <p>Completed Documents</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
