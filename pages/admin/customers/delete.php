<?php
include '../../../classes/dataBase.php';

$id = $_GET['id'];
$message = '';
$data = array('id' => $id);
try {
    $db = new dataBase();
    $DBH = $db->connect();

    //cerco categorie associate
//    $stmt = $DBH->prepare('SELECT * FROM categories WHERE categories_id = :id');
//    $stmt->execute($data);
//    $categories = $stmt->fetchAll();
//
//    if (empty($categories)) {
//        //cerco prodotti associati
//        $STH = $DBH->prepare('SELECT * FROM products WHERE categories_id = :id');
//        $STH->execute($data);
//        $products = $STH->fetchAll();
//        if (empty($products)) {
            //se non ho vincoli, elimino.
            $STH = $DBH->prepare('DELETE FROM customers WHERE id = :id');
            $STH->execute($data);
            $message = 'Delete successful';
//        } else {
//            $message = 'Cannot delete because of depency with associate products';
//        }
//    } else {
//        $message = 'Cannot delete because of depency with another category';
//    }

    header('location:list.php?message=' . $message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>