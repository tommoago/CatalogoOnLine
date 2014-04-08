<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../classes/Session.php';
session_start();

isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];
$db = new data_base();
$DBH = $db->connect();
$stmt = $DBH->prepare('DELETE FROM orders_has_products WHERE products_id = :prod_id AND orders_id = :cart_id');
$stmt->execute(array('prod_id' => $_GET['id'], 'cart_id' => $cart->id));
$cart->removeProduct($_GET['id']);
$stmt = $DBH->prepare('SELECT * FROM orders_has_products WHERE orders_id = :cart_id');
$stmt->execute(array('cart_id' => $cart->id));
if (!$stmt->fetchAll()) {
    header('location:empty.php');
}


header('location:list.php');
?>
