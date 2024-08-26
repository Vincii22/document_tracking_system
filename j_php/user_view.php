<?php
require_once("../includes/initialize.php");

$sql = "SELECT username,last_name, first_name, dept_id,usertype+0 AS usertype ";
$sql .= "FROM users ";
$sql .= "WHERE user_id=".$_GET['user_id'] ;

$result = User::find_by_sql($sql);
$found_user = array();
foreach($result as $user) {
    $found_user['username'] = $user->username;
    $found_user['firstname'] = $user->first_name;
    $found_user['lastname'] = $user->last_name;
    $found_user['dept_id'] = $user->dept_id;
    $found_user['usertype'] = $user->usertype;
}
echo json_encode($found_user);
?>