<?php

session_start();
include '../classes/Cart.php';
include '../classes/dataBase.php';
require_once '../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();


$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('site/who.phtml');

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM company_images');
    $stmt->execute();
    $result = $stmt->fetchAll();
    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}


$template->display(array('index' =>'yes', 'images' => $result));
?>
