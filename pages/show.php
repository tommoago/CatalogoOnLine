<?php
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader /* ,array('cache' => '../../../templates/cache',) */);
$template = $twig->loadTemplate('admin/products/show.phtml');

$id = $_GET['id'];
$result = array();

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->execute(array('id' => $id));
    $product = $stmt->fetch();
    
    $stmt2 = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
    $stmt2->execute(array('id' => $product['categories_id']));
    $cat = $stmt2->fetch();
    $product['category'] = $cat['name'];
    
    $stmt3 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
    $stmt3->execute(array('id' => $id));
    $imm = $stmt3->fetch();
    $product['image'] = $imm['path'];
    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('prod' => $product));
?>