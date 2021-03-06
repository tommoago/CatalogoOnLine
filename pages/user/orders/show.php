<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig -> loadTemplate('user/orders/show.phtml');

$id = $_GET['id'];
$result = array();
$data = array('id' => $id);

try {
	$db = new data_Base();
	$DBH = $db -> connect();
	$stmt = $DBH -> prepare('SELECT * FROM orders WHERE id = :id');
	$stmt -> execute($data);
	$order = $stmt -> fetch();

	$stmt2 = $DBH -> prepare('SELECT * FROM clients WHERE id = :id');
	$stmt2 -> execute(array('id' => $order['clients_id']));
	$cl = $stmt2 -> fetch();
	$order['client'] = $cl['name'];

	//sezione che mostrerebbe il dettaglio, ma per come viene selto di implementare la base dati, è inutile.
	$stmt3 = $DBH -> prepare('SELECT * FROM products p, orders_has_products op 
                           WHERE op.orders_id = :id AND p.id = op.products_id');
	$stmt3 -> execute($data);
	$products = $stmt3 -> fetchAll();

	$stmt4 = $DBH -> prepare('SELECT * FROM invoices WHERE orders_id = :id');
	$stmt4 -> execute(array('id' => $order['id']));
	$inv = $stmt4 -> fetch();
	$order['file'] = $inv['path'];

} catch (PDOException $e) {
	echo 'ERROR: ' . $e -> getMessage();
}

$template -> display(array('ord' => $order, 'products' => $products));
?>
