<?php

$username = 'root';
$password = 'root';

$name = $_POST['name'];
$categories_id = $_POST['cat_id'];

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);

    $data = array('name' => $name, 'cat_id' => $categories_id);

    $STH = $DBH->prepare('INSERT INTO categories (name, categories_id) value (:name, :cat_id)');
    $STH->execute($data);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
