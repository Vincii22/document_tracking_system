<?php
// This is used to save logs of documents' movement and user activity.

class logs {
    public $username;
    public $doc_trackingnum;
    public $curent_dept;


    public function __construct(){
        date_default_timezone_set("Asia/Manila");
        $this->username = $_SESSION['username'];  
    }

    private function save($log) {
        $filename = 'sl.dts.movement.logs.' . date("Y-m", time()) . '.log';
        $directory = 'c://xampp/htdocs/logs/doc-movement/';
        $file = $directory . $filename;
    
        // Ensure the directory exists
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    
        // Open the file for appending
        $handle = fopen($file, "a");
    
        // Check if the file was opened successfully
        if ($handle) {
            fwrite($handle, $log);
            fclose($handle);
        } else {
            // Handle the error if the file could not be opened
            error_log("Failed to open file: $file");
        }
    }
    

    private static function sms_save($log) {
        date_default_timezone_set("Asia/Manila");
        $filename = 'sl.dts.sms.logs.'.date("Y-m-d",time()).'.log';
        $file = 'c://xampp/htdocs/logs/sms-monitoring/'.$filename;
        $handle = fopen($file, "a");
        fwrite($handle,$log);
        fclose($handle);
    }

  //  $content=date("Y-m-d H:i:s", time()).": ".$_SESSION['username']." logged in.\r";
    public function login() {

        $log = date("Y-m-d H:i:s", time()).": ".$this->username." logged in @ ".$_SERVER['REMOTE_ADDR'].".\r";
        $this->save($log);
    }

    public function logout() {
        
        $log = date("Y-m-d H:i:s", time()).": ".$this->username." logged out @ ".$_SERVER['REMOTE_ADDR'].".\r";
        $this->save($log);
    }

    public function add_document() {
        
        $log = date("Y-m-d H:i:s", time()).": ".$this->username." added document#".$this->doc_trackingnum." @ ".$_SERVER['REMOTE_ADDR'].".\r";
        $this->save($log);
    }

    public function accept_document() {
        
        $log = date("Y-m-d H:i:s", time()).": ".$this->username." received document#".$this->doc_trackingnum." @ ".$_SERVER['REMOTE_ADDR'].".\r";
        $this->save($log);
    }

    public function add_remarks() {
        
        $log = date("Y-m-d H:i:s", time()).": ".$this->username." added remarks to document#".$this->doc_trackingnum." @ ".$_SERVER['REMOTE_ADDR'].".\r";
        $this->save($log);
    }

    public function forward_document() {
        
        $log = date("Y-m-d H:i:s", time()).": ".$this->username." forwarded document#".$this->doc_trackingnum." @ ".$_SERVER['REMOTE_ADDR'].".\r";
        $this->save($log);
    }

    public function cforward_document() {
        
        $log = date("Y-m-d H:i:s", time()).": ".$this->username." cancelled the forwarding of document#".$this->doc_trackingnum." @ ".$_SERVER['REMOTE_ADDR'].".\r";
        $this->save($log);
    }

    public function mark_completed() {
        
        $log = date("Y-m-d H:i:s", time()).": ".$this->username." marked document#".$this->doc_trackingnum." completed @ ".$_SERVER['REMOTE_ADDR'].".\r";
        $this->save($log);
    }

    public function mark_cancelled() {
        
        $log = date("Y-m-d H:i:s", time()).": ".$this->username." marked document#".$this->doc_trackingnum." cancelled @ ".$_SERVER['REMOTE_ADDR'].".\r";
        $this->save($log);
    }

    public static function sms($num) {
        date_default_timezone_set("Asia/Manila");
        $log = date("Y-m-d H:i:s", time()).": An sms was sent to ".$num.".\r";
        static::sms_save($log);
    }

}

?>