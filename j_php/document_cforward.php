<?php
require_once("../includes/initialize.php");

$doc = Document::find_by_id($_GET['doc_id']);
echo $doc->cancel_forward();

//save log
$log = new logs();
$log->doc_trackingnum = $doc->doc_trackingnum;
$log->cforward_document();

?>