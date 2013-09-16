<?php

include '../../../classes/Cart.php';
session_start();
isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$cart->addProduct(array('id' => $_GET['id'], 'qty' => isset($_GET['qty'])? $_GET['qty']: 1));

header('location:list.php');
?>
