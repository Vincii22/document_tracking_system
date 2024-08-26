<?php
header("Content-Type: text/javascript; charset=utf-8");
require_once("../includes/initialize.php");

global $database;

$sql = "SELECT user_id,CONCAT(first_name,' ',last_name) AS full_name ";
$sql .= "FROM users ";
$sql .= "WHERE usertype = 'mgmt' ";
$sql .= "ORDER BY full_name ASC";

$htmlContent = "";

$result_set = $database->query($sql);
$object_array = array();
while ($row = $database->fetch_array($result_set)){
    $object_array[] = $row;
}

if(empty($object_array)) {
    echo 'No Shit!';
}
else {
    foreach($object_array as $dept_heads) {
        $htmlContent .= '<option value="'.$dept_heads['user_id'].'">'.$dept_heads['full_name'].'</option>';
    }
 
}

echo $htmlContent;

?>



      
                              


                                
                            


