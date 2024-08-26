<?php
require_once("../includes/initialize.php");


$session->login(1);

$u=User::find_by_id(1);
$a1 = array();
$a1 = $u->get_incoming();
//var_dump($a1);
echo '<br>'.$a1[0]['doc_id'];
echo '<br>'.$a1[0]['doc_code'];


$session->logout();

?>