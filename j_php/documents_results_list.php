<?php
header("Content-Type: text/javascript; charset=utf-8");
require_once("../includes/initialize.php");

global $database;

$searchTerm = $_GET['search'];
$docStatus = $_GET['docstatus'];
if ($docStatus == null)
    $docStatus = 0;

//for pagination
$page = $_GET['page'];
//$page = 1;
$per_page = 10;

$deptId = $_SESSION['dept_id'];

$total_count = Document::count_all_same_doc_status($docStatus, $searchTerm, $deptId);
//echo $total_count;

//echo $dept;

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT documents.doc_id, doc_trackingnum, doc_name, doc_owner, doc_status, ";
$sql .= "TIMESTAMPDIFF(DAY, documents_history.timestamp, NOW()) AS queue ";
$sql .= "FROM documents ";
$sql .= "LEFT JOIN documents_history ON documents.doc_id = documents_history.doc_id AND documents_history.is_last = 1 ";
$sql .= "LEFT JOIN users ON documents.personnel_id = users.user_id ";
$sql .= "WHERE users.dept_id = {$deptId} ";  // Starting the WHERE clause

// Handling document status and search term conditions
if ($docStatus != 0 && strlen($searchTerm) < 3) {
    // Append the condition for doc_status
    $sql .= "AND doc_status = {$docStatus} ";
} else if ($docStatus != 0 && strlen($searchTerm) > 2) {
    // Append the condition for both doc_status and search
    $sql .= "AND doc_status = {$docStatus} ";
    $sql .= "AND (doc_trackingnum LIKE '%$searchTerm%' OR doc_name LIKE '%$searchTerm%' OR doc_owner LIKE '%$searchTerm%') ";
} else if (strlen($searchTerm) > 2) {
    // Append only the search condition
    $sql .= "AND (doc_trackingnum LIKE '%$searchTerm%' OR doc_name LIKE '%$searchTerm%' OR doc_owner LIKE '%$searchTerm%') ";
}

// Append pagination
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";

// Execute the query
$result_set = $database->query($sql);

$object_array = array();

while ($row = $database->fetch_array($result_set)) {
    $object_array[] = $row;
}

//preparing for the html of the page
$htmlContent1 = '<div class="col-auto" style="margin:19px;width:100%;"><div class="table-responsive" style="font-size:12px;background-color:#ffffff;margin:0px;padding:0px;width:100%;">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr class="justify-content-start" style="">
                                <th style="width:146px; padding 10px 5px; font-size: 1rem !important">&nbsp;Tracking Num</th>
                                <th style="width:295px; padding 10px 5px; font-size: 1rem !important">Document Name</th>
                                <th class="visible" style="width:120px; padding 10px 5px; font-size: 1rem !important">Queue Time</th>
                                <th class="visible" style="width:249px; padding 10px 5px; font-size: 1rem !important">Document Owner</th>
                                <th style="width:92px; padding 10px 5px; font-size: 1rem !important">Status</th>
                                <th style="width:112px; padding 10px 5px; font-size: 1rem !important">Process</th>
                            </tr>
                        </thead>
                        <tbody>';

$htmlContent2 = "";
$htmlContent3 = '
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col" style="width:1071px;height:27px;">
                <nav style="width:940px;height:33px;">
                    <ul class="pagination"> ';
$htmlContent4 = '';
$htmlContent5 = '</ul></nav></div>';

if (empty($object_array)) {
    // echo 'No Shit!';
} else {
  // Preparing the HTML for document rows
foreach ($object_array as $doc) {
    $htmlContent2 .= '<tr data-id="' . $doc["doc_id"] . '" style="height:45px;">';
    $htmlContent2 .= '<td class="align-middle" style="color:rgb(0,0,0);font-size:14px;padding:5px 10px;">' . $doc["doc_trackingnum"] . '</td>';
    $htmlContent2 .= '<td class="align-middle" style="color:rgb(0,0,0);font-size:14px;padding:5px 10px;">' . $doc["doc_name"] . '</td>';
    $htmlContent2 .= '<td class="align-middle" style="color:rgb(0,0,0);font-size:14px;padding:5px 10px;">' . $doc["queue"];
    if ($doc["queue"] != NULL) $htmlContent2 .= ' day/s';
    $htmlContent2 .= '</td>';
    
    // Document Owner
    $htmlContent2 .= '<td class="align-middle" style="color:rgb(0,0,0);font-size:14px;padding:5px 10px;">';
    $htmlContent2 .= strlen($doc["doc_owner"]) < 31 ? $doc["doc_owner"] : substr($doc["doc_owner"], 0, 30) . "...";
    $htmlContent2 .= '</td>';

    // Document Status
    $htmlContent2 .= '<td class="align-middle" style="color:rgb(0,0,0);font-size:14px;padding:5px 10px;">' . $doc["doc_status"] . '</td>';
    
    // Flex the Track Document and View buttons in the Process column
    $htmlContent2 .= '<td style=" display: flex; gap: 5px;">'; // Added flex display
    $htmlContent2 .= '<button class="btn btn-success active btn-sm" type="button" style="padding:0;font-size:14px;margin:0;padding: 2px 10px;">Track Document</button>';
    
    // Add View button with data-id
    $htmlContent2 .= '<button class="btn btn-info btn-sm btn-view" type="button" data-id="' . $doc["doc_id"] . '" style="padding:0;font-size:14px;margin:0;padding: 2px 10px;">View</button>';
    $htmlContent2 .= '</td></tr>'; // Closing the Process column and row
}


    // Pagination logic remains unchanged...
    if ($pagination->page1 != 1) {
        $htmlContent4 .= '<li class="page-item" data-value="' . ($pagination->page1 - 1) . '"><a class="page-link" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
    }
    for ($x = $pagination->page1; $x <= $pagination->page5; $x++) {
        if ($x == $pagination->current_page)
            $htmlContent4 .= '<li data-value="' . $x . '" class="page-item active"><a class="page-link">' . $x . '</a></li>';
        else if ($x <= $pagination->total_pages())
            $htmlContent4 .= '<li data-value="' . $x . '" class="page-item"><a class="page-link">' . $x . '</a></li>';
    }
    if ($pagination->page5 < $pagination->total_pages()) {
        $htmlContent4 .= '<li class="page-item" data-value="' . ($pagination->page5 + 1) . '"><a class="page-link" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
    }
}

echo $htmlContent1 . $htmlContent2 . $htmlContent3 . $htmlContent4 . $htmlContent5;

?>
