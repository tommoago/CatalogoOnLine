<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/products/update.phtml');

$id = $_GET['id'];
$result = array();

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM categories');
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    $stmt2 = $DBH->prepare('SELECT * FROM suppliers');
    $stmt2->execute();
    $result2 = $stmt2->fetchAll();

    $stmt3 = $DBH->prepare('SELECT * FROM products WHERE id = :id');
    $stmt3->execute(array('id' => $id));
    //tira fuori solo un risultato
    $product = $stmt3->fetch();
    
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
    $product['wholesale_price'] = round(($product['wholesale_price']/$product['purchase_price']-1)*100,2);
    $product['retail_price'] = round(($product['retail_price']/$product['purchase_price']-1)*100,2);
    $product['super_price'] = round(($product['super_price']/$product['purchase_price']-1)*100,2);
    
    //marca la categoria appartenente 
    foreach($result as &$row) {
      $row['selected'] = '';
      if ($row['id'] == $product['categories_id']){
          $row['selected'] = 'selected';
      }
    }
    
    //marca il fornitore appartenente 
    foreach($result2 as &$row) {
      $row['selected'] = '';
      if ($row['id'] == $product['suppliers_id']){
          $row['selected'] = 'selected';
      }
    } 
    
    //mette immagine
    $stmt4 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
    $stmt4->execute(array('id' => $id));
    $imm = $stmt4->fetch();
    $product['image'] = $imm['path'];
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('prod' => $product, 'cats' => $result, 'supps' => $result2, 'message' => isset($_GET['message'])? $_GET['message'] :''));