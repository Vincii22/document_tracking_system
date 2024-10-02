<?php
require_once('database.php');

class Document extends DatabaseObject {

    protected static $primary_key = "doc_id";
    protected static $table_name = "documents";
    protected static $db_fields = array(
        'doc_id', 'doc_name', 'doc_trackingnum', 'barcode_path', 'doc_mobilenum', 'doc_code',
        'doc_status', 'date_started', 'date_completed', 'personnel_id', 'doc_owner', 'doc_type', 'doc_file'
    );
    
    public $doc_id;
    public $doc_name;
    public $doc_trackingnum = 0;
    public $barcode_path;
    public $doc_mobilenum;
    public $doc_code;
    public $doc_status;
    public $date_started;
    public $date_completed;
    public $personnel_id;
    public $doc_owner;
    public $doc_type;
    public $doc_file; 
    public $doc_ownertype; // To hold the owner type
    public $schoolname;
    public $districtname;

    public static function find_by_tracking($tracking = 0) {
        global $database;
        $result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE doc_trackingnum = {$tracking} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    public static function daily_count() {
        date_default_timezone_set("Asia/Manila");
        global $database;
        $sql = "SELECT COUNT(*) AS total_found FROM " . static::$table_name . " WHERE date_started = '" . date('Y-m-d') . "'";
        $result_set = $database->query($sql);

        return $result_set->fetch_assoc()['total_found'];
    }

    public static function count_all_same_doc_status($docStatus, $searchTerm, $deptId) {
        global $database; 
        $sql = "SELECT COUNT(*) FROM documents ";
        $sql .= "LEFT JOIN users ON documents.personnel_id = users.user_id ";
        $sql .= "WHERE users.dept_id = {$deptId} ";
        
        if ($docStatus != 0) {
            $sql .= "AND doc_status = {$docStatus} ";
        }
        
        if (!empty($searchTerm)) {
            $sql .= "AND (doc_trackingnum LIKE '%{$searchTerm}%' OR doc_name LIKE '%{$searchTerm}%' OR doc_owner LIKE '%{$searchTerm}%') ";
        }
    
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        
        return array_shift($row);
    }

    public function generate_trackingnum() {
        $num = self::daily_count() + 1;
        $str_length = 3;

        // Hardcoded left padding if number < $str_length
        $str = substr("000{$num}", -$str_length);
        $this->doc_trackingnum = date('ymd') . $str;
    }

    public function generate_code() {
        $this->doc_code = static::generate_acronym($this->doc_name) . '-' . static::generate_acronym($this->doc_owner);
    }

    public static function generate_acronym($string) {
        $words = explode(" ", $string);
        $acronym = "";
        $cnt = 0;
        if (count($words) > 1) {
            foreach ($words as $w) {
                $cnt++;
                if ($cnt < 3) {
                    if (strlen($w) > 3)
                        $acronym .= $w[0] . $w[1] . $w[2];
                    else 
                        $acronym .= $w;
                }
                if ($cnt < 2)
                    $acronym .= "_";
            }
        } else {
            $acronym = substr($words[0], 0, 7);
        }   

        return strtoupper($acronym);
    }

    public static function generate_acronym_two($string) {
        $words = explode(" ", $string);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        return strtoupper($acronym);
    }
    public function add_document() {
        $this->doc_status = 1;
        $this->generate_trackingnum();
        $this->generate_code();
        $this->date_started = date('Y-m-d');
    
        // Set the doc_ownertype based on session dept_id
        if (isset($_SESSION['dept_id'])) {
            $this->doc_ownertype = strtoupper($_SESSION['dept_id']); // Storing department ID as owner type
        }
    
        // Check if file name is set and ensure it's saved
        if (!empty($this->doc_file)) {
            // Process file upload logic if needed
        }
    
        // Generate the barcode before saving the document
        if (!$this->generate_barcode()) {
            return false; // If barcode generation fails, do not proceed further
        }
    
        // Save the document
        $x = $this->create();
    
        // If document creation was successful, send notification
    if ($x) {
        // Create a notification message
        $message = "A new document '{$this->doc_name}' has been created.";

        // Send notification to the relevant user(s)
        $recipient_user_id = $_SESSION['user_id']; // Change this as needed for your logic
        notify_user($recipient_user_id, $message);
        
        // Save the document history
        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_type = 1;    
        $y = $new_doc_hist->create();
        
        return $x + $y; // Returns the success status
    }

    return false; // If document creation failed
    }
    

    private function change_is_last() {
        // Updates the last document history entry of the document
        $last_doc_hist = DocumentHistory::find_by_id(DocumentHistory::find_last($this->doc_id));
        $last_doc_hist->is_last = false;
        return $last_doc_hist->update();
    }

    public function receive() {
        $x = 0;
        $y = 0;
        $x = $this->change_is_last();
        $this->doc_status = 2;
        $this->update();
        
        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_type = 1;    
        $y = $new_doc_hist->create();

          // Notify relevant user
          $message = "Document '{$this->doc_name}' has been received.";
          $recipient_user_id = $_SESSION['user_id']; // Adjust as needed
          notify_user($recipient_user_id, $message);

        return $x + $y;  
    }

    public function forward($dept) {
        $x = 0;
        $y = 0;
        $x = $this->change_is_last();
        $this->doc_status = 2;
        $this->update();

        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $dept;
        $new_doc_hist->dochist_type = 2;
        $y = $new_doc_hist->create();

         // Notify relevant user
         $message = "Document '{$this->doc_name}' has been forwarded to department '{$dept}'.";
         $recipient_user_id = $_SESSION['user_id']; // Adjust as needed
         notify_user($recipient_user_id, $message);

        return $x + $y;
    }

    public function add_remarks($remarks) {
        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_remarks = strtoupper($remarks);
        $new_doc_hist->dochist_type = 3;
        $new_doc_hist->is_last = false;
        return $new_doc_hist->create();

            // Notify relevant user
            if ($result) {
                $message = "Remarks added to document '{$this->doc_name}'.";
                $recipient_user_id = $_SESSION['user_id']; // Adjust as needed
                notify_user($recipient_user_id, $message);
            }
    
            return $result;
    }

    public function cancel_forward() {
        $x = 0;
        $y = 0;
        $x = $this->change_is_last();
        $this->doc_status = 2;
        $this->update();

        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_type = 4;
        $y = $new_doc_hist->create();

            // Notify relevant user
        $message = "Forwarding of document '{$this->doc_name}' has been cancelled.";
        $recipient_user_id = $_SESSION['user_id']; // Adjust as needed
        notify_user($recipient_user_id, $message);

        return $x + $y;
    }

    public function mark_completed() {
        $x = 0;
        $y = 0;
        $z = 0;
        $x = $this->change_is_last();
        $this->doc_status = 4;
        $this->date_completed = date('Y-m-d');
        $y = $this->update();

        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_type = 5;
        $new_doc_hist->is_last = false;
        $z = $new_doc_hist->create();

        // Notify relevant user
        $message = "Document '{$this->doc_name}' has been marked as completed.";
        $recipient_user_id = $_SESSION['user_id']; // Adjust as needed
        notify_user($recipient_user_id, $message);

        return $x + $y + $z;
    }
    
    public function mark_cancelled() {
        $x = 0;
        $y = 0;
        $z = 0;
        $x = $this->change_is_last();
       
        $this->doc_status = 3;
        $this->date_completed = date('Y-m-d');
        $y = $this->update();

        $new_doc_hist = new DocumentHistory;
        $new_doc_hist->doc_id = $this->doc_id;
        $new_doc_hist->user_id = $_SESSION['user_id'];
        $new_doc_hist->dept_id = $_SESSION['dept_id'];
        $new_doc_hist->dochist_type = 6;
        $new_doc_hist->is_last = false;
        $z = $new_doc_hist->create();

        // Notify relevant user
        $message = "Document '{$this->doc_name}' has been marked as cancelled.";
        $recipient_user_id = $_SESSION['user_id']; // Adjust as needed
        notify_user($recipient_user_id, $message);
        
        return $x + $y + $z;
    }

    public function get_dochist() {
        global $database;

        $sql = "SELECT documents_history.timestamp, CONCAT(documents_history.dochist_type, ' ', departments.dept_abbreviation, ";
        $sql .= "' BY ', users.user_abbreviation) AS dochist_specs, documents_history.dochist_remarks";
        $sql .= " FROM documents_history";
        $sql .= " INNER JOIN departments ON documents_history.dept_id = departments.dept_id";
        $sql .= " INNER JOIN users ON documents_history.user_id = users.user_id";
        $sql .= " WHERE documents_history.doc_id = " . $this->doc_id;
        $sql .= " ORDER BY documents_history.timestamp ASC";

        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = $row;
        }
        return $object_array;
    }

    public function generate_barcode() {
        if (empty($this->doc_trackingnum)) {
            return false;
        }

        // Use the php-barcode-generator library
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($this->doc_trackingnum, $generator::TYPE_CODE_128);

        // Define where to save the barcode
        $barcode_dir = "../barcodes/";
        if (!is_dir($barcode_dir)) {
            mkdir($barcode_dir, 0777, true); // Create directory if not exists
        }

        // Set the barcode path
        $this->barcode_path = $barcode_dir . $this->doc_trackingnum . ".png";

        // Save the barcode image
        if (file_put_contents($this->barcode_path, $barcode)) {
            return true;
        } else {
            return false;
        }
    }
}
function notify_user($recipient_user_id, $message) {
    global $database; // Assuming $database is an instance of MySQLDatabase

    // Escape the recipient_user_id and message to prevent SQL injection
    $recipient_user_id = $database->escape_value($recipient_user_id);
    $message = $database->escape_value($message);

    // Construct the SQL query
    $query = "INSERT INTO notifications (user_id, message, status) VALUES ('{$recipient_user_id}', '{$message}', 'UNREAD')";

    // Execute the query and handle any errors
    if (!$database->query($query)) {
        error_log("Database error: " . $database->get_last_error()); // Log the error for debugging
    }
}



?>
