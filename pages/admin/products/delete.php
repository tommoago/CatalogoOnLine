<?php
include '../../../classes/dataBase.php';

$id = $_GET['id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
   
    $stmt3 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
    $stmt3->execute(array('id' => $id));
    $imm = $stmt3->fetch();
    
    $STH = $DBH->prepare('DELETE FROM product_images WHERE products_id = :id');
    $data = array('id' => $id);
    $STH->execute($data);
    
    $STH = $DBH->prepare('DELETE FROM products WHERE id = :id');
    $STH->execute($data);
    
    unlink('../../'.$imm['path']);
    header('location:list.php');
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
