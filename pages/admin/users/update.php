<?php
include '../../../conf/config.php';
include '../../../classes/imgUploader.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$mail = $_POST['mail'];
$password = $_POST['password'];
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

    if ($password != '') {
        $password = md5($password);
        $data = array('id' => $id, 'name' => $name, 'mail' => $mail, 'address' => $adr, 'surname' => $surname,
            'telephone' => $tel, 'codfis' => $codfis, 'cell' => $cell, 'password' => $password, 'admin' => $admin);


        $STH = $DBH->prepare('UPDATE customers SET
                            name = :name,
                            address = :address,
                            email = :mail,
                            cod_fis = :codfis,
                            password = :password,
                            surname = :surname,
                            telephone = :telephone,
                            cellphone = :cell,
                            admin = :admin

                          WHERE id = :id');
        $STH->execute($data);
    } else {
        $data = array('id' => $id, 'name' => $name, 'mail' => $mail, 'address' => $adr, 'surname' => $surname,
            'telephone' => $tel, 'codfis' => $codfis, 'cell' => $cell, 'admin' => $admin);
        $STH = $DBH->prepare('UPDATE customers SET
                            name = :name,
                            address = :address,
                            email = :mail,
                            cod_fis = :codfis,
                            surname = :surname,
                            telephone = :telephone,
                            cellphone = :cell,
                            admin = :admin

                          WHERE id = :id');
        $STH->execute($data);
    }
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
