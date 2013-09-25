<?php
include '../../conf/config.php';
include '../../classes/Mailer.php';

$name = $_POST['name'];
$surname = $_POST['surname'];
$cod_fis = $_POST['cod_fis'];
$piva = $_POST['piva'];
$address = $_POST['address'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$cellphone = $_POST['cellphone'];
$active = 0;
$passwd = $_POST['password'];
$type = $_POST['type'];

$message = '';

try {
    $db = new dataBase();
    $DBH = $db->connect();
//selezione casuale dell'operatore associato (escluso jack);
    $STH = $DBH->prepare('SELECT id FROM administrators
                                    WHERE role NOT IN ("jack")
                                    ORDER BY RAND()
                                    LIMIT 1');
    $STH->execute();
    $admin = $STH->fetch();

    $data = array('name' => $name,
        'surname' => $surname,
        'cod_fis' => $cod_fis,
        'piva' => $piva,
        'address' => $address,
        'email' => $email,
        'telephone' => $telephone,
        'cellphone' => $cellphone,
        'active' => $active,
        'password' => md5($passwd),
        'type' => $type,
        //per default alla registrazione uno user ha il prezzo al dettaglio.
        'price_range' => 2,
        'administrators_id' => $admin['id']);
    $STH2 = $DBH->prepare('INSERT INTO customers (name, 
                                                surname,
                                                cod_fis,
                                                piva,
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
                                                 :cod_fis,
                                                 :piva,
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

    for ($i = 0; $i < sizeof($splitted) - 1; $i++)
        $relativeDir .= $splitted[$i] . '/';

    $link = $relativeDir . "activate.php?id=" . $DBH->lastInsertId();
    $mailer = new Mailer();
    $mailer->send($email, "", "Register confirmation", "This mail is automatically sent to confirm your sign up,
                                                        please click the link below to activate your account:\n" . $link);
    $message = 'registration successful, check your mail for confirmation';
    header('location:login.php?message=' . $message);
} catch (PDOException $e) {
    if($e->getCode() == '23000'){
        $message = 'Email already present';
        header('location:sign_up.php?message=' . $message);
        exit;
    }else{
        header('location:sign_up.php?message=' . $e->getMessage());
        exit;
    }
}
?>
