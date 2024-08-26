<?php
require_once("../includes/initialize.php");


$session->login(1);

$u=User::find_by_id($session->user_id);
$a1 = array();
$a1 = $u->get_forwarded();
//var_dump($a1);

for($x=0;$x<count($a1);$x++){
    echo '<br>'.$a1[$x]['doc_id'].'-'.$a1[$x]['doc_code'];
}

$session->logout();

?>