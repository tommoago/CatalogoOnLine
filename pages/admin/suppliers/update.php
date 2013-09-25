<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];
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
                  'address' =>$address,
                  'id' => $id);

    $STH = $DBH->prepare('UPDATE suppliers SET  
                            name = :name, 
                            description = :description, 
                            piva = :piva, 
                            telephone = :telephone, 
                            fax = :fax,
                            address = :address
                          WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>