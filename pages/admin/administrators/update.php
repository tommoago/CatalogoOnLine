<?php
include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];
$name = $_POST['name'];
$user = $_POST['user'];
$passwd = $_POST['password'];
$role = $_POST['role'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('name' => $name, 'user' => $user, 'password' => $passwd, 'role' =>$role, 'id' => $id);

    $STH = $DBH->prepare('UPDATE administrators SET  
                            name = :name, 
                            user = :user,
                            password = :password,
                            role = :role
                          WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>