<?php
require_once("../includes/initialize.php");

$dept = Department::find_by_id($_GET['dept_id']);

echo $dept->delete();

?>