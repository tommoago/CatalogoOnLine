<?php

include '../../../classes/Cart.php';
session_start();

isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$cart->update(array('id' => $_POST['id'], 'qty' => isset($_POST['qty_add'])? $_POST['qty_add']: 1));

header('location:list.php');
?>
