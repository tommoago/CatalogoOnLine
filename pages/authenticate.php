<?php

include '../conf/config.php';
include '../classes/Session.php';

$email = $_POST['email'];
$passwd = $_POST['password'];
$message = '';

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $data = array('email' => $email, 'password' => md5($passwd));
    $STH = $DBH->prepare('SELECT * FROM customers WHERE email = :email AND password = :password ');
    $STH->execute($data);
    $result = $STH->fetch();

    if (!empty($result)) {
        $_SESSION['user'] = $result;
        if ($result['admin'] == 1) {
            header('location:admin/index.php');
        } else {
            header('location:user/index.php');
        }
    } else {
        $message = gettext('invalid.cred');;
        header('location:login.php?message=' . $message);
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
