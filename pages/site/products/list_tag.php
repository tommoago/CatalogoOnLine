<?php

include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('site/products/list.phtml');

$result = array();
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
$limit = 50;
$numPages = 0;

$col = $_GET['tag'] == 'new'? $_GET['tag'] : 'offer';
try {
    $db = new data_base();
    $DBH = $db->connect();
    
    $stmt = $DBH->prepare('SELECT COUNT(*) FROM products WHERE '.$col.'= 1');
    $stmt->execute(array());
    $totProd = $stmt->fetch();
    
    $count = $totProd[0];
    $numPages += intval($count / $limit);
    if ($count % $limit != 0) {
        $numPages++;
    }
    if ($offset != 0)
        $offset *= $limit;

    $stmt2 = $DBH->prepare('SELECT * FROM products  WHERE '.$col.' = 1 LIMIT '. $offset . ', ' . $limit);
    $stmt2->execute(array());
    $result = $stmt2->fetchAll();

    foreach ($result as &$row) {
        //categoria associata
        $stmt3 = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt3->execute(array('id' => $row['categories_id']));
        $cat = $stmt3->fetch();
        $row['category'] = $cat['name'];

        if(strlen($row['description']) > 150)
        $row['description'] = substr($row['description'], 0, 150) . '...';

        $stmt4 = $DBH->prepare('SELECT * FROM product_images WHERE products_id = :id');
        $stmt4->execute(array('id' => $row['id']));
        $imm = $stmt4->fetch();
        $row['image'] = $imm['path'];

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

$div = $offset/$limit;
$lowRange = $div-3;
$maxRange = $div < 3? 6 : $div+3;

$template->display(array('prods' => $result, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange));
?>
