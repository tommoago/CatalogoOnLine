<?php

$username = 'root';
$password = 'root';

$id = $_GET['id'];

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
   
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
