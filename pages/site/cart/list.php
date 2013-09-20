<?php

include '../../../classes/Cart.php';
session_start();
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('site/cart/list.phtml');

isset($_SESSION['cart'])? : $_SESSION['cart'] = new Cart();
$cart = $_SESSION['cart'];

$result = array();

try {
    $db = new dataBase();
    $DBH = $db->connect();

    foreach ($cart->getProducts() as $row) {
        $stmt = $DBH->prepare('SELECT * FROM products  WHERE id = :id');
        $stmt->execute(array('id' => $row['id']));
        $product = $stmt->fetch();
        $product['qty'] = $row['qty'];

        $product['description'] = substr($product['description'], 0, 150) .'...';
        
        //mette il prezzo giusto
        $product['price'] = $product['retail_price'];
        if (isset($_SESSION['user']['price_range']))
            switch ($_SESSION['user']['price_range']) {
                case 1:
                    $product['price'] = $product['wholesale_price'];
                    break;
                case 3: 
                    $product['price'] = $product['super_price'];
                    break;
            }

        $stmt2 = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt2->execute(array('id' => $product['categories_id']));
        $cat = $stmt2->fetch();
        $product['category'] = $cat['name'];

        $result[] = $product;
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('prods' => $result, 'tot' => $cart->getTot()));
?>
