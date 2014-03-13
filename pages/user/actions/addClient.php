<?php
include '../../../conf/config.php';
include '../../../classes/imgUploader.php';
include '../../../classes/Session.php';
$session = new Session();
$name = $_POST['name'];
$mail = $_POST['mail'];
$adr = $_POST['address'];
$zcod = $_POST['zcod'];
$piva = $_POST['piva'];
$codfis = $_POST['codfis'];
$com = $_POST['com'];

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $data = array('name' => $name, 'mail' => $mail, 'address' => $adr, 'zcod' => $zcod, 'piva' => $piva, 'codfis' => $codfis, 'com' => $com);

    $STH = $DBH->prepare('INSERT INTO clients (name, address, mail, zipcode, cod_fis, piva, comuni_id) value (:name, :address, :mail, :zcod, :codfis, :piva, :com)');
    $STH->execute($data);
    $idProd = $DBH->lastInsertId();

    header('location:index.php?client_id=' . $idProd);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
