<?php
require_once("../includes/initialize.php");

$dept = Department::find_by_id($_GET['deptid']);

$dept->dept_head = $_GET['depthead'];

echo $dept->update();

?>