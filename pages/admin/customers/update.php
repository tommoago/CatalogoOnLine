<?php
include '../../../conf/config.php';
include '../../../classes/imgUploader.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];
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

    $data = array('id' => $id, 'name' => $name, 'mail' => $mail, 'address' => $adr, 'zcod' => $zcod, 'piva' => $piva, 'codfis' => $codfis, 'com' => $com);

    $STH = $DBH->prepare('UPDATE clients SET
                            name = :name,
                            address = :address,
                            mail = :mail,
                            zipcode = :zcod,
                            cod_fis = :codfis,
                            piva = :piva,
                            comuni_id = :com

                          WHERE id = :id');
    $STH->execute($data);

    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
