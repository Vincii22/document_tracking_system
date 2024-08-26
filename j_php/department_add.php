<?php
require_once("../includes/initialize.php");

$dept = new Department();

$dept->dept_name = strtoupper($_GET['dname']);
$dept->dept_abbreviation = strtoupper($_GET['dcode']);
$dept->dept_head = $_GET['dhead'];

echo $dept->create();

?>