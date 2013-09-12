<?php
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/*, array('cache' => '../../../templates/cache')*/);
$template = $twig->loadTemplate('admin/products/update.phtml');

$id = $_GET['id'];
$result = array();

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM categories');
    $stmt->execute();
    $result = $stmt->fetchAll();

    $stmt = $DBH->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->execute(array('id' => $id));
    //tira fuori solo un risultato
    $product = $stmt->fetch();
    
    //aggiunta prop per le checkbox
    $product['c_new'] ='';
    $product['c_offer'] ='';
    $product['c_evidence'] ='';
    if($product['new'] == 1){
        $product['c_new'] ='checked';
    }
    if($product['offer'] == 1){
        $product['c_offer'] ='checked';
    }
    if($product['evidence'] == 1){
        $product['c_evidence'] ='checked';
    }
    
    //riporta i prezzi in % rispetto al purchase_price
    $product['wholesale_price'] = ($product['wholesale_price']/$product['purchase_price']-1)*100;
    $product['retail_price'] = ($product['retail_price']/$product['purchase_price']-1)*100;
    $product['super_price'] = ($product['super_price']/$product['purchase_price']-1)*100;
    
    //marca la categoria appartenente 
    foreach($result as &$row) {
      $row['selected'] = '';
      if ($row['id'] == $product['categories_id']){
          $row['selected'] = 'selected';
      }
    } 
    
    //mette immagine
    $stmt3 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
    $stmt3->execute(array('id' => $id));
    $imm = $stmt3->fetch();
    $product['image'] = $imm['path'];
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('prod' => $product, 'cats' => $result));