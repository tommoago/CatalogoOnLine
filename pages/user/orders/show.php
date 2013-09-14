<?php
include '../../../classes/dataBase.php';
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache',) */);
$template = $twig->loadTemplate('user/orders/show.phtml');

$id = $_GET['id'];
$result = array();
$data = array('id' => $id);

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM orders WHERE id = :id');
    $stmt->execute($data);
    $order = $stmt->fetch();

    $stmt2 = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
    $stmt2->execute(array('id' => $order['operator']));
    $op = $stmt2->fetch();
    $order['operator'] = $op['name'];

    //sezione che mostrerebbe il dettaglio, ma per come viene selto di implementare la base dati, è inutile.
//    $stmt3 = $DBH->prepare('SELECT * FROM products p, orders_has_products op 
//                            WHERE op.orders_id = :id AND p.id = op.products_id');
//    $stmt3->execute($data);
//    $products = $stmt3->fetchAll();
    
    $stmt4 = $DBH->prepare('SELECT * FROM invoices WHERE orders_id = :id');
    $stmt4->execute(array('id' => $order['id']));
    $inv = $stmt4->fetch();
    $order['file'] = $inv['path'];
    
    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('ord' => $order/*, 'products' => $products*/));
?>
