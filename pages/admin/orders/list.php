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
        $stmt = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
        $stmt->execute(array('id' => $row['customers_id']));
        $cus = $stmt->fetch();
        $row['customer'] = $cus['name'];
        
        $stmt = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
        $stmt->execute(array('id' => $row['operator']));
        $op = $stmt->fetch();
        $row['operator'] = $op['name'];
    }

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('orders' => $result, 'message' => $message));
?>
