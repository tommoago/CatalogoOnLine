<?php

include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('admin/products/list.phtml');

$result = array();
$offset = $_GET['offset'];
$limit = 20;
$numPages = 0;

try {
    $db = new dataBase();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT COUNT(*) FROM products');
    $stmt->execute();
    $totProd = $stmt->fetch();
    $count = $totProd[0];
    $numPages += intval($count/$limit);
    if($count%$limit != 0){
        $numPages++;
    }
    if($offset != 0 ) $offset *= $limit;

    $stmt = $DBH->prepare('SELECT * FROM products LIMIT ' . $offset . ', ' . $limit);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as &$row) {
        $stmt = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(array('id' => $row['categories_id']));
        $cat = $stmt->fetch();
        $row['category'] = $cat['name'];
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('prods' => $result, 'totPages' => $numPages));
?>
