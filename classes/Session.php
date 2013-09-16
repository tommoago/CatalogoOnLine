<?php

class Session {

    private $user_id;

    function __construct() {
        session_start();
        if (!$this->check_login()) {
            header('location:' . $this->getPath() . '/login.php');
        }
    }

    public function check_role($role) {
        if ($_SESSION['user']['role'] == $role) {
            return true;
        }
        return false;
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
            $this->user_id = $_SESSION['user']['id'];
            if(isset($_SESSION['user']['role']) && stristr($_SERVER['PHP_SELF'],'admin')!= '')
                return true;
            else if(isset($_SESSION['user']['type']) && stristr($_SERVER['PHP_SELF'],'user')!= '')
                return true;   
            
            return false;
        }
        unset($this->user_id);
        return false;
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
}

?>