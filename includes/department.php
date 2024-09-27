<?php
require_once('database.php');

class Department extends DatabaseObject {

    protected static $primary_key = "dept_id";
    protected static $table_name = "departments";
    protected static $db_fields = array('dept_id', 'dept_name', 'dept_head', 'dept_abbreviation');
    
    public $dept_id;
    public $dept_name;
    public $dept_head;
    public $dept_abbreviation;

    // Override the find_by_id method to ensure compatibility
    public static function find_by_id($id = 0) {
        return parent::find_by_id($id); // Call the parent method for consistency
    }

    // Additional methods specific to Department can be added here
}
?>
