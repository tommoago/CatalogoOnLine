<?php

session_start();
include '../../classes/Session.php';
include '../../classes/dataBase.php';

$user = $_POST['user'];
$passwd = $_POST['password'];
$message = '';


try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('user' => $user, 'password' => md5($passwd));
    $STH = $DBH->prepare('SELECT * FROM administrators WHERE user = :user AND password = :password');
    $STH->execute($data);
    $result = $STH->fetch();
    if (!empty($result)) {
        $_SESSION['user'] = $result;
        header('location:index.php');
    } else {
        $message = 'Invalid credentials';
        header('location:login.php?message=' . $message);
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
