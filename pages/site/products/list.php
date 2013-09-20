<?php

session_start();
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('site/products/list.phtml');

$result = array();
isset($_GET['offset'])? $offset = $_GET['offset']: $offset =0 ;
$limit = 20;
$numPages = 0;

try {
    $db = new dataBase();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT COUNT(*) FROM products WHERE categories_id = :id');
    $stmt->execute(array('id' => $_GET['id_cat']));
    $totProd = $stmt->fetch();
    $count = $totProd[0];
    $numPages += intval($count / $limit);
    if ($count % $limit != 0) {
        $numPages++;
    }
    if ($offset != 0)
        $offset *= $limit;

    $stmt = $DBH->prepare('SELECT * FROM products  WHERE categories_id = :id LIMIT '
            . $offset . ', ' . $limit);
    $stmt->execute(array('id' => $_GET['id_cat']));
    $result = $stmt->fetchAll();

    foreach ($result as &$row) {
        //categoria associata
        $stmt = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(array('id' => $row['categories_id']));
        $cat = $stmt->fetch();
        $row['category'] = $cat['name'];
        
        $row['description'] = substr($row['description'], 0, 150) .'...';

        //mette il prezzo giusto
        $row['price'] = $row['retail_price'];
        if (isset($_SESSION['user']['price_range']))
            switch ($_SESSION['user']['price_range']) {
                case 1:
                    $row['price'] = $row['wholesale_price'];
                    break;
                case 2:
                    $row['price'] = $row['retail_price'];
                    break;
                case 3:
                    $row['price'] = $row['super_price'];
                    break;
            }
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$lowRange = $offset / $limit - 3;
$maxRange = $offset / $limit;
$maxRange < 3 ? $maxRange = 6 : $maxRange += 3;

$template->display(array('prods' => $result, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange, 'id_cat' => $_GET['id_cat']));
?>
