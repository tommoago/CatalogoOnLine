<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../classes/Session.php';
include '../../../classes/PrintOrder.php';
session_start();
isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];
$db = new data_base();
$DBH = $db->connect();
$stmt = $DBH->prepare('DELETE FROM orders_has_products WHERE orders_id = :o_id');
$stmt->execute(array('o_id' => $cart->id));
$pdf = new PrintOrder($cart->id);
$pdf->deletePDF();
if (file_exists($pdf->getPath())) {
    unlink($pdf->getPath());
}
$stmt2 = $DBH->prepare('DELETE FROM orders WHERE id = :o_id');
$stmt2->execute(array('o_id' => $cart->id));
$cart->emptyCart();
$_SESSION['client'] = null;

header('location:../index.php');
?>
