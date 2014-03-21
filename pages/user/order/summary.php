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
    /* //controllo se l'ultimo ordine non è stato confermato, in tal caso provvedo ad aggiungere in coda i dati del presente carrello
     if (isset($_SESSION['user']['oldOrd'])) {
         $stmt3 = $DBH->prepare('SELECT * FROM orders  WHERE customers_id = :id AND  confirmed = 0 AND clients_id = :clients_id');
         $stmt3->execute(array('id' => $_SESSION['user']['id'], 'clients_id' => $_SESSION['client_id']));
         $oldOrd = $stmt3->fetch();

         $stmt4 = $DBH->prepare('SELECT * FROM orders_has_products  WHERE orders_id = :id');
         $stmt4->execute(array('id' => $oldOrd['id']));
         $ordProds = $stmt4->fetchAll();
         foreach ($ordProds as &$ordP) {
             $ordP['qty'] = $ordP['quantity'];
             $ordP['id'] = $ordP['products_id'];
             $ordP['price'] = $ordP['sold_price'];
             //$ordP['old'] = 'yes';
             $cart->addProduct($ordP);
         }
     }*/
    foreach ($cart->getProducts() as $row) {
        $stmt = $DBH->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(array('id' => $row['id']));
        $product = $stmt->fetch();
        $product['qty'] = $row['qty'];

        //mette il prezzo giusto
        $product['price'] = $product['retail_price'];
        /* if (isset($_SESSION['user']['price_range']))
             switch ($_SESSION['user']['price_range']) {
                 case 1 :
                     $product['price'] = $product['wholesale_price'];
                     break;
                 case 3 :
                     $product['price'] = $product['super_price'];
                     break;
             }*/

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
