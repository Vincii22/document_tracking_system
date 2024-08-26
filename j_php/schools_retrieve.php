<?php

require_once("../includes/initialize.php");

global $database;

$sql = "SELECT school_id,school_name ";
$sql .= "FROM schools ";
$sql .= "WHERE district_id=".$_GET['district'];
$sql .= " ORDER BY school_name ASC";

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
    foreach($object_array as $dist) {
        $htmlContent .= '<option value="'.$dist['school_id'].'">'.$dist['school_name'].'</option>';
    }
 
}

echo $htmlContent;

?>



      
                              


                                
                            


