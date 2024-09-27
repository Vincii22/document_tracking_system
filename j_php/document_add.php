<?php
require_once("../includes/initialize.php");

// Check if a file is uploaded
if (isset($_FILES['docfile']) && $_FILES['docfile']['error'] === UPLOAD_ERR_OK) {
    // File upload path
    $target_dir = "../uploads/";
    $file_name = basename($_FILES["docfile"]["name"]);
    $target_file = $target_dir . $file_name;

    // Attempt to move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["docfile"]["tmp_name"], $target_file)) {
        $file_uploaded = true;
    } else {
        $file_uploaded = false;
        echo "File upload failed.";
        exit();
    }
} else {
    $file_uploaded = false;
}

// Initialize a new Document instance
$newdoc = new Document;
$newdoc->doc_name = strtoupper($_POST['docname']);
$newdoc->doc_owner = strtoupper($_POST['docowner']);
$newdoc->doc_type = $_POST['doctype'];
$newdoc->doc_mobilenum = '63' . $_POST['mobilenum'];
$newdoc->personnel_id = $session->user_id; // Get the logged-in user's ID

// Store the file name if the file was uploaded
if ($file_uploaded) {
    $newdoc->doc_file = $file_name; // Save the file name or file path in the database
}

// Attempt to add the document
if ($newdoc->add_document()) {
    // Notify user via SMS (optional)
    $s = new SMSNotification();
    $s->doc_name = substr($newdoc->doc_name, 0, 60);
    $s->doc_mobilenum = $newdoc->doc_mobilenum;
    $s->doc_trackingnum = $newdoc->doc_trackingnum;
    $s->notify_received();

    // Log the document
    $log = new logs();
    $log->doc_trackingnum = $newdoc->doc_trackingnum;
    $log->add_document();

   // Redirect to the success page with tracking number
   $tracking_number = $newdoc->doc_trackingnum;
   header("Location: ../public/add_document_success.php?tracking=" . $tracking_number);
   exit(); // Make sure to exit after the redirect
} else {
    echo "Failed to add document.";
}
?>
