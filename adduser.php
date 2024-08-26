<?php
require_once("includes/initialize.php");

$string = " ";

$words = explode(" ",$string);
$acronym = "";
$cnt=0;
if(count($words)>1){
    foreach ($words as $w) {
        $cnt++;
        if($cnt<3){
            if(strlen($w)>3)
                $acronym .= $w[0].$w[1].$w[2];
            else 
                $acronym .= $w;
            }
        if($cnt<2)
            $acronym .= "_";
        }
    }
else {
    $acronym = substr($words[0], 0, 7);
    }   

return strtoupper($acronym);

?>