<?php
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache',) */);
$template = $twig->loadTemplate('admin/orders/show.phtml');

$id = $_GET['id'];
$result = array();
$data = array('id' => $id);

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM orders WHERE id = :id');
    $stmt->execute($data);
    $order = $stmt->fetch();

    $stmt = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
    $stmt->execute(array('id' => $order['customers_id']));
    $cus = $stmt->fetch();
    $order['customer'] = $cus['name'];

    $stmt = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
    $stmt->execute(array('id' => $order['operator']));
    $op = $stmt->fetch();
    $order['operator'] = $op['name'];

    $stmt2 = $DBH->prepare('SELECT * FROM products p, orders_has_products op 
                            WHERE op.orders_id = :id AND p.id = op.products_id');
    $stmt2->execute($data);
    $products = $stmt2->fetchAll();
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('ord' => $order, 'products' => $products));
?>
