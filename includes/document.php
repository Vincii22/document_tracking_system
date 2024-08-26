<?php
require_once('database.php');

class Document extends DatabaseObject {

    protected static $primary_key = "doc_id";
    protected static $table_name="documents";
    protected static $db_fields = array('doc_id','doc_name','doc_trackingnum','doc_mobilenum','doc_code',
    'doc_status','date_started','date_completed','personnel_id','doc_owner','doc_type');
    public $doc_id;
    public $doc_name;
    public $doc_trackingnum=0;
    public $doc_mobilenum;
    public $doc_code;
    public $doc_status;
    public $date_started;
    public $date_completed;
    public $personnel_id;
    public $doc_owner;
    public $doc_type;

    public $doc_ownertype;
    public $schoolname;
    public $districtname;

    public static function find_by_tracking($tracking=0){
        global $database;
        $result_array = static::find_by_sql("SELECT * FROM ".
        "documents"." WHERE "."doc_trackingnum"."={$tracking} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function daily_count() {
        date_default_timezone_set("Asia/Manila");
        global $database;
        $sql = "SELECT COUNT(*) AS total_found FROM ";
        $sql .= static::$table_name." WHERE date_started = '".date('Y-m-d')."'";
        //echo $sql;
        $result_set = $database->query($sql);

        return $result_set->fetch_assoc()['total_found'];
    }

    public static function count_all_same_doc_status($docStatus,$searchTerm) {
        global $database; 
        $sql = "SELECT COUNT(*) from documents "; 
        //$sql .= "LEFT JOIN documents_history ON documents.doc_id = documents_history.doc_id AND documents_history.is_last = 1 ";
        if($docStatus != 0 && strlen($searchTerm)<3){
            $sql .= "WHERE doc_status = {$docStatus} ";
        }
        else if($docStatus != 0 && strlen($searchTerm)>2) {
            $sql .= "WHERE (doc_status = {$docStatus} AND (doc_trackingnum LIKE '%$searchTerm%' OR doc_name LIKE '%$searchTerm%' OR doc_owner LIKE '%$searchTerm%')) ";
        }
        else if(strlen($searchTerm)>2){
            $sql .= "WHERE (doc_trackingnum LIKE '%$searchTerm%' OR doc_name LIKE '%$searchTerm%' OR doc_owner LIKE '%$searchTerm%') ";
        }
        
        
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row); 
    }

    public function generate_trackingnum() {
    
        $num = self::daily_count() + 1;
        $str_length = 3;

        //hardcoded left padding if number < $str_length
        $str = substr("000{$num}", -$str_length);
        $this->doc_trackingnum = date('ymd').$str;
        //echo '<br>'.$this->doc_trackingnum.'<br>';
    }

    public function generate_code() {
        $this->doc_code = static::generate_acronym($this->doc_name).'-'.static::generate_acronym($this->doc_owner);
    }

    public static function generate_acronym($string) {
        /*
        $words = explode(" ",$string);
        $acronym = "";

        foreach ($words as $w) {
        $acronym .= $w[0];
        }
        return strtoupper($acronym);*/
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

    }

    public static function generate_acronym_two($string) {
        
        $words = explode(" ",$string);
        $acronym = "";

        foreach ($words as $w) {
        $acronym .= $w[0];
        }
        return strtoupper($acronym);

    }

    public function add_document(){
        $this->doc_status = 1;
        $this->generate_trackingnum();
        $this->generate_code();
        $this->date_started=date('Y-m-d');
        $x=$this->create();

        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_type = 1;    
        $y=$new_doc_hist->create();
        return $x+$y;
        
    }

    private function change_is_last(){
        //updates the last document history entry of the docuemnt
        $last_doc_hist = DocumentHistory::find_by_id(DocumentHistory::find_last($this->doc_id));
        //var_dump($last_doc_hist);
        $last_doc_hist->is_last = false;
        return $last_doc_hist->update();
    }

    public function receive() {
        $x=0;
        $y=0;
        $x=$this->change_is_last();
        $this->doc_status = 2;
        $this->update();
        
        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_type = 1;    
        $y=$new_doc_hist->create();
        return $x+$y;  
    }

    public function forward($dept) {
        $x=0;
        $y=0;
        $x=$this->change_is_last();
        $this->doc_status = 2;
        $this->update();

        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $dept;
        $new_doc_hist->dochist_type = 2;
        $y=$new_doc_hist->create();
        return $x+$y;
    }

    public function add_remarks($remarks) {
        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_remarks=strtoupper($remarks);
        $new_doc_hist->dochist_type = 3;
        $new_doc_hist->is_last = false;
        return $new_doc_hist->create();
    }

    public function cancel_forward() {
        $x=0;
        $y=0;
        $x=$this->change_is_last();
        $this->doc_status = 2;
        $this->update();

        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_type = 4;
        $y=$new_doc_hist->create();
        return $x+$y;
    }

    public function mark_completed() {
        $x=0;
        $y=0;
        $z=0;
        $x=$this->change_is_last();
        $this->doc_status = 4;
        $this->date_completed=date('Y-m-d');
        $y=$this->update();

        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_type = 5;
        $new_doc_hist->is_last = false;
        $z=$new_doc_hist->create();
        return $x+$y+$z;
    }
    
    public function mark_cancelled() {
        $x=0;
        $y=0;
        $z=0;
        $x=$this->change_is_last();
       
        $this->doc_status = 3;
        $this->date_completed=date('Y-m-d');
        $y=$this->update();
        

        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_type = 6;
        $new_doc_hist->is_last = false;
        $z=$new_doc_hist->create();
        
        return $x+$y+$z;
    }

    public function get_dochist() {
        global $database;

        $sql = "SELECT documents_history.timestamp, CONCAT(documents_history.dochist_type,' ',departments.dept_abbreviation,";
        $sql .= "' BY ',users.user_abbreviation) AS dochist_specs, documents_history.dochist_remarks";
        $sql .= " FROM documents_history";
        $sql .= " INNER JOIN departments ON documents_history.dept_id = departments.dept_id";
        $sql .= " INNER JOIN users ON documents_history.user_id = users.user_id";
        $sql .= " WHERE documents_history.doc_id = ".$this->doc_id;
        $sql .= " ORDER BY documents_history.timestamp ASC";

        //echo $sql;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = $row;
        }
        return $object_array;
    }

    

}

?>