<?php

$username = 'root';
$password = 'root';

$id = $_GET['id'];

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $STH = $DBH->prepare('DELETE FROM categories WHERE id = :id');
    $data = array('id' => $id);
    $STH->execute($data);
    //TO-DO mettere errori a manego
    header('location:list.php');
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
