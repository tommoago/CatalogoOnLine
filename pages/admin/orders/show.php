<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

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

    if (is_numeric($order['customers_id'])) {
        $stmt = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
        $stmt->execute(array('id' => $order['customers_id']));
        $cus = $stmt->fetch();
        $order['customer'] = $cus['name'];
    } else {
        $order['customer'] = $order['customers_id'];
    }
    //sezione che mostrerebbe il dettaglio, ma per come viene selto di implementare la base dati, è inutile.
//    $stmt2 = $DBH->prepare('SELECT * FROM products p, orders_has_products op 
//                            WHERE op.orders_id = :id AND p.id = op.products_id');
//    $stmt2->execute($data);
//    $products = $stmt2->fetchAll();

    $stmt4 = $DBH->prepare('SELECT * FROM invoices WHERE orders_id = :id');
    $stmt4->execute(array('id' => $order['id']));
    $inv = $stmt4->fetch();
    $order['pdf'] = $inv['path'];
    $order['invoice'] = str_replace('orders', 'invoices', $inv['path']);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('ord' => $order, 'message' =>isset($_GET['message'])? $_GET['message']: ''/* , 'products' => $products */));
?>
