<?php

require_once('database.php');

class DatabaseObject {
    
    //Common Database Methods
    public static function find_all() {
        return static::find_by_sql("SELECT * FROM ".static::$table_name);
    }
 
    public static function find_by_id($id=0){
        global $database;
        $result_array = static::find_by_sql("SELECT * FROM ".
        static::$table_name." WHERE ".static::$primary_key."={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_sql($sql=""){
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)){
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    } 

    public static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM ".static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    private static function instantiate($record) {
        $object = new static;
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
    return $object;
    }

    private function has_attribute($attribute) {
        $object_vars = get_object_vars($this);
        return array_key_exists($attribute, $object_vars);
    }

    protected function attributes() {
        //return an array of attribute keys and their values
        $attributes = array();
        foreach(static::$db_fields as $field) {
            if(property_exists($this,$field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        foreach ($this->attributes() as $key => $value) {
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }

    public function create() {
        global $database;
        // Don't forget your SQL syntax and good habits:
        // - INSERT INTO table (key, key) VALUES ('value', 'value')
        // - single-qoutes around all values
        // - escape all values to prevent SQL INJECTION
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO ".static::$table_name." (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";

        //echo $sql;
        if($database->query($sql)) {
            $this->{static::$primary_key} = $database->insert_id();
            //echo $this->{static::$primary_key}." was added to the database.";
            return true;
        } else {
            return false; 
        }
    }

    public function update() {
        global $database;
        // Don't forget your SQL syntax and good habits
        // - UPDATE table SET key='value', key='value' WHERE condition
        // - single-quotes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE ".static::$table_name." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE ".static::$primary_key."=".$this->{static::$primary_key};
        
        //  echo $sql;
        $database->query($sql);
        return ($database->affected_rows()==1) ? true : false;
    }

    public function delete() {
        global $database;
        // Don't forget your SQL syntax and good habits:
        // - DELETE FROM table WHERE condition LIMIT 1
        // - escape all values to prevent SQL injection
        // - use LIMIT 1
        $sql = "DELETE FROM ".static::$table_name." ";
        $sql .= "WHERE ".static::$primary_key."=". $database->escape_value($this->{static::$primary_key});
        $sql .= " LIMIT 1";
        //echo $sql;
        $database->query($sql);
        return ($database->affected_rows()) ? true : false;
    }

}

?>