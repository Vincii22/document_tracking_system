<?php
require_once("../includes/initialize.php");

// Ensure user is logged in
session_start();
if (!isset($_SESSION['dept_abbreviation'])) {
    echo json_encode(["error" => "Department abbreviation is missing in session."]);
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

// Execute the query and fetch results
$result = $database->query($query);
$document_summary = $database->fetch_array($result);

// Return the document summary as JSON
echo json_encode($document_summary);
?>
