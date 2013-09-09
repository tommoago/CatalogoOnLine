<?php

session_start();
include '../../classes/Session.php';
include '../../classes/dataBase.php';

$email = $_POST['email'];
$passwd = $_POST['password'];
$message = '';

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('email' => $email, 'password' => $passwd);
    $STH = $DBH->prepare('SELECT * FROM customers WHERE email = :email AND password = :password AND active = 1');
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
