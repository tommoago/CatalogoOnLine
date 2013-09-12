<?php
include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$name = $_POST['name'];
$description= $_POST['description'];
$piva = $_POST['piva'];
$telephone = $_POST['telephone'];
$fax = $_POST['fax'];
$address = $_POST['address'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('name' => $name, 
                  'description' => $description, 
                  'piva' => $piva, 
                  'telephone' =>$telephone, 
                  'fax' =>$fax,
                  'address' =>$address);

    $STH = $DBH->prepare('INSERT INTO suppliers (name, description, piva, telephone, fax, address)
                          VALUE (:name, :description, :piva, :telephone, :fax, :address)');
    $STH->execute($data);
    header('location:show.php?id=' . $DBH->lastInsertId());
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>