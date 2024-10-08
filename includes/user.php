<?php
require_once('database.php');
require_once('document.php');

class User extends DatabaseObject {

    protected static $primary_key = "user_id";
    protected static $table_name="users";
    protected static $db_fields = array('user_id', 'username','password',
    'first_name','last_name','user_abbreviation','usertype','dept_id','personnel_id', 'user_image', 'email');
    public $user_id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $dept_id;
    public $email;
    public $usertype;
    public $personnel_id;
    public $user_image;
    public $user_abbreviation;
  
    public function full_name() {
        if(isset($this->first_name) && isset($this->last_name)) {
            return $this->first_name . " " . $this->last_name;
        } else {
            return "";
        }
    }

    public static function authenticate($username = "", $password = "") {
        global $database;
    
        // Escape the username to prevent SQL injection
        $username = $database->escape_value($username);
    
        // Prepare the SQL query to find the user by username only
        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "LIMIT 1"; 
    
        // Execute the query and get the result
        $result_array = self::find_by_sql($sql);
    
        // Check if a user was found
        if (!empty($result_array)) {
            $user = array_shift($result_array);
    
            // Now, verify the password using password_verify
            if (password_verify($password, $user->password)) {
                return $user; // Return the user object if password matches
            } else {
                return false; // Return false if password does not match
            }
        } else {
            return false; // Return false if no user found
        }
    }
    

    public function get_incoming() {
        global $database;
        $sql = "SELECT documents.doc_id, CONCAT(documents.doc_trackingnum,'-',documents.doc_code,'-',documents.doc_type) AS doc_code, ";
        $sql .= "doc_name, doc_owner, date_started, TIMESTAMPDIFF(DAY,documents_history.timestamp,NOW()) AS queue ";
        $sql .= "FROM documents ";
        $sql .= "INNER JOIN documents_history ON documents.doc_id = documents_history.doc_id ";
        $sql .= "WHERE documents_history.is_last=true ";
        $sql .= "AND documents_history.dept_id=".$_SESSION['dept_id'];
        //$sql .= "AND documents_history.dept_id=8";
        $sql .= " AND documents_history.dochist_type=2";

      //  echo $sql;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = $row;

        }

        return $object_array;
        
    }

    public function get_searched_incoming($searchTerm) {
        global $database;
        $sql = "SELECT documents.doc_id, CONCAT(documents.doc_trackingnum,'-',documents.doc_code,'-',documents.doc_type) AS doc_code, ";
        $sql .= "doc_name, doc_owner, date_started, TIMESTAMPDIFF(DAY,documents_history.timestamp,NOW()) AS queue ";
        $sql .= "FROM documents ";
        $sql .= "INNER JOIN documents_history ON documents.doc_id = documents_history.doc_id ";
        $sql .= "WHERE documents_history.is_last=true ";
        $sql .= "AND documents_history.dept_id=".$_SESSION['dept_id'];
        $sql .= " AND documents_history.dochist_type=2";
        $sql .= " AND (doc_trackingnum LIKE '%$searchTerm%' OR doc_name LIKE '%$searchTerm%' OR doc_owner LIKE '%$searchTerm%') ";

      //  echo $sql;
        $result_set = $database->query($sql);
        $object_array = array();
        
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = $row;
            
        }

        return $object_array;
    }

    public function get_onqueue() {
        global $database;
        $sql = "SELECT documents.doc_id, CONCAT(documents.doc_trackingnum,'-',documents.doc_code,'-',documents.doc_type) AS doc_code, ";
        $sql .= "doc_name, doc_owner, date_started, TIMESTAMPDIFF(DAY,documents_history.timestamp,NOW()) AS queue ";
        $sql .= "FROM documents ";
        $sql .= "INNER JOIN documents_history ON documents.doc_id = documents_history.doc_id ";
        $sql .= "WHERE documents_history.is_last=true ";
        $sql .= "AND documents_history.user_id=".$this->user_id;
        $sql .= " AND (documents_history.dochist_type=1 OR documents_history.dochist_type=4)";

    
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = $row;
        }
        return $object_array;
    }

      public function get_searched_onqueue($searchTerm) {
        global $database;
        $sql = "SELECT documents.doc_id, CONCAT(documents.doc_trackingnum,'-',documents.doc_code,'-',documents.doc_type) AS doc_code, ";
        $sql .= "doc_name, doc_owner, date_started, TIMESTAMPDIFF(DAY,documents_history.timestamp,NOW()) AS queue ";
        $sql .= "FROM documents ";
        $sql .= "INNER JOIN documents_history ON documents.doc_id = documents_history.doc_id ";
        $sql .= "WHERE documents_history.is_last=true ";
        $sql .= "AND documents_history.user_id=".$this->user_id;
        $sql .= " AND (documents_history.dochist_type=1 OR documents_history.dochist_type=4)";
        $sql .= " AND (doc_trackingnum LIKE '%$searchTerm%' OR doc_name LIKE '%$searchTerm%' OR doc_owner LIKE '%$searchTerm%') ";
    
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = $row;
        }
        return $object_array;
    }

    public function get_forwarded() {
        global $database;
        $sql = "SELECT documents.doc_id, CONCAT(documents.doc_trackingnum,'-',documents.doc_code,'-',documents.doc_type) AS doc_code, ";
        $sql .= "doc_name, doc_owner, date_started, TIMESTAMPDIFF(DAY,documents_history.timestamp,NOW()) AS queue ";
        $sql .= "FROM documents ";
        $sql .= "INNER JOIN documents_history ON documents.doc_id = documents_history.doc_id ";
        $sql .= "WHERE documents_history.is_last=true ";
        $sql .= "AND documents_history.user_id=".$this->user_id;
        //$sql .= "AND documents_history.user_id=4";
        $sql .= " AND documents_history.dochist_type=2";

       echo $sql;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = $row;
        }
        return $object_array;
    }

    public function get_searched_forwarded($searchTerm) {
        global $database;
        $sql = "SELECT documents.doc_id, CONCAT(documents.doc_trackingnum,'-',documents.doc_code,'-',documents.doc_type) AS doc_code, ";
        $sql .= "doc_name, doc_owner, date_started, TIMESTAMPDIFF(DAY,documents_history.timestamp,NOW()) AS queue ";
        $sql .= "FROM documents ";
        $sql .= "INNER JOIN documents_history ON documents.doc_id = documents_history.doc_id ";
        $sql .= "WHERE documents_history.is_last=true ";
        $sql .= "AND documents_history.user_id=".$this->user_id;
        //$sql .= "AND documents_history.user_id=4";
        $sql .= " AND documents_history.dochist_type=2";
        $sql .= " AND (doc_trackingnum LIKE '%$searchTerm%' OR doc_name LIKE '%$searchTerm%' OR doc_owner LIKE '%$searchTerm%') ";

       echo $sql;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = $row;
        }
        return $object_array;
    }

    public function add() {
        $this->user_abbreviation = Document::generate_acronym_two($this->first_name).' '.strtoupper($this->last_name);
        $this->first_name = strtoupper($this->first_name);
        $this->last_name = strtoupper($this->last_name);

        
        return $this->create();
    }
    
    public function edit() {
        $this->user_abbreviation = Document::generate_acronym_two($this->first_name).' '.strtoupper($this->last_name);
        echo $this->update();
    }
    public static function instantiate($record) {
        $user = new self; // Create a new instance of User
        // Set properties from the associative array
        foreach ($record as $attribute => $value) {
            if (property_exists($user, $attribute)) {
                $user->$attribute = $value; // Set the property
            }
        }
        return $user; // Return the User object
    }
    public static function find_all_by_dept_and_type($dept_id, $usertype) {
        global $database; // Ensure you have access to the database connection
        $sql = "SELECT * FROM users WHERE dept_id = '{$dept_id}' AND usertype = '{$usertype}'";
        $result_set = $database->query($sql);
        $users = [];

        while ($row = mysqli_fetch_assoc($result_set)) {
            $users[] = self::instantiate($row); // Assuming instantiate method exists to create User objects
        }
        return $users;
    }
    public static function find_by_email($email) {
        global $database;
        $email = $database->escape_value($email);
        $sql = "SELECT * FROM users WHERE email = '{$email}' LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    public static function authenticate_by_email($email = "", $password = "") {
        global $database;
    
        // Sanitize email and password
        $email = $database->escape_value($email);
        $password = $database->escape_value($password);
    
        // Perform query to check for a matching email
        $sql  = "SELECT * FROM users ";
        $sql .= "WHERE email = '{$email}' ";
        $sql .= "LIMIT 1";
    
        $result_array = self::find_by_sql($sql);
        // Check if a user was found
        if (!empty($result_array)) {
            $user = array_shift($result_array);
    
            // Now, verify the password using password_verify
            if (password_verify($password, $user->password)) {
                return $user; // Return the user object if password matches
            } else {
                return false; // Return false if password does not match
            }
        } else {
            return false; // Return false if no user found
        }
    }
    
}

?>