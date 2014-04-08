<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/quotation/quotationByClient.phtml');

$result = array();
$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
$limit = 30;
$numPages = 0;
$client = $_GET['id'];
try {
    $db = new data_Base();
    $DBH = $db->connect();

    $stmt = $DBH->prepare('SELECT COUNT(*) FROM orders WHERE customers_id = :id AND confirmed = 1 AND quotation = 1 AND clients_id = :id_client');
    $stmt->execute(array('id' => $_SESSION['user']['id'], 'id_client' => $client));
    $totProd = $stmt->fetch();
    $count = $totProd[0];
    $numPages += intval($count / $limit);
    if ($count % $limit != 0) {
        $numPages++;
    }
    if ($offset != 0) $offset *= $limit;

    $stmt2 = $DBH->prepare('SELECT * FROM orders WHERE customers_id = :id AND confirmed = 1 AND quotation = 1 AND clients_id = :id_client LIMIT ' . $offset . ', ' . $limit);
    $stmt2->execute(array('id' => $_SESSION['user']['id'], 'id_client' => $client));
    $result = $stmt2->fetchAll();

    foreach ($result as &$row) {
        $stmt3 = $DBH->prepare('SELECT * FROM clients WHERE id = :id');
        $stmt3->execute(array('id' => $row['clients_id']));
        $cl = $stmt3->fetch();
        $row['client'] = $cl['name'];

        $stmt4 = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
        $stmt4->execute(array('id' => $row['customers_id']));
        $user = $stmt4->fetch();
        $row['iden'] = $user['name'][0] . $user['surname'][0] . $row['ide'];
    }

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$lowRange = $offset / $limit - 3;
$maxRange = $offset / $limit;
$maxRange < 3 ? $maxRange = 6 : $maxRange += 3;

$template->display(array('orders' => $result, 'message' => $message, 'totPages' => $numPages, 'lr' => $lowRange, 'mr' => $maxRange));
?>
