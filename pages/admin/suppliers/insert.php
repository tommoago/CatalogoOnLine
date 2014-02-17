<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$name = $_POST['name'];
$description= $_POST['description'];
$piva = $_POST['piva'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$fax = $_POST['fax'];
$address = $_POST['address'];

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $data = array('name' => $name, 
                  'description' => $description, 
                  'piva' => $piva, 
                  'email' => $email, 
                  'telephone' =>$telephone, 
                  'fax' =>$fax,
                  'address' =>$address);

    $STH = $DBH->prepare('INSERT INTO suppliers (name, description, piva, email, telephone, fax, address)
                          VALUE (:name, :description, :piva, :email, :telephone, :fax, :address)');
    $STH->execute($data);
    header('location:show.php?id=' . $DBH->lastInsertId());
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>