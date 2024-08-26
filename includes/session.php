<?php
// A class to help work with Sessoins
// In our case, primarily to manage logging users in and ouy
require_once('database.php');
require_once('user.php');


class Session {

    private $logged_in=false;
    public $user_id;

    function __construct(){
        session_start();
        $this->check_login();

        if ($this->logged_in) {
            //actions to take right away within the class if user is logged in
        } else {
            //actions to take right away within the class of user is not logged in
        }
    }

    public function is_logged_in() {
        return $this->logged_in;
    }

    public function login($user) {
        if($user) {
            $user_object = User::find_by_id($user);
            $this->user_id = $_SESSION['user_id'] = $user;
            $_SESSION['dept_id'] = $user_object->dept_id;
            $_SESSION['usertype'] = $user_object->usertype;
            $_SESSION['username'] = $user_object->username;
            $this->logged_in = true;
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['dept_id']); 
        unset($_SESSION['usertype']);      
        unset($_SESSION['username']);
        unset($this->user_id);
        $this->logged_in = false;
    }

    private function check_login() {
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }
}

$session = new Session();
?>