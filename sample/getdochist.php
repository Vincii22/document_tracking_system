<?php
require_once("../includes/initialize.php");


$session->login(1);

$d=Document::find_by_id(3);
//$a1 = array();
$a1 = $d->get_dochist();
//var_dump($a1);

/*for($x=0;$x<count($a1);$x++){
    echo '<br>'.$a1[$x]['timestamp'].','.$a1[$x]['dochist_specs'].','.$a1[$x]['dochist_remarks'];
}*/
foreach($a1 as $s){
    echo '<br>'.$s['timestamp'].','.$s['dochist_specs'].','.$s['dochist_remarks'];
}



$session->logout();

?>