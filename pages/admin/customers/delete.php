<?php

$username = 'root';
$password = 'root';

$id = $_GET['id'];
$message = '';
$data = array('id' => $id);
try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
