<?php
include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$name = $_POST['name'];
$categories_id = $_POST['cat_id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('name' => $name);
    if($categories_id != ''){
        $data['cat_id'] = $categories_id;
        $STH = $DBH->prepare('INSERT INTO categories (name, categories_id) value (:name, :cat_id)');
    }else{
        $STH = $DBH->prepare('INSERT INTO categories (name) value (:name)');
    }
    $STH->execute($data);
    
    header('location:show.php?id='.$DBH->lastInsertId());
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
