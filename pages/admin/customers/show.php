<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/customers/show.phtml');

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
    
    switch ($customer['price_range']) {
            case '1':
                $customer['price_range'] = 'wholesale';
                break;
            case '2':
                $customer['price_range'] = 'retail';
                break;
            case '3':
                $customer['price_range'] = 'super';
                break;
        }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('cus' => $customer));
?>
