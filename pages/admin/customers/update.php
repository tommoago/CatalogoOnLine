<?php
include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];
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
                   'administrators_id' => $admin_id,
                   'id' => $id);

    $STH = $DBH->prepare('UPDATE customers SET  
                            name = :name, 
                            surname = :surname,
                            cod_fis = :cod_fis,
                            piva = :piva,
                            address = :address,
                            email = :email,
                            telephone = :telephone,
                            cellphone = :cellphone,
                            active = :active,
                            password = :password,
                            type = :type,
                            price_range = :price_range,
                            administrators_id = :administrators_id
                          WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    if($e->getCode() == '23000'){
        $message = 'Email already present';
        header('location:prepareUpdate.php?id=' . $id . '&message=' . $message);
        exit;
    }else{
        header('location:prepareUpdate.php?id=' . $id . '&message=' . $e->getMessage());
        exit;
    }
}
?>