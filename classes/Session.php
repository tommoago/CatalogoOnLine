<?php

class Session {

    private $logged_in = false;
    public $user_id;

    function __construct() {
        session_start();
        $this->check_login();
        if (!$this->logged_in) {
            header('location:login.php');
        }
    }

    public function is_logged_in() {
        return $this->logged_in;
    }

    public function login($user) {
        $_SESSION['user'] = $user;
        $this->logged_in = true;
    }

    public function logout() {
        unset($_SESSION['user']);
        unset($this->user_id);
        $this->logged_in = false;
    }

    private function check_login() {
        if (isset($_SESSION['user'])) {
//            $this->user_id = $_SESSION['user'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }

}
?>