<?php
require_once("../includes/initialize.php");
//sample notification for cancelled
/*
$s = new SMSNotification();
echo $s->current_dept;
$s->doc_mobilenum = '63'.'9173193264';
$s->doc_trackingnum = 696969696;
echo $s->notify_cancelled();
*/

//sample notification for completed
/*
$s = new SMSNotification();
echo $s->current_dept;
$s->doc_mobilenum = '63'.'9173193264';
$s->doc_trackingnum = 696969696;
echo $s->notify_completed();
*/

//sample notification for received
/*
$s = new SMSNotification();
echo $s->current_dept;
$s->doc_mobilenum = 639175610034;
$s->doc_trackingnum = 696969696;
echo $s->notify_received();
*/

//sample notification for remarks

$s = new SMSNotification();

$s->doc_mobilenum = 639175610034;
$s->doc_trackingnum = 181114005;
$remarks = "You can't sing the same old romance when there's no more pain";
echo $s->notify_remarks($remarks);




?>