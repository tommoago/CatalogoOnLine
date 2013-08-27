<?php

$username = 'root';
$password = 'root';

$id = $_POST['id'];
$name = $_POST['name'];

$img = new imgUploader();
$img->startUpload($_FILES['uploaded']['name'], $_FILES['uploaded']['tmp_name']);
$pathName = $img->getPathName();


$categories_id = $_POST['cat_id'];

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);

    $data = array('name' => $name, 'cat_id' => $categories_id, 'id' => $id);

    $STH = $DBH->prepare('UPDATE categories SET  
                            name = :name, 
                            categories_id =  :cat_id
                          WHERE id = :id');
    $STH->execute($data);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>