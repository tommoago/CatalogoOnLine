<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_POST['id'];
$name = $_POST['name'];
$categories_id = $_POST['cat_id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
    
    if($categories_id != ''){
        $data = array('name' => $name, 'cat_id' => $categories_id, 'id' => $id);
        $STH = $DBH->prepare('UPDATE categories SET  
                                name = :name, 
                                categories_id =  :cat_id
                              WHERE id = :id');
    }else{
        $data = array('name' => $name, 'id' => $id);
        $STH = $DBH->prepare('UPDATE categories SET  
                                name = :name
                              WHERE id = :id');
    }
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>