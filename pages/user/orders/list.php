<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/orders/list.phtml');

$result = array();
$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
$offset = isset($_GET['offset'])?  $_GET['offset']: 0 ;
$limit = 30;
$numPages = 0;

try {
    $db = new data_Base();
    $DBH = $db->connect();
    
    $stmt = $DBH->prepare('SELECT COUNT(*) FROM orders');
    $stmt->execute();
    $totProd = $stmt->fetch();
    $count = $totProd[0];
    $numPages += intval($count/$limit);
    if($count%$limit != 0){
        $numPages++;
    }
    if($offset != 0 ) $offset *= $limit;
    
    $stmt = $DBH->prepare('SELECT * FROM orders WHERE customers_id = :id LIMIT ' . $offset . ', ' . $limit);
    $stmt->execute(array('id' => $session->getUser_id()));
    $result = $stmt->fetchAll();
    
    foreach ($result as &$row) {
        $stmt = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
        $stmt->execute(array('id' => $row['operator']));
        $op = $stmt->fetch();
        $row['operator'] = $op['name'];
    }

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$lowRange = $offset/$limit-3;
$maxRange = $offset/$limit;
$maxRange < 3? $maxRange = 6 : $maxRange += 3;

$template->display(array('orders' => $result, 'message' => $message, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange));
?>
