<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$cod_fis = isset($_POST['cod_fis'])? $_POST['cod_fis']: '';
$piva = isset($_POST['piva'])? $_POST['piva']: '';
$address = $_POST['address'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$cellphone = $_POST['cellphone'];
$passwd = $_POST['password'];

try {
    $db = new data_Base();
    $DBH = $db->connect();

     $data = array('name' => $name, 
                   'surname' => $surname,
                   'cod_fis' => $cod_fis,
                   'address' => $address,
                   'email' => $email,
                   'telephone' => $telephone,
                   'cellphone' => $cellphone,
                   'password' => md5($passwd),
                   'id' => $id);

    $STH = $DBH->prepare('UPDATE customers SET  
                            name = :name, 
                            surname = :surname,
                            cod_fis = :cod_fis,
                            address = :address,
                            email = :email,
                            telephone = :telephone,
                            cellphone = :cellphone,
                            password = :password
                          WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    if($e->getCode() == '23000'){
        $message = gettext('duplicate.mail');
        header('location:prepareUpdate.php?id=' . $id . '&message=' . $message);
        exit;
    }else{
        header('location:prepareUpdate.php?id=' . $id . '&message=' . $e->getMessage());
        exit;
    }
}
?>