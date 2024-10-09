<?php
header("Content-Type: text/javascript; charset=utf-8");
require_once("../includes/initialize.php");

$page = $_GET['page'];

$per_page = 10;
$total_count = User::count_all();

$pagination = new Pagination($page, $per_page, $total_count);

$sql = "SELECT user_id, CONCAT(last_name,', ',first_name) AS last_name, username, departments.dept_abbreviation AS dept_id ";
$sql .= "FROM users ";
$sql .= "LEFT JOIN departments ON users.dept_id = departments.dept_id ";
$sql .= "ORDER BY last_name ASC ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";


$a1 = User::find_by_sql($sql);

$htmlContent1 = '<div class="col-auto" style="margin:19px;"><div class="table-responsive" style="font-size:12px;background-color:#ffffff;margin:0px 10px;padding:0px 0px;width:76vw;">
                 <table class="table table-striped table-bordered table-sm"><thead><tr class="justify-content-start"><th style="width:394px;">&nbsp;Name</th>
                 <th style="width:284px;"><strong>Username</strong><br></th><th>Department</th><th style="width:213px;">Process</th></tr></thead><tbody>';
$htmlContent2 = "";
$htmlContent3 = '</tbody></table></div></div><div class="col" style="width:1071px;height:27px;padding:0px 20px;"><nav style="width:940px;height:33px;"><ul class="pagination"> ';
$htmlContent4 = '';
$htmlContent5 = '</ul></nav></div>';
if(empty($a1)) {
    echo 'No Shit!';
}
else {
    foreach($a1 as $user_data){

        $htmlContent2 .= '<tr data-id="'.$user_data->user_id; 
        $htmlContent2 .= '" style="height:30px;"><td class="align-middle">'.$user_data->last_name;
        $htmlContent2 .= '</td><td class="align-middle">'.$user_data->username;
        $htmlContent2 .= '</td><td class="align-middle">'.$user_data->dept_id;
        $htmlContent2 .= '</td><td style="height:18px;"><button class="btn btn-success active btn-sm" type="button"';
        $htmlContent2 .= 'style="height:15px;padding:0;font-size:10px;margin:0px 2px;width:90px;">Reset Password</button><button ';
        $htmlContent2 .= 'class="btn btn-primary active btn-sm" type="button" id="editButton" style="height:15px;padding:0;font-size:10px;margin:0px 2px;width:35px;" ';
        $htmlContent2 .= 'data-target="#editModal" data-toggle="modal">Edit</button><button class="btn btn-danger active btn-sm" type="button" ';
        $htmlContent2 .= 'style="height:15px;padding:0;font-size:10px;margin:0px 2px;width:40px;">Delete</button></td></tr>';

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



      
                              


                                
                            


