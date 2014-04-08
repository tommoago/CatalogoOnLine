<?php

include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/order/summary.phtml');

isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$result = array();
$ordProds = array();

try {
    $db = new data_base();
    $DBH = $db->connect();
    foreach ($cart->getProducts() as $row) {
        $stmt = $DBH->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(array('id' => $row['id']));
        $product = $stmt->fetch();
        $product['qty'] = $row['qty'];

        $product['price'] = $row['discount_price'];

        $product['row_price'] = $row['qty'] * $row['discount_price'];

        $stmt2 = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt2->execute(array('id' => $product['categories_id']));
        $cat = $stmt2->fetch();
        $product['category'] = $cat['name'];

        $result[] = $product;
    }
    $clients = null;
    $client = null;
    if (isset($_SESSION['client'])) {
        $stmt3 = $DBH->prepare('SELECT * FROM clients WHERE id = :id');
        $stmt3->execute(array('id' => $_SESSION['client']));
        $client = $stmt3->fetch();
    } else {
        $stmt3 = $DBH->prepare('SELECT * FROM clients');
        $stmt3->execute();
        $clients = $stmt3->fetchAll();
    };

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
$template->display(array('prods' => $result, 'tot' => $cart->getTot(), 'clients' => isset($clients) ? $clients : '', 'client' => isset($client) ? $client : '', 'prev' => $cart->prev));
?>
