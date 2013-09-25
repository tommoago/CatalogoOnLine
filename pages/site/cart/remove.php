<?php
include '../../../classes/Cart.php';
session_start();

isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];
        
$cart->removeProduct($_GET['id']);

header('location:list.php');
?>
