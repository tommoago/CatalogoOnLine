<?php

$username = 'root';
$password = 'root';

$name = $_POST['name'];
$surname = $_POST['surname'];
$address = $_POST['address'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$cellphone = $_POST['cellphone'];
$active = 0;
if (isset($_POST['active'])) {
    $active = 1;
}
$passwd = $_POST['password'];
$admin_id = $_POST['adm_id'];


try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = array('name' => $name, 
                  'surname' => $surname,
                  'address' => $address,
                  'email' => $email,
                  'telephone' => $telephone,
                  'cellphone' => $cellphone,
                  'active' => $active,
                  'password' => $passwd,
                  'administrators_id' => $admin_id);
    $STH = $DBH->prepare('INSERT INTO customers (name, 
                                                 surname,
                                                 address,
                                                 email,
                                                 telephone,
                                                 cellphone,
                                                 active,
                                                 password,
                                                 administrators_id) 
                                           value (:name, 
                                                  :surname,
                                                  :address,
                                                  :email,
                                                  :telephone,
                                                  :cellphone,
                                                  :active,
                                                  :password,
                                                  :administrators_id)');
    $STH->execute($data);

    header('location:show.php?id=' . $DBH->lastInsertId());
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
