<?php
require_once("../includes/initialize.php");

//$dept = Department::find_by_id(0);
//$dept->delete();

$dept = new Department();

$dept->dept_name = "INFORMATION AND COMMUNICATIONS TECHNOLOGY SERVICES UNIT";
$dept->dept_abbreviation = "SDO_ICT";
$dept->dept_head = 69;

$dept->create();

$dept2 = new Department();

$dept2->dept_name = "INFORMATION AND COMMUNICATIONS TECHNOLOGY SERVICES UNIT";
$dept2->dept_abbreviation = "SDO_ICT";
$dept2->dept_head = 69;

$dept2->create();

$dept3 = new Department();

$dept3->dept_name = "INFORMATION AND COMMUNICATIONS TECHNOLOGY SERVICES UNIT";
$dept3->dept_abbreviation = "SDO_ICT";
$dept3->dept_head = 69;

$dept3->create();

?>