<?php
include '../../../classes/Cart.php';
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();
isset($_SESSION['cart']) ? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];


if (isset($cart->id)) {
    header('location:../products/catalog.php');
}
if (isset($_GET['client_id'])) {
    $_SESSION['client'] = $_GET['client_id'];
};
$template = $twig->loadTemplate('user/actions/index.phtml');

$db = new data_base();
$DBH = $db->connect();
//controllo se l'ultimo ordine non è stato confermato, in tal caso provvedo ad aggiungere in coda i dati del presente carrello
if (isset($_SESSION['client']) && !isset($cart->ide)) {
    $cart->emptyCart();
    $stmt3 = $DBH->prepare('SELECT * FROM orders  WHERE customers_id = :id AND  confirmed = 0 AND clients_id = :clients_id');
    $stmt3->execute(array('id' => $_SESSION['user']['id'], 'clients_id' => $_SESSION['client']));
    $oldOrd = $stmt3->fetch();
    print_r($oldOrd);
    $cart->id = $oldOrd['id'];
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
        //$ordP['old'] = 'yes';
        print_r($ordP);
        $message = 'old.ord';
        $cart->addProduct(array('id' => $prod['id'], 'description' => $prod['description'], 'price' => $prod['price'],
            'discount_price' => $prod['discount_price'], 'qty' => $ordP['qty'], 'discount' => $ordP['discount']));
    }
}

if (isset($_SESSION['client']))
    $cli = 'ok';


$stmt3 = $DBH->prepare('SELECT * FROM orders  WHERE customers_id = :id AND quotation = 1 AND clients_id = :clients_id');
$stmt3->execute(array('id' => $_SESSION['user']['id'], 'clients_id' => $_SESSION['client']));
$oldOrds = $stmt3->fetchAll();
if (count($oldOrds) > 0)
    $cli = 'ok';
else
    $cli = '';


$template->display(array('message' => $message, 'cli' => $cli));
?>
