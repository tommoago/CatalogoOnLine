<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/customers/list.phtml');

$result = array();
$message = isset($_GET['message'])? $_GET['message']: '';

$offset = isset($_GET['offset'])? $_GET['offset']: 0;
$limit = 20;
$numPages = 0;

try {
    $db = new data_Base();
    $DBH = $db->connect();
    
    $stmt = $DBH->prepare('SELECT COUNT(*) FROM customers');
    $stmt->execute();
    $totProd = $stmt->fetch();
    $count = $totProd[0];
    $numPages += intval($count/$limit);
    if($count%$limit != 0){
        $numPages++;
    }
    if($offset != 0 ) $offset *= $limit;
    
    $stmt2 = $DBH->prepare('SELECT * FROM customers LIMIT ' . $offset . ', ' . $limit);
    $stmt2->execute();
    $result = $stmt2->fetchAll();

    foreach ($result as &$row) {
        $stmt2 = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
        $stmt2->execute(array('id' => $row['administrators_id']));
        $adm = $stmt2->fetch();
        $row['operator'] = $adm['user'];
        switch ($row['price_range']) {
            case '1':
                $row['price_range'] = 'wholesale';
                break;
            case '2':
                $row['price_range'] = 'retail';
                break;
            case '3':
                $row['price_range'] = 'super';
                break;
        }
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$div = $offset/$limit;
$lowRange = $div-3;
$maxRange = $div < 3? 6 : $div+3;

$template->display(array('customers' => $result, 'message' => $message, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange));
?>
