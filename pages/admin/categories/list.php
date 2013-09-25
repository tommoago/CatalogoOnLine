<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/categories/list.phtml');

$result = array();
$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
isset($_GET['offset'])? $offset = $_GET['offset']: $offset =0 ;
$limit = 20;
$numPages = 0;

try {
    $db = new dataBase();
    $DBH = $db->connect();
    
    $stmt = $DBH->prepare('SELECT COUNT(*) FROM categories');
    $stmt->execute();
    $totProd = $stmt->fetch();
    $count = $totProd[0];
    $numPages += intval($count/$limit);
    if($count%$limit != 0){
        $numPages++;
    }
    if($offset != 0 ) $offset *= $limit;
    
    $stmt = $DBH->prepare('SELECT * FROM categories LIMIT ' . $offset . ', ' . $limit);
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as &$row) {
        $stmt = $DBH->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(array('id' => $row['categories_id']));
        $stmt->execute();
        $cat = $stmt->fetch();
        $row['category'] = $cat['name'];
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$lowRange = $offset/$limit-3;
$maxRange = $offset/$limit;
$maxRange < 3? $maxRange = 6 : $maxRange += 3;

$template->display(array('cats' => $result, 'message' => $message, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange));
?>
