<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();
session_start();

isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];
$db = new data_base();
$DBH = $db->connect();
$cart->update(array('id' => $_POST['id'], 'qty' => isset($_POST['qty_add']) ? $_POST['qty_add'] : 1));
$stmt = $DBH->prepare('UPDATE orders_has_products SET quantity = :qty WHERE products_id = :prod_id AND orders_id = :cart_id');
$stmt->execute(array('qty' => $_POST['qty_add'], 'prod_id' => $_POST['id'], 'cart_id' => $cart->id));

header('location:list.php');
?>
