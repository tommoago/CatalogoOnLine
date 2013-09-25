<?php
include '../conf/config.php';
include '../conf/twig.php';
include '../classes/Cart.php';

isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();

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
