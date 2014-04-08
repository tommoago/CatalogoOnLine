<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/clients/list.phtml');
$message = isset($_GET['message'])? $_GET['message']: '';
$result = array();
$offset = isset($_GET['offset'])? $_GET['offset']: 0;
$limit = 50;
$numPages = 0;

try {
    $db = new data_Base();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT COUNT(*) FROM clients');
    $stmt->execute();
    $totProd = $stmt->fetch();
    $count = $totProd[0];
    $numPages += intval($count/$limit);
    if($count%$limit != 0){
        $numPages++;
    }
    if($offset != 0 ) $offset *= $limit;

    $stmt = $DBH->prepare('SELECT * FROM clients LIMIT ' . $offset . ', ' . $limit);
    $stmt->execute();
    $result = $stmt->fetchAll();

    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$div = $offset/$limit;
$lowRange = $div-3;
$maxRange = $div < 3? 6 : $div+3;

$template->display(array('custs' => $result, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange, 'message' => $message));
?>
