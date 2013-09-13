<?php

session_start();
include '../classes/dataBase.php';
require_once '../vendor/twig/twig/lib/Twig/Autoloader.php';


Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('site/show.phtml');

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
    $result['category'] = $result['name'];
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('prods' => $result, 'totPages' => $numPages));
?>
