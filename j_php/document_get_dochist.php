<?php
require_once("../includes/initialize.php");

$html = "";
$d=Document::find_by_tracking($_GET['tracking']);

if($d){
    $a1 = $d->get_dochist();
   // echo 'shit if found';

    foreach($a1 as $s){
        $html .= '<tr style="height:25px;"><td class="align-middle">'.$s['timestamp'];
        $html .= '<br></td><td class="align-middle">'.$s['dochist_specs'];
        $html .= '<br></td><td class="align-middle">'.$s['dochist_remarks'].'<br></td></tr>';
    }   
    echo $html;
}
else {
    echo 'Document not found!';
}


?>