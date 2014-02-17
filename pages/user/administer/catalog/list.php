<?php
include '../../../../conf/config.php';
include '../../../../conf/twig.php';
include '../../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/administer/catalog/list.phtml');

$result = array();
$offset = isset($_GET['offset'])? $_GET['offset']: 0;
$limit = 20;
$numPages = 0;

try {
    $db = new data_Base();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT COUNT(*) FROM catalog WHERE customers_id = :id');
    $stmt->execute(array('id' => $session->getUser_id()));
    $totProd = $stmt->fetch();
    $count = $totProd[0];
    $numPages += intval($count/$limit);
    if($count%$limit != 0){
        $numPages++;
    }
    if($offset != 0 ) $offset *= $limit;

    $stmt = $DBH->prepare('SELECT * FROM catalog WHERE customers_id = :id LIMIT ' . $offset . ', ' . $limit);
    $stmt->execute(array('id' => $session->getUser_id()));
    $result = $stmt->fetchAll();

    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$div = $offset/$limit;
$lowRange = $div-3;
$maxRange = $div < 3? 6 : $div+3;

$template->display(array('catls' => $result, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange));
?>
