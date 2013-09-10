<?php

class Session {

    private $logged_in = false;
    private $user_id;

    function __construct() {
        session_start();
        $this->check_login();
        if (!$this->logged_in) {
            header('location:' . $this->getPath() . '/login.php');
        }
    }

    public function check_role($role) {
        if ($_SESSION['user']['role'] == $role) {
            return true;
        }
        return false;
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
        session_destroy();
        header('location:' . $this->getPath());
    }

    private function check_login() {
        if (isset($_SESSION['user'])) {
            $this->logged_in = true;
            $this->user_id = $_SESSION['user']['id'];
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }

    public function getUser_id() {
        return $this->user_id;
    }

    private function getPath() {
        $levels = substr_count($_SERVER['PHP_SELF'], '/');
        $splitted = split('/', $_SERVER['PHP_SELF']);

        for ($i = 1; $i < $levels - 1; $i++) {
            $relativeDir .= '../';
        }
        $relativeDir .= 'pages/';

        foreach ($splitted as $split) {
            if ($split == 'admin' || $split == 'user')
                $relativeDir .= $split;
        }
        return $relativeDir;
    }

//    ulteriore dinamicizzazione(fallimentare, per ora)
    private function getPath2() {
        $relativeDir = '';
        $splitted = split('/', $_SERVER['PHP_SELF']);
        $bool = false;
        foreach ($splitted as $split) {
            if ($split == 'melarossa') {
                $bool = true;
            }
            if ($bool) {
                if ($split == 'admin' || $split == 'user') {
                    $relativeDir .= 'pages/' . $split;
                    break;
                } else {
                    $relativeDir .= '../';
                }
            }
        }
        return $relativeDir;
    }

}

?>