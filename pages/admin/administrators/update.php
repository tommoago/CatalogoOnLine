<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message='. gettext('unauth')); 
}

$id = $_POST['id'];
$name = $_POST['name'];
$user = $_POST['user'];
$passwd = $_POST['password'];
$role = $_POST['role'];

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $data = array('name' => $name, 'user' => $user, 'password' => md5($passwd), 'id' => $id);

    $STH = $DBH->prepare('UPDATE administrators SET  
                            name = :name, 
                            user = :user,
                            password = :password
                          WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>