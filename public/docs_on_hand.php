<?php require_once("../includes/initialize.php"); 

if(!isset($_SESSION['usertype'])) {
    redirect_to('login.php');
} else {
    if ($_SESSION['usertype'] == 'guest' ) {
        redirect_to('track_doc.php');
    }
}

// Fetch all documents from the database
$documents = Document::find_all(); // Assuming you have a 'find_all' method in your Document class

if (!$documents) {
    echo '<div style="position: absolute; top: 10%; left: 50%;">No documents found.</div>';
}

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
    <title>dts-Documents on Hand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Data-Table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Data-Table2.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Footer-Basic.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap.min.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/nav.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/docs_on_hand.css?v=<?php echo time(); ?>">
    <style>
    .custom-select {
        width: 100%;
        height: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }
    
    .custom-select:hover {
        border-color: #007bff;
        box-shadow: 0 6px 12px rgba(0, 123, 255, 0.2);
    }
    
    .custom-button {
        display: block;
        width: 100%;
        padding: 6px;
        margin: 8px 0;
        font-size: 12px;
        text-align: center;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .custom-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Button Colors */
    #acceptIncoming {
        background-color: #28a745;
        color: white;
    }

    #addIncomingRemarks, #addOnQueueRemarks, #addOutgoingRemarks {
        background-color: #ff4d4d;
        color: white;
    }

    #viewSelectedDoc {
        background-color: #17a2b8;
        color: white;
    }

    #forward {
        background-color: #ffc107;
        color: white;
    }

    #completed {
        background-color: #007bff;
        color: white;
    }

    #cancel, #cancelForward {
        background-color: #dc3545;
        color: white;
    }
    option{
        border-bottom: 1px solid black;
        padding: 5px 0;
        margin: 0px 10px;
    }
    option:focus{
        background: #5F5F5F;
    }
    option:hover{
        background-color: #5F5F5F;
        color: white;
    }
</style>
</head>

<body style="position: relative;">
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


    </div>
    <div style="font-size:10px; min-height: 90vh; padding-bottom: 20px; border-radius: 12px; margin: 20px 25px 25px 250px !important;">
        <div class="bread-crums" style="background-color: white; padding: 20px; margin-bottom: 20px;">
            <a href="dashboard.php" style="font-size: 16px; color: black;"> Dashboard /</a>
            <a href="#" class="" style="font-size: 16px; color: blue;">Process Document </a>
        </div>
        <div class="" style="height: fit-content; background-color: white; padding-right: 20px;">
            <div class="d-flex" style="">
                <div class="col-9" style="margin:20px 0px;height:32px;">
                    <h4 style="color:rgb(134,142,150);padding:0px 120px;width:476px;">Process Documents</h4>
                </div>
                <div class="col-3" style="margin:20px 0px;height:32px;">
                
                <input class="visible" type="text" id="doc_search" placeholder="Search Documents" style="width:150px;height:35px;font-size:12px;" autocomplete="off"></div>
            </div>
            <div class="row" style="font-size:12px;height:454px;padding:0 50px;margin:0; display: flex; justify-content: space-between;">
            <!-- Incoming List -->
            <div class="">
                <div class="" style="margin:19px;width:260px;height:349px;">
                    <h1 class="" style="color: black; position: relative; font-size: 15px; text-align: center; width: 280px"><b>INCOMING</b></h1>
                    <select multiple="" id="incomingList" class="custom-select" style="height:340px;width:300px;">
                        <optgroup style=""></optgroup>
                    </select>
                </div>

                <!-- Incoming Buttons -->
                <div class="" style="">
                    <div class="row" id="incomingButtons" style="display: flex; justify-content: center; margin-left: 24px;">
                        <div class="d-flex" style="gap: 10px;">
                            <button style="padding: 5px 15px;" class="btn btn-success btn-sm custom-button" type="button" id="acceptIncoming">Accept</button>
                            <button style="padding: 5px 15px;" class="btn btn-warning btn-sm custom-button" type="button" id="addIncomingRemarks" data-target="#remarksModal" data-toggle="modal">Remarks</button>
                            <button style="padding: 5px 15px;" class="btn btn-info btn-sm custom-button" type="button" id="viewSelectedDoc">View</button>
                        </div>
                    </div>
                </div>
            </div>

           <div class="">
                <!-- On Queue List -->
                <div class="" style="margin:19px;width:260px;height:349px;">
                    <h1 class="" style="color: black; position: relative; font-size: 15px; text-align: center; width: 280px"><b>ON QEUE</b></h1>
                    <select multiple="" id="onQueueList" class="custom-select" style="height:340px;width:300px;">
                        <optgroup style=""></optgroup>
                    </select>
                </div>

                <!-- On Queue Buttons -->
                <div class="" style="">
                <div class="row" id="onQueueButtons" style="display: flex; justify-content: center; margin-left: 24px;">
                    <div class="d-flex" style="gap: 10px">
                        <button style="padding: 5px 6px;" class="btn btn-success btn-sm custom-button" type="button" id="forward" data-target="#forwardDoc" data-toggle="modal">Forward</button>
                        <button style="padding: 5px 6px;" class="btn btn-warning btn-sm custom-button" type="button" id="addOnQueueRemarks" data-target="#remarksModal" data-toggle="modal">Remarks</button>
                        <button style="padding: 5px 6px;" class="btn btn-primary btn-sm custom-button" type="button" id="completed">Completed</button>
                        <button style="padding: 5px 6px;" class="btn btn-danger btn-sm custom-button" type="button" id="cancel">Cancel</button>
                    </div>
                </div>
                </div>
           </div>

            <div class="">
                <!-- Outgoing List -->
                <div class="" style="margin:19px;width:260px;height:349px;">
                    <h1 class="" style="color: black; position: relative; font-size: 15px; text-align: center; width: 280px"><b>PENDING</b></h1>
                    <select multiple="" id="outgoingList" class="custom-select" style="height:340px;width:300px;">
                        <optgroup style=""></optgroup>
                    </select>
                </div>

                <!-- Outgoing Buttons -->
                <div class="" style="">
                    <div class="row" id="outgoingButtons" style="display: flex; justify-content: center; margin-left: 24px;">
                        <div class="d-flex" style="gap: 10px;">
                            <button style="padding: 5px 15px;" class="btn btn-danger btn-sm custom-button" type="button" id="cancelForward">Cancel Forward</button>
                            <button style="padding: 5px 15px;" class="btn btn-warning btn-sm custom-button" type="button" id="addOutgoingRemarks" data-target="#remarksModal" data-toggle="modal">Remarks</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="remarksModal" style="padding:0px 0px;margin:200px 0px; ">
        <div class="modal-dialog modal-sm" role="document" >
            <div class="modal-content" style="width:400px;">
                <div class="modal-header"  style="background-color:#5f5f5f;margin:0px 0px;padding:10px 15px;">
                    <h5 class="modal-title" style="color:white;margin:-2px 4px;">Add Remarks</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: white;">&times;</span></button></div>
                <div class="modal-body" style="height:152px; width:400px !important;"><textarea style="font-size:12px;padding:0px;width:100%;height:100% !important;" maxlength="95"></textarea></div>
                <div class="modal-footer" style="height:35px;"><button class="btn btn-light btn-sm" type="button" data-dismiss="modal" style="height:23px;width:50px;margin:0px 0px;padding:0px 0px;">Close</button><button class="btn btn-primary btn-sm" id="remarksSave" type="button" style="height:23px;padding:0px 0px;margin:0px 10px;width:45px;font-size:12px;">Save</button></div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" role="dialog" tabindex="-1" id="editPassword" style="padding:0px 0px;margin:200px 0px;overflow: hidden;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="width:400px; ">
                <div class="modal-header" style="background-color:#5f5f5f;margin:0px 0px;padding:10px 15px;">
                    <h5 class="modal-title" style="color:white;margin:-2px 4px;">Change Password</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: white;">&times;</span></button></div>
                <div class="modal-body" style="height:202px; width:400px !important;">
                    <div class="row">
                        <div class="col"><small style="color:rgb(255,0,0); display:none">Password was updated successfully.</small></div>
                    </div>
                    <div class="row">
                        <div class="col-auto" style="margin:0px 0px;width:100%;"><label class="col-form-label" style="font-size:15px;">Enter Password:</label><input type="password" id="mPassword1" style="font-size:17px;margin:0px 5px; width: 100%; "></div>
                        <div class="col-auto" style="margin:0px 0px;width:100%;"><label class="col-form-label" style="font-size:15px;">Reenter Password:&nbsp;</label><input type="password" id="mPassword2" style="font-size:17px;margin:5px; width: 100%; "></div>
                    </div>
                </div>
                <div class="modal-footer" style="height:35px;"><button class="btn btn-light btn-sm" type="button" id="mPasswordClose" data-dismiss="modal" style="height:23px;width:50px;margin:0px 0px;padding:0px 0px;">Close</button><button class="btn btn-primary btn-sm" type="button" id="mPasswordSave"
                        style="height:23px;padding:0px 0px;margin:0px 10px;width:45px;font-size:12px;">Save</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="forwardDoc" style="padding:0px 0px 13px;margin:200px 0px;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="width:400px; ">
                <div class="modal-header" style="background-color:#5f5f5f;margin:0px 0px;padding:10px 15px;">
                    <h5 class="modal-title" style="color:white;margin:-2px 4px;">Forward Document</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: white;">&times;</span></button></div>
                <div class="modal-body" style="height:105px; width:400px !important;">
                    <div class="row">
                        <div class="col-auto" style="padding:0px 13px;position:relative; width: 100%;"><label class="col-form-label" style="font-size:17px;">Please select department:</label>
                        <br><select style="font-size:15px;margin:10px 5px;position: absolute; right:10px;"><optgroup label=""><option value="12" selected=""></option><option value="13">SGOD-P&amp;R</option><option value="14">CID-ALS</option></optgroup></select></div>
                    </div>
                </div>
                <div class="modal-footer" style="height:35px;"><button class="btn btn-light btn-sm" type="button" id="mForwardClose" data-dismiss="modal" style="height:23px;width:50px;margin:0px 0px;padding:0px 0px;">Close</button><button class="btn btn-success btn-sm" type="button" id="mForward"
                        style="height:23px;padding:0px 0px;margin:0px 10px;width:57px;font-size:12px;">Forward</button></div>
            </div>
        </div>
    </div>

    <!-- MODAL FOR VIEWING DOCUMENT  -->
    <div class="modal fade" role="dialog" tabindex="-1" id="viewModal" style="padding:0px 0px;margin:200px 0px;overflow:hidden">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="width:400px;">
            <div class="modal-header" style="background-color:#5f5f5f;margin:0px 0px;padding:10px 15px;">
                <h5 class="modal-title" style="color:white;margin:-2px 4px;">Document Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: white;">&times;</span></button>
            </div>
            <div class="modal-body" style="width:273px;">
                <!-- Document details will be displayed here -->
                <div id="documentDetails" style="font-size:15px;">
                    <p><strong>Document Name:</strong> <span id="docName"></span></p>
                    <p><strong>Document Owner:</strong> <span id="docOwner"></span></p>
                    <p><strong>Document Type:</strong> <span id="docType"></span></p>
                    <p><strong>Document File:</strong> <span id="docFile"></span></p>
                    <p><strong>Date Started:</strong> <span id="docDateStarted"></span></p>
                </div>
            </div>
            <div class="modal-footer" style="height:35px;">
                <button class="btn btn-light btn-sm" type="button" data-dismiss="modal" style="height:23px;width:50px;margin:0px 0px;padding:0px 0px;">Close</button>
            </div>
        </div>
    </div>
</div>
    <!-- END MODAL FOR VIEWING DOCUMENT  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap.min.js"></script>

    <script src="../j_js/menu-visibility.js"></script>
    <script src="../j_js/docprocessing.js"></script>

    <script>
          // Event listener for viewing the selected document
          $("#viewSelectedDoc").click(function() {
            var selectedDoc = $("#incomingList option:selected").val(); // Get selected document from the list
            if (selectedDoc) {
                console.log("Selected Document ID:", selectedDoc);  // Debugging
    
                $.ajax({
                    url: '../j_php/get_document_details.php',
                    type: 'POST',
                    data: { doc_id: selectedDoc },  // Send the document ID to the server
                    success: function(response) {
                        console.log("Response from server:", response);  // Log response from the server
                        try {
                            var data = JSON.parse(response);
                            if (data.error) {
                                alert(data.error);
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
                            alert('Error parsing server response.');
                            console.error('Parsing error:', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error fetching document details: ' + error);
                    }
                });
            } else {
                alert("Please select a document to view.");
            }
        });
    
    </script>
</body>

</html>
