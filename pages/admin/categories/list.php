<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/categories/list.phtml');

$result = array();
$message = isset($_GET['message'])? $_GET['message']: '';

$offset = isset($_GET['offset'])? $_GET['offset']: 0;
$limit = 20;
$numPages = 0;

try {
    $db = new data_Base();
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
//enhancement formula pager
$div = $offset/$limit;
$lowRange = $div-3;
$maxRange = $div < 3? 6 : $div+3;

$template->display(array('cats' => $result, 'message' => $message, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange));
?>
