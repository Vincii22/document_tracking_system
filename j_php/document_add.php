<?php
require_once("../includes/initialize.php");
require_once("../vendor/autoload.php"); // Include the autoload if using composer

use Picqer\Barcode\BarcodeGeneratorPNG;

// Check if a file is uploaded
if (isset($_FILES['docfile']) && $_FILES['docfile']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "../uploads/";
    $file_name = basename($_FILES["docfile"]["name"]);
    $target_file = $target_dir . $file_name;

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

$newdoc = new Document;
$newdoc->doc_name = strtoupper($_POST['docname']);
$newdoc->doc_owner = strtoupper($_POST['docowner']);
$newdoc->doc_type = $_POST['doctype'];
$newdoc->doc_mobilenum = '63' . $_POST['mobilenum'];
$newdoc->personnel_id = $session->user_id;

if ($file_uploaded) {
    $newdoc->doc_file = $file_name;
}

// Attempt to add the document
if ($newdoc->add_document()) {
    $doc_trackingnum = $newdoc->doc_trackingnum;

    notify_user($newdoc->personnel_id, "A new document '{$newdoc->doc_name}' has been created.");
    
    // Generate the barcode
    $generator = new BarcodeGeneratorPNG();
    $barcode = $generator->getBarcode($doc_trackingnum, $generator::TYPE_CODE_128);

    // Save the barcode as an image
    $barcode_path = "../barcodes/" . $doc_trackingnum . ".png";
    file_put_contents($barcode_path, $barcode);

    // Update the document entry to store the barcode path
    $newdoc->barcode_path = $barcode_path;
    $newdoc->update(); // Assuming you have an `update()` method for updating the document entry in the database

    $s = new SMSNotification();
    $s->doc_name = substr($newdoc->doc_name, 0, 60);
    $s->doc_mobilenum = $newdoc->doc_mobilenum;
    $s->doc_trackingnum = $newdoc->doc_trackingnum;
    $s->notify_received();

    $log = new logs();
    $log->doc_trackingnum = $newdoc->doc_trackingnum;
    $log->add_document();

    header("Location: ../public/add_document_success.php?tracking=" . $doc_trackingnum);
    exit();
} else {
    echo "Failed to add document.";
}

?>
