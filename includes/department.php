<?php
require_once('database.php');

class Department extends DatabaseObject {

    protected static $primary_key = "dept_id";
    protected static $table_name="departments";
    protected static $db_fields = array('dept_id','dept_name',
    'dept_head','dept_abbreviation');
    public $dept_id;
    public $dept_name;
    public $dept_head;
    public $dept_abbreviation;


    

}

?>