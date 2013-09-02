<?php
include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$name = $_POST['name'];
$user = $_POST['user'];
$passwd = $_POST['password'];
$role = $_POST['role'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('name' => $name, 'user' => $user, 'password' => $passwd, 'role' =>$role);
    $STH = $DBH->prepare('INSERT INTO administrators (name, user, password, role) 
                                           value (:name, :user, :password, :role)');
    $STH->execute($data);

    header('location:show.php?id=' . $DBH->lastInsertId());
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
