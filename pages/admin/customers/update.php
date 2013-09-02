<?php
include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];
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
    $db = new dataBase();
    $DBH = $db->connect();

     $data = array('name' => $name, 
                   'surname' => $surname,
                   'address' => $address,
                   'email' => $email,
                   'telephone' => $telephone,
                   'cellphone' => $cellphone,
                   'active' => $active,
                   'password' => $passwd,
                   'administrators_id' => $admin_id,
                   'id' => $id);

    $STH = $DBH->prepare('UPDATE customers SET  
                            name = :name, 
                            surname = :surname,
                            address = :address,
                            email = :email,
                            telephone = :telephone,
                            cellphone = :cellphone,
                            active = :active,
                            password = :password,
                            administrators_id = :administrators_id
                          WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>