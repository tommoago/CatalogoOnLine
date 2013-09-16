<?php

session_start();
include '../../../classes/Cart.php';
isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$cart->addProduct(array('id' => $_GET['id'], 'qty' => $_GET['qty']));

header('location:list.php');
?>
