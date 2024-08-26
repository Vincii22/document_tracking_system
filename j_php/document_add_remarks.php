<?php

require_once("../includes/initialize.php");

$doc = Document::find_by_id($_POST['doc_id']);
$remarks = $_POST['remarks'];
$flag = $doc->add_remarks($remarks);
$shortened_remarks=$remarks;
if($flag == 1){
    
    //sample notification for remarks
    $s = new SMSNotification();
    $s->doc_name = substr($doc->doc_name, 0, 60);
    $s->doc_mobilenum = $doc->doc_mobilenum;
    $s->doc_trackingnum = $doc->doc_trackingnum;
    $s->notify_remarks($shortened_remarks);

    //save log
    $log = new logs();
    $log->doc_trackingnum = $doc->doc_trackingnum;
    $log->add_remarks();

    echo $flag;
}

?>