<?php

include '../../../classes/Cart.php';
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('site/order/sumary.phtml');

isset($_SESSION['cart'])? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$data = array('data' => date("Y-m-d H:i:s"), 'confirmed' => 0, 'cus_id' => $session->getUser_id());

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('INSERT INTO orders(data, confirmed, operator, customers_id)
                                VALUES(:data, :confirmed, cus_id)');
    $stmt->execute($data);

    $ord_id = $DBH->lastInsertId();
    foreach ($cart->getProducts() as $row) {
        $stmt2 = $DBH->prepare('INSERT INTO orders_has_products (orders_id, products_id,
                                                                quantity, sold_price)
                                        VALUES(:ord_id, :prod_id, :qty, :sold_price)');

        $stmt2->execute(array('ord_id' => $ord_id, 'prod_id' => $row['id'], 'qty' => $row['qty'], 'sold_price' => $row['price'],));
    }
    $message = 'Your order has been processed, you will be recontacted from an operator.';
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('confirmed' => 'yes', 'message' => $message));
?>
