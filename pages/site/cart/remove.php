<?php

session_start();
include '../../../classes/Cart.php';
isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];
        
$cart->removeProduct($_GET['id']);

header('location:list.php');
?>
