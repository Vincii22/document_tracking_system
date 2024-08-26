<?php
header("Content-Type: text/javascript; charset=utf-8");
require_once("../includes/initialize.php");

global $database;

$docStatus = $_GET['docstatus'];
if($docStatus == null)
    $docStatus=0; 
//for pagination
$page = $_GET['page'];
//$page = 1;
$per_page = 10;


$total_count = Document::count_all_same_doc_status($docStatus);
//echo $total_count;

//echo $dept;

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT documents.doc_id,doc_trackingnum,doc_name,doc_owner,doc_status,";
$sql .= "TIMESTAMPDIFF(DAY,documents_history.timestamp,NOW()) AS queue ";
$sql .= "from documents ";
$sql .= "LEFT JOIN documents_history ON documents.doc_id = documents_history.doc_id AND documents_history.is_last = 1 ";
if($docStatus != 0){
    $sql .= "WHERE doc_status = {$docStatus} ";
}
   
$sql .= "ORDER BY doc_trackingnum DESC ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";


//echo $sql; 
//$htmlContent = "";

$result_set = $database->query($sql);
$object_array = array();


while ($row = $database->fetch_array($result_set)){
    $object_array[] = $row;
}


//preparing for the html of the page


$htmlContent1 = '<div class="col-auto" style="margin:19px;width:1067px;"><div class="table-responsive" style="font-size:12px;background-color:#ffffff;margin:0px;padding:0px;width:1055px;">
                 <table class="table table-striped table-bordered table-sm"><thead><tr class="justify-content-start"><th style="width:96px;">&nbsp;Tracking Num</th><th style="width:295px;">Document Name</th><th class="visible" style="width:90px;">Queue Time</th>
                 <th class="visible" style="width:249px;">Document Owner</th><th style="width:92px;">Status</th><th style="width:112px;">Process</th></tr>
</thead><tbody>';

$htmlContent2 = "";
$htmlContent3 = '</tbody></table></div></div><div class="col" style="width:1071px;height:27px;"><nav style="width:940px;height:33px;"><ul class="pagination"> ';
$htmlContent4 = '';
$htmlContent5 = '</ul></nav></div>';

if(empty($object_array)) {
    echo 'No Shit!';
}
else {
    foreach($object_array as $doc) {
                $htmlContent2 .= '<tr data-id"'.$doc["doc_id"].'" style="height:35px;"><td class="align-middle" style="color:rgb(0,0,0);font-size:14px;">'.$doc["doc_trackingnum"];
                $htmlContent2 .= '</td><td class="align-middle" style="color:rgb(0,0,0);font-size:14px;">'.$doc["doc_name"];
                $htmlContent2 .= '</td><td class="align-middle" style="color:rgb(0,0,0);font-size:14px;">'.$doc["queue"];
                if($doc["queue"] != NULL)
                    $htmlContent2 .= ' day/s';
                $htmlContent2 .= '</td><td class="align-middle" style="color:rgb(0,0,0);font-size:14px;">'.$doc["doc_owner"];
                $htmlContent2 .= '</td><td class="align-middle" style="color:rgb(0,0,0);font-size:14px;">'.$doc["doc_status"];
                $htmlContent2 .= '</td><td style="height:18px;"><button class="btn btn-success active btn-sm" type="button"';
                $htmlContent2 .= 'style="height:20px;padding:0;font-size:10px;margin:0px 2px;width:90px;">Track Document';
                $htmlContent2 .= '</button></td></tr>';
    }
    // << only appears if p1 != 1
    if ($pagination->page1 != 1){
        $htmlContent4 .= '<li class="page-item" data-value="'.($pagination->page1 -1).'"><a class="page-link" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
    }
    for ($x=$pagination->page1;$x<=$pagination->page5;$x++) {
        if($x==$pagination->current_page)
            $htmlContent4 .= '<li data-value="'.$x.'" class="page-item active"><a class="page-link">'.$x.'</a></li>';
        // page number must be lesser than or equal to the last page 
        else if($x<=$pagination->total_pages())
            $htmlContent4 .= '<li data-value="'.$x.'" class="page-item"><a class="page-link">'.$x.'</a></li>';
    }
    // >> only appears if p5 < total pages
    if ($pagination->page5 < $pagination->total_pages()) {
        $htmlContent4 .= '<li class="page-item" data-value="'.($pagination->page5+1).'"><a class="page-link" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
    }
}

echo $htmlContent1.$htmlContent2.$htmlContent3.$htmlContent4.$htmlContent5;
  

?>



      
                              


                                
                            


