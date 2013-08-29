<?php

$username = 'root';
$password = 'root';

$id = $_GET['id'];

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
     $data = array('id' => $id);

    $STH = $DBH->prepare('UPDATE orders SET  
                            confirmed = 1
                          WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>