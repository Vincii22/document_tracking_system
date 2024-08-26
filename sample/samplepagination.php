<?php
require_once("../includes/initialize.php");

$page = 1002;

$per_page = 3;

$total_count = Department::count_all();




$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT * FROM documents_history ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";

$dhists = DocumentHistory::find_by_sql($sql);

if(empty($dhists))
    echo 'No Shit!';
else
    var_dump($dhists);
echo $pagination->page1.' '.$pagination->page2.' '.$pagination->page3.' '.$pagination->page4.' '.$pagination->page5;
?>

SELECT
departments.dept_id,dept_name, dept_abbreviation, CONCAT(users.first_name,' ',users.last_name) AS dept_head
FROM departments 
LEFT JOIN users on departments.dept_head = users.user_id
