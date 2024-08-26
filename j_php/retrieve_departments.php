<?php
header("Content-Type: text/javascript; charset=utf-8");
require_once("../includes/initialize.php");

$page = $_GET['page'];
$per_page = 10;
$total_count = Department::count_all();

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT departments.dept_id,dept_name, dept_abbreviation, CONCAT(users.first_name,' ',users.last_name) AS dept_head ";
$sql .= "FROM departments ";
$sql .= "LEFT JOIN users on departments.dept_head = users.user_id ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";

$a1 = Department::find_by_sql($sql);

$htmlContent1 = '<div class="col-auto" style="margin:19px;width:1067px;"><div class="table-responsive" style="font-size:12px;background-color:#ffffff;margin:0px 60px;padding:0px 0px;width:950px;">
                 <table class="table table-striped table-bordered table-sm"><thead><tr class="justify-content-start"><th style="width:394px;">&nbsp;Department Name</th>
                 <th style="width:129px;"><strong>Department Code</strong><br></th><th style="width:248px;">Department Head</th><th style="width:95px;">Process</th></tr></thead><tbody>';
$htmlContent2 = "";
$htmlContent3 = '</tbody></table></div></div><div class="col" style="width:1071px;height:27px;"><nav style="width:940px;height:33px;"><ul class="pagination"> ';
$htmlContent4 = '';
$htmlContent5 = '</ul></nav></div>';
if(empty($a1)) {
    echo 'No Shit!';
}
else {
    foreach($a1 as $dept_data){
        $htmlContent2 .= '<tr data-id="'.$dept_data->dept_id.'"style="height:30px;"><td class="align-middle">'.$dept_data->dept_name;
        $htmlContent2 .= '</td><td class="align-middle">'.$dept_data->dept_abbreviation;
        $htmlContent2 .= '</td> <td class="align-middle">'.$dept_data->dept_head;
        $htmlContent2 .= '</td><td style="height:18px;"><button class="btn btn-primary active btn-sm" type="button" style="height:15px;padding:0;font-size:10px;margin:0px 2px;width:35px;" ';
        $htmlContent2 .= 'data-target="#editModal" data-toggle="modal">Edit</button><button class="btn btn-danger active btn-sm"';
        $htmlContent2 .= 'type="button" style="height:15px;padding:0;font-size:10px;margin:0px 2px;width:40px;">Delete</button></td></tr>';
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



//Page Number Area


/*  htmlcontent2
                            
                            <li class="page-item"><a class="page-link">1</a></li>
                            <li class="page-item active"><a class="page-link">2</a></li>
                            <li class="page-item"><a class="page-link">3</a></li>
                            <li class="page-item"><a class="page-link">4</a></li>
                            <li class="page-item"><a class="page-link">5</a></li>
                            <li class="page-item"><a class="page-link" aria-label=""><span aria-hidden="true">»</span></a></li>*/


   
//echo $pagination->page1.' '.$pagination->page2.' '.$pagination->page3.' '.$pagination->page4.' '.$pagination->page5;
?>



      
                              


                                
                            


