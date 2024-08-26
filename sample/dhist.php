<?php

require_once("../includes/initialize.php");


/*
$dhist = DocumentHistory::find_by_id(2);

$dhist->doc_id=9;
$dhist->is_last=false;


$dhist->update();
*/
echo 'ID is: '.DocumentHistory::find_last(0);

?>