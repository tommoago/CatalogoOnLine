<?php

include '../../../classes/Cart.php';
session_start();
isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];
        
$cart->emptyCart();

header('location:list.php');
?>
