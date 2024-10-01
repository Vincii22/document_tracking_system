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

        /* Styling for graphs */
        .graphs-container {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
    gap: 20px;
    flex-wrap: wrap;
}

.graph-card {
    flex: 1 1 48%; /* Adjust the graph to take up 48% of the width */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    text-align: center;
    margin-bottom: 20px; /* Add space between rows */
}

        .graph-card canvas {
            width: 65% !important;
            height: 30vh !important;
        }
    </style>
</head>

<body>
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
            <a href="dashboard.php" class="active"><i class="fa fa-tasks"></i> Dashboard</a>
            <a href="profile.php" ><i class="fa fa-tasks"></i> Profile </a>
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
                    <a class="nav-link text-white" href="logout.php"><i class="fa fa-bell"></i></a>
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
    
  <!-- Main Content -->
<div class="container">

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

<!-- Graphs Container -->
<div class="graphs-container">
    <div class="graph-card">
        <canvas id="graph1"></canvas>
    </div>
    <div class="graph-card">
        <canvas id="graph2"></canvas>
    </div>
    <div class="graph-card">
        <canvas id="graph3"></canvas>
    </div>
    <div class="graph-card">
        <canvas id="graph4"></canvas>
    </div>
</div>
</div>

<!-- Bootstrap JS and Chart.js -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data for graphs
const documentSummary = <?php echo json_encode($document_summary); ?>;

// Graph 1: Pie chart for document statuses
const ctx1 = document.getElementById('graph1').getContext('2d');
new Chart(ctx1, {
    type: 'pie',
    data: {
        labels: ['Incoming', 'On Queue', 'Outgoing', 'Completed'],
        datasets: [{
            data: [documentSummary.incoming, documentSummary.on_queue, documentSummary.outgoing, documentSummary.completed],
            backgroundColor: ['#007bff', '#ffc107', '#dc3545', '#28a745'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});

// Graph 2: Bar chart for total vs. completed documents
const ctx2 = document.getElementById('graph2').getContext('2d');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Total Documents', 'Completed'],
        datasets: [{
            label: 'Documents',
            data: [documentSummary.total_documents, documentSummary.completed],
            backgroundColor: ['#007bff', '#28a745']
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Graph 3: Line chart for document flow (Incoming vs. Outgoing)
const ctx3 = document.getElementById('graph3').getContext('2d');
new Chart(ctx3, {
    type: 'line',
    data: {
        labels: ['Incoming', 'Outgoing'],
        datasets: [{
            label: 'Document Flow',
            data: [documentSummary.incoming, documentSummary.outgoing],
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            fill: false,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Graph 4: Doughnut chart for document status distribution
const ctx4 = document.getElementById('graph4').getContext('2d');
new Chart(ctx4, {
    type: 'doughnut',
    data: {
        labels: ['Incoming', 'On Queue', 'Outgoing', 'Completed'],
        datasets: [{
            data: [documentSummary.incoming, documentSummary.on_queue, documentSummary.outgoing, documentSummary.completed],
            backgroundColor: ['#007bff', '#ffc107', '#dc3545', '#28a745'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>
</body>

</html>