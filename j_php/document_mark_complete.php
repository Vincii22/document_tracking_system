<?php
require_once("../includes/initialize.php");

$doc = Document::find_by_id($_GET['doc_id']);

$flag = $doc->mark_completed();

if($flag == 3) {
    //sample notification for completed
    $s = new SMSNotification();
    $s->doc_name = substr($doc->doc_name, 0, 60);
    $s->doc_mobilenum = $doc->doc_mobilenum;
    $s->doc_trackingnum = $doc->doc_trackingnum;
    $s->notify_completed();
    
    //save log
    $log = new logs();
    $log->doc_trackingnum = $doc->doc_trackingnum;
    $log->mark_completed();

    echo $flag;
}

?>