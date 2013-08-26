<?php

require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates/admin/products');
$twig = new Twig_Environment($loader/*, array('cache' => '../../../templates/cache')*/);
$template = $twig->loadTemplate('update.phtml');

$username = 'root';
$password = 'root';
$id = $_GET['id'];
$result = array();

try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
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
    
    //marca la categoria appartenente 
    foreach($result as &$row) {
      $row['selected'] = '';
      if ($row['id'] == $product['categories_id']){
          $row['selected'] = 'selected';
      }
    } 
    
    //mette immagine
    $stmt = $DBH->prepare('SELECT * FROM product_images WHERE id = :id');
    $stmt->execute(array('id' => $id));
    $image = $stmt->fetch();
    $product['image'] =$image['path'];
    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('prod' => $product, 'cats' => $result));
?>
