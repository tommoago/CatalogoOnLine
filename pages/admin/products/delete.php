<?php

$username = 'root';
$password = 'root';

$id = $_GET['id'];

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $STH = $DBH->prepare('DELETE FROM product_images WHERE products_id = :id');
    $data = array('id' => $id);
    $STH->execute($data);
    
    $STH = $DBH->prepare('DELETE FROM products WHERE id = :id');
    $STH->execute($data);
    header('location:list.php');
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>