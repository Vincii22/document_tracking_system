<?php
require_once("../includes/initialize.php");

$dept = Department::find_by_id($_GET['dept_id']);


$found_dept = array();
$found_dept['dcode'] = $dept->dept_abbreviation;
$found_dept['dhead'] = $dept->dept_head;

echo json_encode($found_dept);
?>