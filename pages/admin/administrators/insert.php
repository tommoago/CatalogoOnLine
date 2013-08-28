<?php

$username = 'root';
$password = 'root';

$name = $_POST['name'];
$user = $_POST['user'];
$passwd = $_POST['password'];
$role = $_POST['role'];

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = array('name' => $name, 'user' => $user, 'password' => $passwd, 'role' =>$role);
    $STH = $DBH->prepare('INSERT INTO administrators (name, user, password, role) 
                                           value (:name, :user, :password, :role)');
    $STH->execute($data);

    header('location:show.php?id=' . $DBH->lastInsertId());
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
