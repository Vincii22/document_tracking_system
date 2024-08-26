<?php
require_once("../includes/initialize.php");

if($session->user_id){
    echo $session->user_id;
    }
else {
    echo 'Nice Try';
}





?>