<?php
require_once('database.php');
// This is a helper class to help in preparing SMS messages.

class SMSNotification {
    public $doc_trackingnum;
    public $doc_mobilenum = 639989720348; // Make sure this is the correct format
    public $doc_name = "";
    public $current_dept;
    private $counter = 0;

    public function __construct() {
        // Assuming a session is already started
        if (isset($_SESSION['dept_id'])) {
            $d = Department::find_by_id($_SESSION['dept_id']);
            $this->current_dept = $d->dept_abbreviation;  
        } else {
            // Handle case where dept_id is not set
            $this->current_dept = "UNKNOWN";
        }
    }

    private function send($message) {
        $this->counter++;
        $filename = date("YmdHis", time());
        $directory = 'c://xampp/htdocs/sl-dts/sms_outgoing/';
        $file = $directory . $this->doc_trackingnum . '-' . $filename . '-' . $this->counter . '.sms';
        $content = "To: " . $this->doc_mobilenum . "\n\n" . $message . " \n";
        
        // Check if the directory exists, if not, create it
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true); // Create directory if it doesn't exist
        }

        // Attempt to write the file and handle errors
        $size = @file_put_contents($file, $content);
        if ($size === false) {
            error_log("Failed to write SMS file: " . $file);
            return false; // Handle the error as needed
        }

        // Save log
        logs::sms($this->doc_mobilenum);
        return true; // Successful write
    }

    public function notify_cancelled() {
        $msg = 'sl-dts update on doc#';
        $msg .= $this->doc_trackingnum . ': ' . $this->doc_name;
        $msg .= ', Canceled @ ';
        $msg .= $this->current_dept;
        $msg .= ', Please call the Division Office division@deped.gov.ph.';
    
        return $this->send($msg); // Return the result of the send operation
    }

    public function notify_completed() {
        $msg = 'sl-dts update on doc#';
        $msg .= $this->doc_trackingnum . ': ' . $this->doc_name;
        $msg .= ', Completed @ ';
        $msg .= $this->current_dept . '.';
    
        return $this->send($msg);
    }

    public function notify_received() {
        $msg = 'sl-dts update on doc#';
        $msg .= $this->doc_trackingnum . ': ' . $this->doc_name;
        $msg .= ', Received @ ';
        $msg .= $this->current_dept . '. You may follow up using this document tracking number.';
    
        if ($this->send($msg)) {
            $this->send_basic();
            return true;
        }
        return false; // Return false if send fails
    }

    public function notify_remarks($remarks) {
        $msg = 'sl-dts update on doc#';
        $msg .= $this->doc_trackingnum . ': ' . $this->doc_name . ".\n";

        $small = strtoupper(substr($remarks, 0, 95));
        $msg .= $small;

        $msg .= ",\nRemarks added @ ";
        $msg .= $this->current_dept . ".";
        
        return $this->send($msg);
    }

    private function send_basic() {
        $msg = '***This is a system-generated SMS. Please do not reply to this message. You may contact the office at 570-8933/ .divisio@.gov.ph.***';
        return $this->send($msg);
    }
}
?>
