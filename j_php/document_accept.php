<?php
require_once("../includes/initialize.php");

$doc = Document::find_by_id($_GET['doc_id']);
echo $doc->receive();

//save log
$log = new logs();
$log->doc_trackingnum = $doc->doc_trackingnum;
$log->accept_document();

?>