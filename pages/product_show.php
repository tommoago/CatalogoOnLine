<?php

session_start();
include '../classes/dataBase.php';
require_once '../vendor/twig/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('site/products/show.phtml');

$result = array();


try {
    $db = new dataBase();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT * FROM products  WHERE id = :id');
    $stmt->execute(array('id' => $_GET['id']));
    $result = $stmt->fetch();

    $stmt2 = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
    $stmt2->execute(array('id' => $result['categories_id']));
    $cat = $stmt2->fetch();
    $result['category'] = $cat['name'];

    $stmt3 = $DBH->prepare('SELECT * FROM suppliers WHERE id = :id');
    $stmt3->execute(array('id' => $result['suppliers_id']));
    $sup = $stmt3->fetch();
    $result['supplier'] = $sup['name'];

    $stmt4 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
    $stmt4->execute(array('id' => $result['id']));
    $imm = $stmt4->fetch();
    $result['image'] = $imm['path'];

    //mette il prezzo giusto
    $result['price'] = $result['retail_price'];
    if (isset($_SESSION['user']['price_range']))
        switch ($_SESSION['user']['price_range']) {
            case 1:
                $result['price'] = $result['wholesale_price'];
                break;
            case 2:
                $result['price'] = $result['retail_price'];
                break;
            case 3:
                $result['price'] = $result['super_price'];
                break;
        }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('prod' => $result));
?>
