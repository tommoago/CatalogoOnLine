<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/profile/show.phtml');

$id = $_GET['id'];
$result = array();

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
    $stmt->execute(array('id' => $id));
    $customer = $stmt->fetch();
    
    $stmt2 = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
    $stmt2->execute(array('id' => $customer['administrators_id']));
    $adm = $stmt2->fetch();
    $customer['operator'] = $adm['user'];
    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cus' => $customer));
?>
