<?php
include '../../../conf/config.php';
include '../../../classes/imgUploader.php';
include '../../../classes/Session.php';
$session = new Session();
$name = $_POST['name'];
$surname = $_POST['surname'];
$mail = $_POST['mail'];
$password = md5($_POST['password']);
$adr = $_POST['address'];
$tel = $_POST['telephone'];
$cell = $_POST['cellphone'];
$adr = $_POST['address'];
$admin = 0;
if (isset($_POST['admin'])) {
    $admin = 1;
}
$codfis = $_POST['codfis'];


try {
    $db = new data_Base();
    $DBH = $db->connect();
    $data = array('name' => $name, 'mail' => $mail, 'address' => $adr, 'surname' => $surname,
        'telephone' => $tel, 'codfis' => $codfis, 'cell' => $cell, 'password' => $password, 'admin' => $admin);

    $STH = $DBH->prepare('INSERT INTO customers (name, address, email, surname, cod_fis, telephone, cellphone, admin, password)
    value (:name, :address, :mail, :surname, :codfis, :telephone, :cell, :admin, :password)');
    $STH->execute($data);
    $idProd = $DBH->lastInsertId();

    header('location:show.php?id=' . $idProd);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
