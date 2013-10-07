<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/products/list.phtml');

$result = array();
$offset = isset($_GET['offset'])? $_GET['offset']: 0;
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
        if(strlen($row['description']) > 150)
        $row['description'] = substr($row['description'], 0, 80) .'...';
        
        $stmt = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(array('id' => $row['categories_id']));
        $cat = $stmt->fetch();
        $row['category'] = $cat['name'];
        
        $stmt2 = $DBH->prepare('SELECT * FROM suppliers WHERE id = :id');
        $stmt2->execute(array('id' => $row['suppliers_id']));
        $sup = $stmt2->fetch();
        $row['supplier'] = $sup['name'];
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$div = $offset/$limit;
$lowRange = $div-3;
$maxRange = $div < 3? 6 : $div+3;

$template->display(array('prods' => $result, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange));
?>
