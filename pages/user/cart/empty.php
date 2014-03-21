<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../classes/Session.php';
session_start();

isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$db = new data_base();
$DBH = $db->connect();
$stmt = $DBH->prepare('DELETE FROM orders_has_products WHERE orders_id = :o_id');
$stmt->execute(array('o_id' => $cart->id));
$stmt2 = $DBH->prepare('DELETE FROM orders WHERE id = :o_id');
$stmt2->execute(array('o_id' => $cart->id));
$cart->emptyCart();

header('location:list.php');
?>
