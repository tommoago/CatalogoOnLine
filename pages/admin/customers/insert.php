<?php
include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$name = $_POST['name'];
$surname = $_POST['surname'];
$cod_fis = $_POST['cod_fis'];
$piva = $_POST['piva'];
$address = $_POST['address'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$cellphone = $_POST['cellphone'];
$active = 0;
if (isset($_POST['active'])) {
    $active = 1;
}
$passwd = $_POST['password'];
$type = $_POST['type'];
$range = $_POST['price_range'];
$admin_id = $_POST['adm_id'];


try {
    $db = new dataBase();
    $DBH = $db->connect();
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
                  'price_range' => $range,
                  'administrators_id' => $admin_id);
    $STH = $DBH->prepare('INSERT INTO customers (name, 
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
    $STH->execute($data);

    header('location:show.php?id=' . $DBH->lastInsertId());
} catch (PDOException $e) {
    if($e->getCode() == '23000'){
        $message = 'Email already present';
        header('location:prepareInsert.php?message=' . $message);
        exit;
    }else{
        header('location:prepareInsert.php?message=' . $e->getMessage());
        exit;
    }
}
?>
