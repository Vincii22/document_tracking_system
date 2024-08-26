<?php
require_once("../includes/initialize.php");
/*
date_default_timezone_set("Asia/Manila");


$file = 'c://xampp/htdocs/sl-dts/logs/181611.dts.log';
$handle = fopen($file, "a");

$content=date("Y-m-d H:i:s", time()).": ".$_SESSION['username']." logged in.\r";

fwrite($handle,$log);
fclose($handle);
//$_SESSION['username']*/
/*



$log = new logs();
$log->doc_trackingnum = 123122;
$log->mark_completed();
*/
$num = "639173193264";
echo substr($num,2);
?>