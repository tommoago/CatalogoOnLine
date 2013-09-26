<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message= Unauthorized access.'. gettext('unauth')); 
}

$name = $_POST['name'];
$user = $_POST['user'];
$passwd = $_POST['password'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('name' => $name, 'user' => $user, 'password' => md5($passwd), 'role' =>'operator');
    $STH = $DBH->prepare('INSERT INTO administrators (name, user, password, role) 
                                           value (:name, :user, :password, :role)');
    $STH->execute($data);

    header('location:show.php?id=' . $DBH->lastInsertId());
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
