<?php
header("Content-Type: text/javascript; charset=utf-8");
require_once("../includes/initialize.php");

global $database;

$sql = "SELECT dept_id,dept_abbreviation ";
$sql .= "FROM departments ";
$sql .= "ORDER BY dept_abbreviation ASC";

//echo $sql;
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
    foreach($object_array as $dept) {
        $htmlContent .= '<option value="'.$dept['dept_id'].'">'.$dept['dept_abbreviation'].'</option>';
    }
 
}

echo $htmlContent;

?>



      
                              


                                
                            


