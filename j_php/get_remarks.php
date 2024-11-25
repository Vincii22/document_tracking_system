<?php

require_once("../includes/initialize.php");

$doc_id = $_GET['doc_id'];

// Fetch remarks
$sql = "SELECT * FROM remarks WHERE doc_id = ? ORDER BY created_at ASC";
$remarks = $database->fetchAll($sql, [$doc_id]);

echo json_encode($remarks);

?>
