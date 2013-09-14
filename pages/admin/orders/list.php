<?php

include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('admin/orders/list.phtml');

$result = array();
$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM orders');
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach ($result as &$row) {
        if (is_numeric($row['customers_id'])) {
            $stmt = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
            $stmt->execute(array('id' => $row['customers_id']));
            $cus = $stmt->fetch();
            $row['customer'] = $cus['name'];
        } else {
            $row['customer'] = $row['customers_id'];
        }
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('orders' => $result, 'message' => $message));
?>
