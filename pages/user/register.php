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
                                    WHERE role NOT IN ("jack")
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
        //per default alla registrazione uno user ha il prezzo al dettaglio.
        'price_range' => 2,
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
                                                 price_range,
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
                                                  :price_range,
                                                  :administrators_id)');
    $STH2->execute($data);

    $splitted = split('/', $_SERVER['HTTP_REFERER']);
    $relativeDir = '';

    for ($i = 0; $i < sizeof($splitted) - 1; $i++) {
        $relativeDir .= $splitted[$i] . '/';
    }

    $link = $relativeDir . "activate.php?id=" . $DBH->lastInsertId();
    $mailer = new Mailer();
    $mailer->send($email, "", "Register confirmation", "This mail is automatically sent to confirm your sign up,
                                                        please click the link below to activate your account:\n"
                                                        . $link);
    header('location:login.php?message=registration successful, check your mail for confirmation');
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
