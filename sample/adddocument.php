<?php
require_once("../includes/initialize.php");

$session->login(1);

$newdoc = new Document;
$newdoc->doc_name="Penis Enlargement Proposal";

$newdoc->personnel_id=3;
$newdoc->doc_owner="DYUN LUCENECIO";
$newdoc->doc_type=2;
//$newdoc->generate_trackingnum();
$newdoc->add_document();

/*
$f = Document::find_by_id(103);
echo "<br>".$f->doc_trackingnum.'-'.$f->doc_type.'-'.$f->doc_code;
*/



?>