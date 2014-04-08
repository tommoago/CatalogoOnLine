<?php
include '../../../conf/config.php';
include '../../../classes/Cart.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();
unset($_SESSION['cart']);
$_SESSION['client'] = null;
header('location: ../index.php');

?>