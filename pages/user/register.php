<?php

include '../../classes/dataBase.php';
include '../../classes/Mailer.php';

$name = $_POST['name'];
$surname = $_POST['surname'];
$address = $_POST['address'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$cellphone = $_POST['cellphone'];
$active = 0;
$passwd = $_POST['password'];
$type = $_POST['type'];



try {
    $db = new dataBase();
    $DBH = $db->connect();
    //selezione casuale dell'operatore associato
    $STH = $DBH->prepare('SELECT id FROM administrators
                                    ORDER BY RAND()
                                    LIMIT 1');
    $STH->execute();
    $admin = $STH->fetch();
    
    $data = array('name' => $name,
        'surname' => $surname,
        'address' => $address,
        'email' => $email,
        'telephone' => $telephone,
        'cellphone' => $cellphone,
        'active' => $active,
        'password' => $passwd,
        'type' => $type,
        'administrators_id' => $admin['id']);
    $STH2 = $DBH->prepare('INSERT INTO customers (name, 
                                                 surname,
                                                 address,
                                                 email,
                                                 telephone,
                                                 cellphone,
                                                 active,
                                                 password,
                                                 type,
                                                 administrators_id) 
                                           value (:name, 
                                                  :surname,
                                                  :address,
                                                  :email,
                                                  :telephone,
                                                  :cellphone,
                                                  :active,
                                                  :password,
                                                  :type,
                                                  :administrators_id)');
    $STH2->execute($data);
    
    $mailer = new Mailer();
    $mailer->send($email, "lmao", "Register confirmation", "This mail is automatically sent to confirm your sign up.");
    header('location:login.php?message=registration successful, check your mail for confirmation');
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>