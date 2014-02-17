<?php
include '../../conf/config.php';
include '../../classes/Session.php';

$user = $_POST['user'];
$passwd = $_POST['password'];

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $data = array('user' => $user, 'password' => md5($passwd));
    $STH = $DBH->prepare('SELECT * FROM administrators WHERE user = :user AND password = :password');
    $STH->execute($data);
    $result = $STH->fetch();
    if (!empty($result)) {
        $_SESSION['user'] = $result;
        header('location:index.php');
    } else {
        header('location:login.php?message=' . gettext('invalid.cred'));
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
