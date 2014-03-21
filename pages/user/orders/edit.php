<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();
isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];
$cart->emptyCart();
$db = new data_base();
$DBH = $db->connect();
$stmt3 = $DBH->prepare('SELECT * FROM orders  WHERE id = :id');
$stmt3->execute(array('id' => $_GET['id']));
$oldOrd = $stmt3->fetch();
$cart->id = $oldOrd['id'];
$cart->ide = $oldOrd['ide'];
$cart->prev = $oldOrd['quotation'];
$_SESSION['client'] = $oldOrd['clients_id'];
$stmt4 = $DBH->prepare('SELECT * FROM orders_has_products  WHERE orders_id = :id');
$stmt4->execute(array('id' => $oldOrd['id']));
$ordProds = $stmt4->fetchAll();
foreach ($ordProds as &$ordP) {

    $stmt5 = $DBH->prepare('SELECT * FROM products  WHERE id = :id');
    $stmt5->execute(array('id' => $ordP['products_id']));
    $prod = $stmt5->fetch();
    $prod['price'] = $prod['retail_price'];
    $prod['discount_price'] = $prod['retail_price'] * (100 - $ordP['discount']) / 100;

    $ordP['qty'] = $ordP['quantity'];
    $ordP['id'] = $ordP['products_id'];
//$ordP['price'] = $ordP['sold_price'];
    $ordP['old'] = 'yes';
//    $message = 'old.ord';
    print_r(array('id' => $prod['id'], 'description' => $prod['description'], 'price' => $prod['price'],
        'discount_price' => $prod['discount_price'], 'qty' => $ordP['qty'], 'discount' => $ordP['discount']));
    $cart->addProduct(array('id' => $prod['id'], 'description' => $prod['description'], 'price' => $prod['price'],
        'discount_price' => $prod['discount_price'], 'qty' => $ordP['qty'], 'discount' => $ordP['discount']));


}
header('location:../cart/list.php');

?>


