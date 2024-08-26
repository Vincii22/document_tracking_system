<?php
require_once("../includes/initialize.php");

$newdoc = new Document;
$newdoc->doc_name=strtoupper($_GET['docname']);

$newdoc->doc_owner=strtoupper($_GET['docowner']);
$newdoc->doc_type=$_GET['doctype'];
$newdoc->doc_mobilenum='63'.$_GET['mobilenum'];
//$newdoc->doc_mobilenum=435345;
$newdoc->personnel_id=$session->user_id;
if($newdoc->add_document()) {

    //sample notification for received
    $s = new SMSNotification();
    $s->doc_name = substr($newdoc->doc_name, 0, 60);
    $s->doc_mobilenum = $newdoc->doc_mobilenum;
    $s->doc_trackingnum = $newdoc->doc_trackingnum;
    $s->notify_received();

    //save log
    $log = new logs();
    $log->doc_trackingnum = $newdoc->doc_trackingnum;
    $log->add_document();
    

    echo $newdoc->doc_trackingnum;
}
    

?>