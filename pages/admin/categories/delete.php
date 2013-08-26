<?php

$username = 'root';
$password = 'root';

$id = $_GET['id'];

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $STH = $DBH->prepare('DELETE FROM categories WHERE id = :id');
    $data = array('id' => $id);
    $STH->execute($data);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
